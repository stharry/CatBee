$(document).ready(function() {

    $('.email-form').hide();

    $("#slider").slider({
        animate: true,
        min : 0,
        max : TribZi.deal.landing.landingRewards.length - 1,
        value : Math.round((TribZi.deal.landing.landingRewards.length - 1)/2),
        change : function(event, ui) {
            var val = ui.value;
            updateRewards(ui.value);

        },
        start: function(event, ui){
            ui.handle.rel = ui.value;
        },
        stop: function(event, ui){
            if(ui.handle.rel == ui.value){
                if(event.layerX > $(ui.handle).position().left){
                    $(this).slider("value", ui.value+1)
                }else{
                    $(this).slider("value", ui.value-1)
                }
            }
			if(ui.value == 0)
			{
				//Cat needs to be yellow.
				$('.cat_icon').css({
					'background-position' : '-154px 0px'
				});
				
				$('.bee_icon').css({
					'background-position' : '-283px 0px'
				});
			}
			else if(ui.value == $(this).data("slider").options.max)
			{
				$('.cat_icon').css({
					'background-position' : '-77px 0px'
				});
				$('.bee_icon').css({
					'background-position' : '-335px 0px'
				});
			}
			else
			{
				$('.cat_icon').css({
					'background-position' : '0px 0px'
				});
				$('.bee_icon').css({
					'background-position' : '-232px 0px'
				});
			}
        }
    });

    $('.cat_icon').dblclick(function(){

        $("#slider").slider('value', 0);
		$('.cat_icon').css({
			'background-position' : '-154px 0px'
		});
		
		$('.bee_icon').css({
			'background-position' : '-283px 0px'
		});
    });

    $('.cat_icon').click(function(){

        var sliderValue = $("#slider").slider('value');

        if (sliderValue > 0)
        {
            $("#slider").slider('value', sliderValue - 1);
        }
    });

    $('.bee_icon').dblclick(function(){

        $("#slider").slider('value', TribZi.deal.landing.landingRewards.length - 1);
		$('.cat_icon').css({
			'background-position' : '-77px 0px'
		});
		$('.bee_icon').css({
			'background-position' : '-335px 0px'
		});
    });

    $('.bee_icon').click(function(){

        var sliderValue = $("#slider").slider('value');

        if (sliderValue < TribZi.deal.landing.landingRewards.length - 1)
        {
            $("#slider").slider('value', sliderValue + 1);
        }
    });

    updateBoxPosition();
    updateRewards(Math.round((TribZi.deal.landing.landingRewards.length - 1)/2));
    //Share hover
    $('.share-box a').hover(
        function(){
            $('.share-hover .'+$(this).attr('rel')).css('visibility', 'visible');
        },
        function(){
            if( !$('.share-hover .'+$(this).attr('rel')).is('.active'))
                $('.share-hover .'+$(this).attr('rel')).css('visibility', 'hidden');
        }
    )

//    try
//    {
//    $("#emailShare").fancybox({
//
//        width : 490,
//        height : 500,
//        autoScale : false,
//        scrolling   : 'no',
//        overlay : {
//            css : {
//                'background' : 'rgba(238,238,238,0.85)'
//            }
//        }
//    });
//    }
//    catch (e)
//    {
//        alert(e)
//    }



    $('.share-box a[rel="email"]').click(function(){

        var target = $(this);
        if( $('.email-form').css('display') == 'none' )
		{
			$('#tbox').css('display', 'none');
			$('#tbox_bottom').css('display', 'none');
			$('#share_list').find('li').removeClass('active');
			$(this).parent().addClass('active');
            //I know this is not the Way yo Call a relative URL..
            /* $('.box-wrapper').css({height:'740px', background:'url(../../public/res/images/catbee_blue_bg.jpg) repeat-x'}); */
            $("#message").val(TribZi.deal.landing.customMessage);
        }
		else
		{
            //I know this is not the Way yo Call a relative URL..
            /* $('.box-wrapper').css({height:'418px', background: 'url(../../public/res/images/catbee_blue_bg_h500.jpg) repeat-x'}); */
			$(this).parent().removeClass('active');
        }
        $('.email-form').slideToggle("fast", function(){
            if( $('.email-form').css('display') == 'none' ){
                $('.share-hover .'+target.attr('rel')).css('visibility', 'hidden');
                $('.share-hover .'+target.attr('rel')).removeClass('active');
            }else{
                $('.share-hover .'+target.attr('rel')).css('visibility', 'visible');
                $('.share-hover .'+target.attr('rel')).addClass('active');
            }
            goToByScroll('email-form');

            TribZi.resizeFrame();
        });


        //$.fancybox.reshow();

    });

    //infield label
    $('textarea').each(function() {
        var $this = $(this);
        if($this.val() === '') {
            $this.val($this.attr('title'));
            $this.css('color', '#bfbfbf');
        }
        $this.focus(function() {
            if($this.val() === $this.attr('title')) {
                $this.val('');
                $this.css('color', '#000000');
            }
        });
        $this.blur(function() {
            if($this.val() === '') {
                $this.val($this.attr('title'));
                $this.css('color', '#bfbfbf');
            }
        });
    });

});
function updateBoxPosition(){
    //Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();
    //Set the popup window to center
    $('.box-wrapper').css('top',  winH/2-$('.box-wrapper').height()/2);
    $('.box-wrapper').css('left', winW/2-$('.box-wrapper').width()/2);
}
function goToByScroll(selector){
    $('html,body').animate({scrollTop: $("."+selector).offset().top},'slow');
}
function openWindow(){
    $('.box-wrapper').fadeIn();
    return false;
}

function updateRewards(sliderVal) {

    $('#LeaderRewardPhrase').text(TribZi.deal.landing.landingRewards[sliderVal].leaderReward.description);
    $('#LeaderReward').val('$'+TribZi.deal.landing.landingRewards[sliderVal].leaderReward.value);
    $('#leaderArea').val(TribZi.deal.landing.landingRewards[sliderVal].leaderReward.typeDescription);
	
	$('#info_you').html('$'+TribZi.deal.landing.landingRewards[sliderVal].leaderReward.value);

    $('#FriendRewardPhrase').text(TribZi.deal.landing.landingRewards[sliderVal].friendReward.description);
    $('#FriendReward').val(TribZi.deal.landing.landingRewards[sliderVal].friendReward.value+'%');
    $('#FriendArea').val(TribZi.deal.landing.landingRewards[sliderVal].friendReward.typeDescription);

	$('#percent_friends').html(TribZi.deal.landing.landingRewards[sliderVal].friendReward.value+'%');
	
    TribZi.setRewardIndex(sliderVal);
}
