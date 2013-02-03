
$(document).ready(function () {

    try {
        var host = TribZi.getRoot();
        load(host + '/public/res/js/min/anywhere.js?id=' +
            TribZi.deal.twitContext.application.applicationCode + '&v=1')
            .thenRun(function () {
                createTwitterBox();
                hideTwitterBox();
            });
    }
    catch (e) {
        alert(e);
    }

//    TribZi.shortenLink(TribZi.deal.twitContext.link,
//        function (shortLink) {
//
//            TribZi.deal.twitContext.link = shortLink;
//
//
//        });

    $("#twitterShare").click(function () {

        if ($('#tbox').css('display') == 'none') {

            //createTwitterBox();

            setTwitterMessage();

            if ($('.email-form').css('display') !== 'none')
            {
                switchEmailBox();
            }
            showTwitterBox();
        }
        else {

            hideTwitterBox();
        }
    });

});

$("#twit_it").live('click', function () {
    //tweeting-button button needs to be clicked.
    $('#tbox').find('iframe').contents().find('#tweeting-button').click();
    return false;
});

function hideTwitterBox()
{
    $('#tbox').hide();
    $('#tbox_bottom').hide();
    $('#shadow_div').addClass('inv');
    $('#twitterShare').parent().removeClass('active');
}

function showTwitterBox() {
    $('#tbox').show();
    $('#tbox_bottom').show();

    $('#share_list').find('li').removeClass('active');
    $('#twitterShare').parent().addClass('active');

    $('#tbox_bottom').css('display', 'block');
    $('#shadow_div').removeClass('inv');
    $('#twitterShare').parent().addClass('active');

}

function createTwitterBox() {
//    if ((typeof twttr == 'undefined') || !twttr)
//    {
//        setTimeout(createTwitterBox, 500);
//    }

    var tbox = document.getElementById("tbox");
    while (tbox.firstChild) {
        tbox.removeChild(tbox.firstChild);
    }

    if ($('#tbox').css('display') == 'none') {

        if ($('#emailForm').css('display') != 'none') {
            $('#emailForm').css('display', 'none');
        }

        if (typeof TribZi.deal.twitContext.link == 'undefined' || TribZi.deal.twitContext.link == '') {
            TribZi.deal.twitContext.link = $('#twitter_link').val();
        }

        var message = TribZi.setShareLink(TribZi.deal.twitContext.link)
            .parseMessage(TribZi.deal.twitContext.message);

        //var message = TribZi.setShareLink($('#twitter_link').val()).parseMessage(TribZi.deal.twitContext.message);

        //twttr.anywhere.config({ callbackURL: "http://api.tribzi.com/CatBee/components/share/facebook/facebookLogin.php" });

        twttr.anywhere(function (T) {

            T.bind("authComplete", function (e, user) {
                //todo implement user access token grabbing and sending to server here

            });

            T("#tbox").tweetBox({

                height        :150,
                width         :380,
                label         :"",
                defaultContent:message,

                onTweet :function (plainTweet, htmlTweet) {

                    TribZi.clearTargets()
                        .addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.customer.email, 'friend', 'twitter')
                        .setCustomMessage(plainTweet)
                        .setRewardIndex($("#slider").slider("value"))
                        .setUid(TribZi.deal.twitContext.uid);

                    if (TribZi.sharedTimes == 0) {
                        TribZi.addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.customer.email, 'leader', 'email');

                    }

                    TribZi.share(null);

                    showSuccess('Thanks For Tweeting! Your Coupon for next purchase is on the way! Keep on sharing');

                    $('#twitterShare').click();
                    $('#emailShare').click();

                },
                complete:function (tweetBox) {
                    var cssUrl = window.location.protocol + '//' + window.location.host;
                    var cssStyle = '<style type="text/css">';
                    cssStyle += '#counter{position: absolute; bottom: 6px; right: 80px; font-size: 17px;}';
                    cssStyle += '#tweet-box{border: 1px solid #81bad5;-webkit-box-shadow: inset 0px 0px 5px 1px #a8a7a7;-moz-box-shadow: inset 0px 0px 5px 1px #a8a7a7;box-shadow: inset 0px 0px 5px 1px #a8a7a7;}';
                    cssStyle += '#tweeting-controls button{background: url("' + cssUrl + '/CatBee/public/res/images/tweetButton.jpg") no-repeat scroll 0 0 transparent;border: medium none;height: 25px;padding: 0;width: 73px;}';
                    cssStyle += '#tweeting-button{display: block;text-indent: -9999px; cursor: pointer;}';
                    cssStyle += '#tweeting-controls span{padding: 0px;background: none; border: none;}';
                    cssStyle += '</style>';
                    $('#tbox').find('iframe').contents().find('head').append(cssStyle);

                }

            });
        });

    }
}

function setTwitterMessage()
{
    //todo: ugly need to code tribzi custom events binding system
    var twitFrame = document.getElementsByClassName('twitter-anywhere-tweet-box')[0];
    if (twitFrame)
    {
        var message = TribZi.setShareLink(TribZi.deal.twitContext.link)
            .parseMessage(TribZi.deal.twitContext.message);

        twitFrame.contentDocument.getElementById('tweet-box').value = message;
    }
}