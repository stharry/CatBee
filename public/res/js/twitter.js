$(document).ready(function () {

    $.getScript("https://platform.twitter.com/widgets.js", function () {
        function handleTweetEvent(event) {
            if (event) {

                TribZi.clearTargets()
                    .addTarget(TribZi.deal.order.customer.email, TribZi.deal.order.customer.email, 'friend', 'twitter')
                    .setCustomMessage($('#twitterShare').attr('custom_message'))
                    .setRewardIndex($("#slider").slider("value"))
                    .setUid(TribZi.deal.twitContext.uid);

                TribZi.share(null);

                showSuccess('Thanks For Tweeting! Your reward for next purchase is on the way! Keep on sharing');

                $('#twitterShare').click();
                $('#emailShare').click();
            }
        }

        twttr.events.bind('tweet', handleTweetEvent);
        setTwitterMessage();
    });

    $("#twitterShare").click(function () {


        setTwitterMessage();

        if ($('.email-form').css('display') !== 'none') {
            switchEmailBox();
        }
        hidePinterestBox();
    });
});

function setTwitterMessage() {

    var message = TribZi.setShareLink(TribZi.deal.twitContext.link)
        .parseMessage(TribZi.deal.twitContext.message);

    var twitLink = 'https://twitter.com/intent/tweet?text=' + encodeURIComponent(message) + '&tw_p=tweetbutton&url=%20';
    $('#twitterShare').attr('href', twitLink);
    $('#twitterShare').attr('custom_message', message);
}

function hideTwitterBox()
{
    //remove it after new version will be uploaded to the api.tribzi.com
}