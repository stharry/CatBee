$(document).ready(function () {

    var host = TribZi.deal.sharePoint.toString().replace(/^(.*\/\/[^\/?#]*).*$/, "$1");

    try {
            load(host + '/public/res/js/min/anywhere.js?id=' + TribZi.deal.twitContext.application.applicationCode + '&v=1');
    }
    catch (e) {
        alert(e);
    }

    TribZi.shortenLink(TribZi.deal.twitContext.link,
        function(shortLink){

            TribZi.deal.twitContext.link = shortLink;
        });

    $("#twitterShare").click(function () {

        var tbox = document.getElementById("tbox");
        while (tbox.firstChild) {
            tbox.removeChild(tbox.firstChild);
        }

        if ($('#tbox').css('display') == 'none') {


            var message = TribZi.setShareLink(TribZi.deal.twitContext.link)
                .parseMessage(TribZi.deal.twitContext.message);


            twttr.anywhere(function (T) {

                T("#tbox").tweetBox({

                    height:150,
                    width:380,
                    label:"Tweet it",
                    defaultContent:message,

                    onTweet:function (plainTweet, htmlTweet) {

                        TribZi.clearTargets()
                            .addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.customer.email, 'friend', 'twitter')
                            .setCustomMessage(plainTweet)
                            .setRewardIndex($("#slider").slider("value"))
                            .setUid(TribZi.deal.twitContext.uid);

                        if (TribZi.sharedTimes == 0) {
                            TribZi.addTarget(TribZi.deal.order.branch.email, TribZi.deal.order.customer.email, 'leader', 'email');

                        }

                        alert(1);
                        TribZi.share(null);
                    }

                });
            });
        }

        var target = $(this);


        if ($('#tbox').css('display') == 'none') {

            var boxHeight = $('.box-wrapper').height() + 150;
            $('.box-wrapper').css({height:boxHeight + 'px', background:'url(../../public/res/images/catbee_blue_bg.jpg) repeat-x'});

            $('#tbox').css({marginTop:5, marginLeft:20});
            $('#tbox').show();

        } else {
            var boxHeight = $('.box-wrapper').height() - 150;

            $('#tbox').hide();


            $('.box-wrapper').css({height:boxHeight + 'px', background:'url(../../public/res/images/catbee_blue_bg_h500.jpg) repeat-x'});
        }
//        $('#tbox').slideToggle("fast", function(){
//            if( $('#tbox').css('display') == 'none' ){
//                $('.share-hover .'+target.attr('rel')).css('visibility', 'hidden');
//                $('.share-hover .'+target.attr('rel')).removeClass('active');
//            }else{
//                $('.share-hover .'+target.attr('rel')).css('visibility', 'visible');
//                $('.share-hover .'+target.attr('rel')).addClass('active');
//            }
//            //goToByScroll('email-form');
//        });


    });

});