$(document).ready(function () {
    CreateAndInitializeEmailForm();
});


function CreateAndInitializeEmailForm() {

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

            $.fancybox.showLoading();

            proceedCatBeeShareJsonRequest(postData);

            waitCatBeeResultAndRun(7200, handleEmailResponse);

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
    var reg = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return reg.test(email);
}

function getCatBeeShareUrl()
{
    return catBeeData.sharePoint;
}

function createCatBeeShareRequest() {

    var rewardInd = $("#slider").slider("value");

    return {
        action:'share deal',
        context:{

            sendFrom:catBeeData.order.customer.email,
            sendTo:$("#mail-input").val(),
            message:$("#message").val(),
            subject:$("#message").val(),
            deal:{
                id:catBeeData.id
            },
            context:{
                type:'email'
            },
            store:{
                authCode:catBeeData.order.store.authCode
            },
            reward:
            {
                value: catBeeData.landing.landingRewards[rewardInd].friendReward.value,
                type: catBeeData.landing.landingRewards[rewardInd].friendReward.type,
                code: catBeeData.landing.landingRewards[rewardInd].friendReward.code,
                description: catBeeData.landing.landingRewards[rewardInd].friendReward.description,
                typeDescription: catBeeData.landing.landingRewards[rewardInd].friendReward.typeDescription,
                id: catBeeData.landing.landingRewards[rewardInd].friendReward.id

            }
        }
    };
}

function handleEmailResponse()
{
    $.fancybox.hideLoading();

    $.fancybox("Message sent");

    setTimeout("$.fancybox.close()", 1000);
}