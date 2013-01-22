/* Zoran Functions START */
function showSuccess()
{
	/* $('#shareResponse').html('Thank you for sharing');
	$('#shareResponse').css('display', 'block');
	setTimeout(function(){
		$('#shareResponse').fadeOut('slow');
	}, 5000); */
	$('#slider-blue-content').find('.slider-description').addClass('inv');
	$('#slider-blue-content').find('.slider-wrapper').addClass('inv');
	$('#slider_inactive').removeClass('inv');
}

function _makeCatYellow()
{
	$('.cat_icon').css({
		'background-position' : '-154px 0px'
	});
	
	$('.bee_icon').css({
		'background-position' : '-283px 0px'
	});
	
	$('#bee_icon_opacity').css({
		'opacity' : 1,
		'background-position' : '-283px 0px'
	});
	$('#cat_icon_opacity').css({
		'background-position' : '-154px 0px',
		'opacity' : 1
	});
	
}

function _makeBeesYellow()
{
	$('.cat_icon').css({
		'background-position' : '-77px 0px'
	});
	$('.bee_icon').css({
		'background-position' : '-335px 0px'
	});
	$('#cat_icon_opacity').css({
		'background-position' : '-77px 0px',
		'opacity' : 1
	});
	$('#bee_icon_opacity').css({
		'background-position' : '-335px 0px',
		'opacity' : 1
	});
}

function _calculateColor(sliderValue) //1,2,3.
{
	var maxValue = parseInt($('#slider').slider('option', 'max')); //6
	var halfValue = maxValue/2; //3
	var minValue = parseInt($('#slider').slider('option', 'min')); //0
	
	//var sliderValue = $('#slider').slider('value');
	if(sliderValue < halfValue)
	{
		var catOpacity = 1 - (sliderValue/halfValue);
		
		$('#cat_icon_opacity').css({
			'opacity' : catOpacity,
			'background-position' : '-154px 0px'
		});
		$('.cat_icon').css({
			'background-position' : '0px 0px'
		});
		$('#bee_icon_opacity').css({
			'background-position' : '-283px 0px',
			'opacity' : catOpacity
		});
	}
	else if(sliderValue > halfValue)
	{
		//Set the cat
		var beeOpacity = (sliderValue - halfValue)/halfValue;
		$('#cat_icon_opacity').css({
			'background-position' : '-77px 0px',
			'opacity' : beeOpacity
		});
		$('.cat_icon').css({
			'background-position' : '0px 0px'
		});
		$('.bee_icon').css({
			'background-position' : '-283px 0px'
		});
		$('#bee_icon_opacity').css({
			'background-position' : '-335px 0px',
			'opacity' : beeOpacity
		});
	}
	else
	{
		$('#cat_icon_opacity').css('opacity', 0.01);
		$('#bee_icon_opacity').css('opacity', 0.01);
		$('.cat_icon').css({
			'background-position' : '0px 0px'
		});
		$('.bee_icon').css({
			'background-position' : '-232px 0px'
		});
	}
}
/* Zoran Functions END */
$(document).ready(function() 
{
    $('.box').mutate('height width',function (element,info){
        TribZi.resizeFrame(2, 2);
    });

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
            /* if(ui.handle.rel == ui.value){
                if(event.layerX > $(ui.handle).position().left){
                    $(this).slider("value", ui.value+1)
                }else{
                    $(this).slider("value", ui.value-1)
                }
            } */
			//alert('UI VALUE ON STOP: '+ui.value);
			if(ui.value == 0) //The  slider has value of 0
			{
				_makeCatYellow();
			}
			else if(ui.value == $(this).data("slider").options.max) //The slider has maximum values
			{
				_makeBeesYellow();
			}
			else //Anywhere else. We need to calculate the color here depending where the slider is.
			{
				_calculateColor(ui.value);
			}
        }
    });

    $('.cat_icon, #cat_icon_opacity').dblclick(function()
	{
		if($(this).hasClass('dontclick'))
		{
			return false;
		}
        $("#slider").slider('value', $('#slider').data('slider').options.min);
		_makeCatYellow();
    });

    $('.cat_icon, #cat_icon_opacity').click(function()
	{
		if($(this).hasClass('dontclick'))
		{
			return false;
		}
        var sliderValue = $("#slider").slider('value');
		var maxValue = parseInt($('#slider').slider('option', 'max')); //6
		var halfValue = maxValue/2; //3
		var minValue = parseInt($('#slider').slider('option', 'min')); //0
		
        if (sliderValue > 0)
        {
            $("#slider").slider('value', sliderValue - 1);
        }
		if($("#slider").slider('value') == 0)
		{
			_makeCatYellow();
		}
		else
		{
			_calculateColor($("#slider").slider('value'));
		}
    });

    $('.bee_icon, #bee_icon_opacity').dblclick(function()
	{
		if($(this).hasClass('dontclick'))
		{
			return false;
		}
        $("#slider").slider('value', $('#slider').data('slider').options.max);
		_makeBeesYellow();
    });

    $('.bee_icon, #bee_icon_opacity').click(function()
	{
		if($(this).hasClass('dontclick'))
		{
			return false;
		}
        var sliderValue = $("#slider").slider('value');

        if (sliderValue < TribZi.deal.landing.landingRewards.length - 1)
        {
            $("#slider").slider('value', sliderValue + 1);
        }
		
		if($("#slider").slider('value') == $('#slider').data('slider').options.max)
		{
			_makeBeesYellow();
		}
		else
		{
			_calculateColor($('#slider').slider('value'));
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

    $('.share-box a[rel="email"]').click(function(){

        var target = $(this);
		$('#message').css('color', '#4F432D');
        if($('.email-form').css('display') == 'none' )
		{
//			$('#slider').slider('disable');
//			$('.cat_icon').addClass('dontclick');
//			$('#cat_icon_opacity').addClass('dontclick');
//			$('.bee_icon').addClass('dontclick');
//			$('#bee_icon_opacity').addClass('dontclick');
//

			$('#tbox').css('display', 'none');
			$('#tbox_bottom').css('display', 'none');
			$('#shadow_div').addClass('inv');
			$('#share_list').find('li').removeClass('active');
			$(this).parent().addClass('active');
            //I know this is not the Way yo Call a relative URL..
            /* $('.box-wrapper').css({height:'740px', background:'url(../../public/res/images/catbee_blue_bg.jpg) repeat-x'}); */
            $("#message").val(TribZi.deal.landing.customMessage);
        }
		else
		{
//			$('#slider').slider('enable');
//			$('.cat_icon').removeClass('dontclick');
//			$('#cat_icon_opacity').removeClass('dontclick');
//			$('.bee_icon').removeClass('dontclick');
//			$('#bee_icon_opacity').removeClass('dontclick');

            //I know this is not the Way yo Call a relative URL..
            /* $('.box-wrapper').css({height:'418px', background: 'url(../../public/res/images/catbee_blue_bg_h500.jpg) repeat-x'}); */
			$(this).parent().removeClass('active');
			
			/* $('#slider-blue-content').find('.slider-description').removeClass('inv');
			$('#slider-blue-content').find('.slider-wrapper').removeClass('inv');
			$('#slider_inactive').addClass('inv'); */
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
        });

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

    TribZi.resizeFrame(2, 2);
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
