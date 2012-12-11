var facebookParams = null;

$(document).ready(function () {

    $('.facebook-form').hide();
    $('#ContactsArea').hide();

    $("#facebookShare").click(function () {

        getFacebookShare();

        waitAndShare();

        //waitCatBeeResultAndRun(7200, waitAndShare);
    });


});

function getFacebookShare() {

    var request = createCatBeeFillShareRequest();
    proceedCatBeeShareJsonRequest(request, 'facebookParams');
}

function StartFacebookSharing()
{
    try {

        var s = localStorage.getItem('facebookParams');

        facebookParams = JSON.parse(s);


        FB.init({
            appId: facebookParams.context.application.applicationCode,

            status:true, cookie:true});

        FB.ui({
                method:'feed',
                display:'popup',
                name: catBeeData.landing.customMessage,
                picture: catBeeData.order.items[0].url,
                redirect_uri: facebookParams.context.application.redirectUrl,
                caption: ' ',
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

        localStorage.removeItem('facebookParams');
    }
    catch (e)
    {
        alert(e);
    }

}

function waitAndShare() {

    if (localStorage.getItem('facebookParams') === null)
    {
        setTimeout(waitAndShare, 500);
    }
    else
    {
        StartFacebookSharing();
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
                "authCode":catBeeData.order.store.authCode
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
