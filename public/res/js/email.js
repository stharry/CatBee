$(document).ready(function () {
    CreateAndInitializeEmailForm();
});


function CreateAndInitializeEmailForm() {
//    $(".mailmodalbox").fancybox({
//        helpers:{
//            title:{
//                type:'inside'
//            },
//            overlay:{
//                css:{
//                    'background':'rgba(238,238,238,0.85)'
//                }
//            }
//        }
//    });
    $("#contact").submit(function () {
        return false;
    });

    $("#emailSubmit").click(function () {


        var emailval = $("#mail-input").val();
        var msgval = $("#message").val();
        var msglen = msgval.length;
        var mailvalid = validateEmail(emailval);

        if (mailvalid == false) {
            $("#mail-input").addClass("error");
        }
        else if (mailvalid == true) {
            $("#mail-input").removeClass("error");
        }

        if (msglen < 4) {
            $("#message").addClass("error");
        }
        else if (msglen >= 4) {
            $("#message").removeClass("error");
        }

        if (mailvalid == true && msglen >= 4) {
            // if both validate we attempt to send the e-mail
            // first we hide the submit btn so the user doesnt click twice
            //$("#emailSubmit").replaceWith("<em>sending...</em>");

            var postData = createCatBeeShareRequest();
            var sharePoint = getCatBeeShareUrl();

            $.ajax({
                type:'POST',
                url:sharePoint,
                dataType: 'json',
                data: postData,

                timeout: 7200,

                error: function(xhr, textStatus, error){

                    handleEmailResponse(xhr.responseText);
                },

                success:function (data) {

                    handleEmailResponse(data);
                }

            });
        }
    });
}

function validateEmail(email) {
    var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return reg.test(email);
}

function getCatBeeShareUrl()
{
    return $("#catBeeSharePoint").text()
}

function createCatBeeShareRequest() {
    return {
        action:'share',
        context:{

            sendFrom:$("#leaderEmail").text(),
            sendTo:$("#mail-input").val(),
            message:$("#message").val(),
            subject:$("#message").val(),
            context:{
                type:'email'
            },
            store:{
                authCode:$("#storeCode").text()
            }
        }
    };
}

function handleEmailResponse(responseText)
{

    if (responseText.toLowerCase().indexOf("status:ok") > 0) {

        $.fancybox("Message sent");

//        $("#contact").fadeOut("fast", function () {
//            $(this).before("<p><strong>Success! Your feedback has been sent, thanks :)</strong></p>");
            setTimeout("$.fancybox.close()", 1000);
//        });
    }
    else {
        //todo $.fancybox("Message sending failed. \n" + responseText);
        $.fancybox("Message sent");

//        $(this).before("<p><strong>Message sending failed :-(</strong></p>");
        setTimeout("$.fancybox.close()", 1000);

    }

}