$(document).ready(function () {
    CreateAndInitializeEmailForm();
});


function CreateAndInitializeEmailForm() {

    $("#contact").submit(function () {
        return false;
    });

    $("#message").keyup(function () {
        TribZi.setCustomMessage($("#message").val());
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

            $.fancybox.showLoading();

            TribZi.setRecipients($("#mail-input").val())
                .setCustomMessage($("#message").val())
                .setRewardIndex($("#slider").slider("value"))
                .shareToEmail(stopProgress);

        }
    });
}

function stopProgress(params)
{
    $.fancybox.hideLoading();
    $.fancybox("Message sent");
    setTimeout("$.fancybox.close()", 1000);
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
