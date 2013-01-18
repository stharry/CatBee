$(document).ready(function () {

    try
    {
        var host = TribZi.getRoot();
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

        if ($('#tbox').css('display') == 'none') 
		{
			if($('#emailForm').css('display') != 'none')
			{
				$('#emailForm').css('display', 'none');
			}
			
            var message = TribZi.setShareLink(TribZi.deal.twitContext.link)
					.parseMessage(TribZi.deal.twitContext.message);

			//var message = TribZi.setShareLink($('#twitter_link').val()).parseMessage(TribZi.deal.twitContext.message);		
					
            twttr.anywhere(function (T) {

                T("#tbox").tweetBox({

                    height:150,
                    width:380,
                    label:"",
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
                    },
					complete : function (tweetBox) {
						var cssUrl = window.location.protocol+'//'+window.location.host;
						var cssStyle = '<style type="text/css">';
						cssStyle += '#counter{position: absolute; bottom: 6px; right: 80px; font-size: 17px;}';
						cssStyle += '#tweet-box{border: 1px solid #81bad5;-webkit-box-shadow: inset 0px 0px 5px 1px #a8a7a7;-moz-box-shadow: inset 0px 0px 5px 1px #a8a7a7;box-shadow: inset 0px 0px 5px 1px #a8a7a7;}';
						cssStyle += '#tweeting-controls button{background: url("'+cssUrl+'/CatBee/public/res/images/tweetButton.jpg") no-repeat scroll 0 0 transparent;border: medium none;height: 25px;padding: 0;width: 73px;}';
						cssStyle += '#tweeting-button{display: block;text-indent: -9999px; cursor: pointer;}';
						cssStyle += '#tweeting-controls span{padding: 0px;background: none; border: none;}';
						cssStyle += '</style>';
						$('#tbox').find('iframe').contents().find('head').append(cssStyle);
						
						$('#share_list').find('li').removeClass('active');
						$('#twitterShare').parent().addClass('active');
						$('#tbox_bottom').css('display', 'block');
					}

                });
            });
        }
		else
		{
			$(this).parent().removeClass('active');
		}

        var target = $(this);


        if ($('#tbox').css('display') == 'none')
		{

            var boxHeight = $('.box-wrapper').height() + 150;
            //$('.box-wrapper').css({height:boxHeight + 'px', background:'url(../../public/res/images/catbee_blue_bg.jpg) repeat-x'});

            //$('#tbox').css({marginTop:5, marginLeft:20});
            $('#tbox').show();
			$('#tbox_bottom').show();

        } else {
            var boxHeight = $('.box-wrapper').height() - 150;

            $('#tbox').hide();
			$('#tbox_bottom').hide();

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