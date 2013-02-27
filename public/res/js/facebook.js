$(document).ready(function () {

    $('.facebook-form').hide();
    $('#ContactsArea').hide();

//    TribZi.shortenLink(TribZi.deal.fbcContext.link,
//        function(shortLink){
//
//            TribZi.deal.fbcContext.link = shortLink;
//        });

    FB.init({appId:TribZi.deal.fbcContext.application.applicationCode, //'345229122250809'
        status    :true,
        cookie    :true});

    $("#facebookShare").click(function () {
        $('#share_list').find('li').removeClass('active');
        $(this).parent().addClass('active');
        if ($('#emailForm').css('display') != 'none') {
            $('#emailForm').css('display', 'none');
        }
        hidePinterestBox();
        hideTwitterBox();
        StartFacebookSharing();
    });


});

function StartFacebookSharing() {
    try {

        var message = TribZi.setShareLink(TribZi.deal.fbcContext.link)
            .parseMessage(TribZi.deal.fbcContext.message);

        var obj = {
            method:'feed',

            name       :TribZi.deal.fbcContext.customMessage,
            picture    :decodeURIComponent(TribZi.deal.order.items[0].url),
            caption    :' ',
            description:message,
            link       :TribZi.deal.fbcContext.link

        };

        function callback(response) {
            if (response === null || typeof response == 'undefined') {
                //alert('pizdetc');
            }
            else {
                TribZi.clearTargets()
                    .setUid(TribZi.deal.fbcContext.uid)
                    .addTarget(
                    TribZi.deal.order.customer.email,
                    response['post_id'], 'friend', 'facebook')

                    .setCustomMessage($("#message").val())
                    .setRewardIndex($("#slider").slider("value"))

                if (TribZi.sharedTimes == 0) {
                    TribZi.addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.customer.email, 'leader', 'email')
                        .addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.customer.email, 'friend', 'urlShare');
                }

                TribZi.share();

                showSuccess('Thanks For Sharing! Your Coupon for next purchase is on the way - Keep on sharing');

                $('#emailShare').click();
            }
        }

        FB.ui(obj, callback);
    }
    catch (e) {
        alert(e);
    }

}

function fbcResponse(response) {
    if (response && response.post_id) {
        alert('Post was published.' + response.post_id);
    }
    else {
        alert('Post was not published.');
    }
}

$.initFacebook = function (options) {

    $('#fb-root').remove();

    $('body').append('<div id="fb-root"></div>');

    var settings = {

        'appId'     :null,
        'callback'  :null,
        'channelUrl':null,
        'status'    :true,
        'cookie'    :true,
        'xfbml'     :true

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

        }
        else {

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

        deal   :{
            id      :TribZi.deal.id,
            order   :TribZi.deal.order,
            campaign:{
                id:TribZi.deal.campaign.id
            }
        },
        reward :TribZi.deal.landing.landingRewards[rewardInd],
        context:{
            type:'email',
            uid :TribZi.deal.fbcContext.uid
        },
        targets:[
            {
                name:'leader',
                from:TribZi.deal.order.branch.email,
                to  :TribZi.deal.order.customer.email

            }
        ]
    }
}