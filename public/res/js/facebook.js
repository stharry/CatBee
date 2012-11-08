var facebookParams = null;

$(document).ready(function () {

    $('.facebook-form').hide();
    $('#ContactsArea').hide();

    $("#facebookShare").click(function () {

        waitAndShare();

        //waitCatBeeResultAndRun(7200, waitAndShare);
    });

    StartFacebookSharing();
});

function StartFacebookSharing() {

    var request = createCatBeeFillShareRequest();
    proceedCatBeeShareJsonRequest(request, 'facebookParams');
}

function waitAndShare() {

    facebookParams = JSON.parse(localStorage.getItem('facebookParams'));

    if (facebookParams != null)
    {
    try {

        FB.init({appId:facebookParams.context.application.applicationCode,
            xfbml:true, cookie:true});

        FB.ui({
            method:'feed',
            display:'popup',
            name: facebookParams.message,
            picture: catBeeData.order.purchases[0].url,
            redirect_uri: facebookParams.context.application.redirectUrl,
            description: facebookParams.message,
            link: facebookParams.link
        },
            function(response) {
                if (response && response.post_id) {
                    alert('Post was published.' + response.post_id);
                } else {
                    alert('Post was not published.');
                }
            }
        );
    }
    catch (e) {
        alert(e);
    }
    }
    else
    {
        alert('is null');
    }
}

function createCatBeeFillShareRequest() {

    var rewardInd = $("#slider").slider("value");

    return {
        action:'fillshare',
        context:{

            "context":{
                "type":"facebook"
            },
            "store":{
                "authCode":$("#storeCode").text()
            },
            "deal":{
                "id":catBeeData.id
            },
            "reward":{
                "id":catBeeData.landing.landingRewards[rewardInd].id
            }
        }
    };
}
