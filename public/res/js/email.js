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

            TribZi.clearTargets()
                .setUid(null)
                .addTarget(
                TribZi.deal.order.customer.email,
                $("#mail-input").val(), 'friend', 'email')

                .setCustomMessage($("#message").val())
                .setRewardIndex($("#slider").slider("value"));

            if (TribZi.sharedTimes == 0) {
                TribZi.addTarget(
                    TribZi.deal.order.branch.email,
                    TribZi.deal.order.customer.email,
                    'leader', 'email');
            }
            TribZi.share(null); //Increment the number of shares

            if (TribZi.sharedTimes == 1) {
                showSuccess();
            }
            switchToTwitter();
         }
    });
}

function switchToTwitter() {
    setTimeout(function () {
        $('#emailShare').click();
        $('#twitterShare').click();
        $('#tbox').find('iframe').contents().find('#tweet-box').focus();
    }, 500);
}

function validateEmail(email) {

    var emails = email.split(",");

    if (emails.length == 0) {
        return false;
    }

    for (i = 0; i < emails.length; i++) {
        var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        if (!reg.test(emails[i])) {
            return false;
        }
    }
    return true;
}
