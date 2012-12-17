$(document).ready(function () {
    CreateAndInitializeEmailForm();
});


function CreateAndInitializeEmailForm() {

    $("#contact").submit(function () {
        return false;
    });

    $("#message").keyup(function () {
        catBeeData.landing.customMessage = $("#message").val();
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

            $.fancybox.showLoading();

            proceedCatBeeShareJsonRequest(postData, 'emailParams');

            handleEmailResponse();

//                 handleEmailResponse();
//            $.ajax({
//                type:'POST',
//                url:sharePoint,
//                dataType: 'json',
//                data: postData,
//
//                timeout: 7200,
//
//                error: function(xhr, textStatus, error){
//
//                    handleEmailResponse(xhr.responseText);
//                },
//
//                success:function (data) {
//
//                    handleEmailResponse(data);
//                }
//
//            });
        }
    });
}

function validateEmail(email) {

    var emails = email.split(",");

    if (emails.length == 0)
    {
        return false;
    }

    for (i = 0; i < emails.length; i++)
    {
        var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!reg.test(emails[i]))
        {
            return false;
        }
    }
    return true;
}

function getCatBeeShareUrl() {
    return catBeeData.sharePoint;
}

function createCatBeeShareRequest() {

    var rewardInd = $("#slider").slider("value");

    return {
        action:'share deal',
        context:{

            sendFrom:catBeeData.order.customer.email,
            sendTo:$("#mail-input").val(),
            customMessage:$("#message").val(),
            deal:{
                id:catBeeData.id
            },
            context:{
                type:'email'
            },
            reward:{
                id:catBeeData.landing.landingRewards[rewardInd].id

            }
        }
    };
}

function handleEmailResponse() {
    if (localStorage.getItem('emailParams') === null)
    {
        setTimeout(handleEmailResponse, 500);
    }
    else
    {
        $.fancybox.hideLoading();

        $.fancybox("Message sent");

        setTimeout("$.fancybox.close()", 1000);

        localStorage.removeItem('emailParams');
    }
}