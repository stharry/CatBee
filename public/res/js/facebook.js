var facebookParams = null;

$(document).ready(function () {

    $.initFacebook({appId:TribZi.deal.fbcContext.application.applicationCode});
    $('.facebook-form').hide();
    $('#ContactsArea').hide();

    $("#facebookShare").click(function () {

        StartFacebookSharing();
//        getFacebookShare();
//
//        waitAndShare();

        //waitCatBeeResultAndRun(7200, waitAndShare);
    });


});

function getFacebookShare() {

    var request = createCatBeeFillShareRequest();
    proceedCatBeeShareJsonRequest(request, 'facebookParams');
}

function StartFacebookSharing() {
    try {

        var message = TribZi.parseMessage(TribZi.deal.fbcContext.message);
        //todo
        //var customMessage = TribZi.parseMessage(TribZi.deal.fbcContext.customMessage);

//        alert(message);
//
//        return;
//        var s = localStorage.getItem('facebookParams');
//
//        facebookParams = JSON.parse(s);
//
        //todo check ? or &
        var redirectUrl = TribZi.deal.fbcContext.application.redirectUrl +
            '?context=' + encodeURIComponent(JSON.stringify(createShareObj()));
//        FB.init({
//            appId: TribZi.deal.fbcContext.application.applicationCode,
//
//            status:true, cookie:true});

        FB.ui({
                method:'feed',
                display:'popup',
                name:TribZi.deal.landing.customMessage,
                picture:TribZi.deal.order.items[0].url,
                redirect_uri:redirectUrl,
                caption:' ',
                description:message,
                link:TribZi.deal.fbcContext.link
            },
            fbcResponse
        );

//        localStorage.removeItem('facebookParams');
    }
    catch (e) {
        alert(e);
    }

}

function fbcResponse(response) {
    if (response && response.post_id) {
        alert('Post was published.' + response.post_id);
    } else {
        alert('Post was not published.');
    }
}

function waitAndShare() {

    if (localStorage.getItem('facebookParams') === null) {
        setTimeout(waitAndShare, 500);
    }
    else {
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
            "deal":{
                "id":TribZi.deal.id
            },
            "reward":{
                "id":TribZi.deal.landing.landingRewards[rewardInd].id
            }
        }
    };
}

$.initFacebook = function (options) {

    $('#fb-root').remove();

    $('body').append('<div id="fb-root"></div>');

    var settings = {

        'appId':null,
        'callback':null,
        'channelUrl':null,
        'status':true,
        'cookie':true,
        'xfbml':true

    };

    if (options) {
        $.extend(settings, options);
    }

    if (typeof( xc_app_id ) == 'undefined') {
        window.xc_app_id = settings.appId;
    }

    window.fbAsyncInit = function () {

        if (settings.channelUrl == null) {

            FB.init({appId:settings.appId, status:settings.status, cookie:settings.cookie, xfbml:settings.xfbml, oauth:true, authResponse:true });

        } else {

            settings.channelUrl = location.protocol + '//' + settings.channelUrl;

            FB.init({appId:settings.appId, status:settings.status, cookie:settings.cookie, xfbml:settings.xfbml, oauth:true, authResponse:true, channelUrl:settings.channelUrl });
        }

        if (typeof settings.callback == 'function') {
            settings.callback.call(this);
        }

    };


}
//Tomer
function createShareObj() {

    var rewardInd = $("#slider").slider("value");
    return {

        customMessage:TribZi.deal.fbcContext.customMessage,

        deal:{
            id:TribZi.deal.id,
            order:TribZi.deal.order,
            campaign:{
                id:TribZi.deal.campaign.id
            }
        },
        reward:TribZi.deal.landing.landingRewards[rewardInd],
        context:{
            type:'email',
            uid:TribZi.deal.fbcContext.uid
        },
        targets:[
            {
                name:'leader',
                from:TribZi.deal.order.branch.email,
                to:TribZi.deal.order.customer.email

            }
        ]
    }
}