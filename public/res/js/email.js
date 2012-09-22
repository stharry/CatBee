$(document).ready(function() {
    CreateAndInitializeEmailForm();
});


function CreateAndInitializeEmailForm()
{
    $(".mailmodalbox").fancybox({
        helpers : {
            title : {
                type : 'inside'
            },
            overlay : {
                css : {
                    'background' : 'rgba(238,238,238,0.85)'
                }
            }
        }
    });
    $("#contact").submit(function() { return false; });

    $("#sendViaEmail").click(function(){

        var emailval  = $("#email").val();
        var msgval    = $("#msg").val();
        var msglen    = msgval.length;
        var mailvalid = validateEmail(emailval);

        if(mailvalid == false) {
            $("#email").addClass("error");
        }
        else if(mailvalid == true){
            $("#email").removeClass("error");
        }

        if(msglen < 4) {
            $("#msg").addClass("error");
        }
        else if(msglen >= 4){
            $("#msg").removeClass("error");
        }

        if(mailvalid == true && msglen >= 4) {
            // if both validate we attempt to send the e-mail
            // first we hide the submit btn so the user doesnt click twice
            $("#send").replaceWith("<em>sending...</em>");

            $.ajax({
                type: 'POST',
                url: 'inviteFriendViaEmail.php',
                data: $("#contact").serialize(),
                success: function(data) {

                    if(data.toLowerCase().indexOf("message_sent") > 0) {

                        $("#contact").fadeOut("fast", function(){
                            $(this).before("<p><strong>Success! Your feedback has been sent, thanks :)</strong></p>");
                            setTimeout("$.fancybox.close()", 1000);
                        });
                    }
                    else
                    {

                        $(this).before("<p><strong>Message sending failed :-(</strong></p>");
                        setTimeout("$.fancybox.close()", 1000);

                    }
                }
            });
        }
    });
}

function validateEmail(email) {
    var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return reg.test(email);
}
