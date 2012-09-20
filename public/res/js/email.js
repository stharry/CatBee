$(document).ready(function() {

    alert("Before email 1");

    CreateAndInitializeEmailForm();
});


function CreateAndInitializeEmailForm()
{
    $(".mailmodalbox").fancybox();
    $("#contact").submit(function() { return false; });

    $("#sendViaEmail").click(function(){

        alert(" email on click");

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

            alert("before sending");

            $.ajax({
                type: 'POST',
                url: 'inviteFriendViaEmail.php',
                data: $("#contact").serialize(),
                success: function(data) {

                    alert(data);

                    if(data.toLowerCase().indexOf("message_sent") > 0) {
                        alert("CLosing...");
                        $("#contact").fadeOut("fast", function(){
                            $(this).before("<p><strong>Success! Your feedback has been sent, thanks :)</strong></p>");
                            setTimeout("$.fancybox.close()", 1000);
                        });
                    }
                    else
                    {
                        alert("Closing with failure...");
                        $(this).before("<p><strong>Message sending failed :-(</strong></p>");
                        setTimeout("$.fancybox.close()", 1000);

                    }
                }
            });
        }
    });
}

function validateEmail(email) {
    alert("validate email 1");
    var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return reg.test(email);
}
