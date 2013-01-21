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
			$('#slider').slider('disable');
			$('.cat_icon').addClass('dontclick');
			$('#cat_icon_opacity').addClass('dontclick');
			$('.bee_icon').addClass('dontclick');
			$('#bee_icon_opacity').addClass('dontclick');
			
			if(typeof TribZi.deal.twitContext.link == 'undefined' || TribZi.deal.twitContext.link == '')
			{
				TribZi.deal.twitContext.link = $('#twitter_link').val();
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


                        TribZi.share(null);
						
						if(TribZi.sharedTimes == 1)
						{
							//This is first share, we need to move to email
							$('#emailShare').click();
						}
						else if(TribZi.sharedTimes == 2)
						{
							//This is second share, we need to show up the slider and close everything else.
							$('#slider').slider('enable');
							var maxValue = parseInt($('#slider').slider('option', 'max'));
							var halfValue = maxValue/2;
							$('#slider').slider('value', halfValue);
							_calculateColor(halfValue);
							showSuccess();
							$('#twitterShare').click();
							TribZi.sharedTimes = 0;
						}
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
						$('#shadow_div').removeClass('inv');

                        TribZi.resizeFrame(4, 4);
					}

                });
            });

        }
		else
		{
			$(this).parent().removeClass('active');
			$('.cat_icon').removeClass('dontclick');
			$('#cat_icon_opacity').removeClass('dontclick');
			$('.bee_icon').removeClass('dontclick');
			$('#bee_icon_opacity').removeClass('dontclick');
			/* $('#slider-blue-content').find('.slider-description').removeClass('inv');
			$('#slider-blue-content').find('.slider-wrapper').removeClass('inv');
			$('#slider_inactive').addClass('inv'); */
			$('#slider').slider('enable');
		}

        var target = $(this);


        if ($('#tbox').css('display') == 'none')
		{

            var boxHeight = $('.box-wrapper').height() + 150;
            $('#tbox').show();
			$('#tbox_bottom').show();
			$('#shadow_div').removeClass('inv');

        } else {
            var boxHeight = $('.box-wrapper').height() - 150;

            $('#tbox').hide();
			$('#tbox_bottom').hide();
			$('#shadow_div').addClass('inv');

            $('.box-wrapper').css({
				height:boxHeight + 'px'
				//background:'url(../../public/res/images/catbee_blue_bg_h500.jpg) repeat-x'
			});
        }
        TribZi.resizeFrame(4, 4);
    });
    
    TribZi.resizeFrame(4, 4);

});

$("#twit_it").live('click', function()
{
	//tweeting-button button needs to be clicked.
	$('#tbox').find('iframe').contents().find('#tweeting-button').click();
	return false;
});