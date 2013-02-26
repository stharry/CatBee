/* Zoran Functions START */
function showSuccess(message)
{
    $('.thank-you').text(message ? message : 'Thank you for sharing');
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

function switchEmailBox() {


        if ($('.email-form').css('display') == 'none') {
            $('.email-form').show();
            $('#emailShare').parent().addClass('active');

        }
        else
        {
            $('.email-form').hide();
            $('#emailShare').parent().removeClass('active');

        }

//    $('.email-form').slideToggle("fast", function () {
//        if ($('.email-form').css('display') == 'none') {
//            $('.share-hover .' + $(this).attr('rel')).css('visibility', 'hidden');
//            $('.share-hover .' + $(this).attr('rel')).removeClass('active');
//        }
//        else {
//            $('.share-hover .' + $(this).attr('rel')).css('visibility', 'hidden');
//            $('.share-hover .' + $(this).attr('rel')).removeClass('active');
//        }
//        goToByScroll('email-form');
//    });
}
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
        slide : function(event, ui) {
            var val = ui.value;
            updateRewards(ui.value);
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

        },
        start: function(event, ui){
            ui.handle.rel = ui.value;
        }
    });

    $('.cat_icon, #cat_icon_opacity').dblclick(function()
	{
		if($(this).hasClass('dontclick'))
		{
			return false;
		}
        $("#slider").slider('value', $('#slider').data('slider').options.min);
        updateRewards( $("#slider").slider('value'));
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
        updateRewards( $("#slider").slider('value'));
    });

    $('.bee_icon, #bee_icon_opacity').dblclick(function()
	{
		if($(this).hasClass('dontclick'))
		{
			return false;
		}
        $("#slider").slider('value', $('#slider').data('slider').options.max);
		_makeBeesYellow();
        updateRewards( $("#slider").slider('value'));
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
        updateRewards( $("#slider").slider('value'));
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

		$('#message').css('color', '#4F432D');
        if($('.email-form').css('display') == 'none' )
		{
            hidePinterestBox();
			hideTwitterBox();
			$('#share_list').find('li').removeClass('active');
			//$(this).parent().addClass('active');

        }
		else
		{
			//$(this).parent().removeClass('active');
			
        }
        switchEmailBox();
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
function goToByScroll(selector){
//    $('html,body').animate({scrollTop: $("."+selector).offset().top},'slow');
}

function openWindow(){
    $('.box-wrapper').fadeIn();
    return false;
}

function UpdateleaderRewardTypes(sliderVal,RewardType) {
    if (TribZi.deal.landing.landingRewards[sliderVal].leaderReward.typeDescription == '$') {
        $(RewardType).text('' + TribZi.deal.landing.landingRewards[sliderVal].leaderReward.typeDescription +
            TribZi.deal.landing.landingRewards[sliderVal].leaderReward.value);
    }
    else {
        $(RewardType).text('' + TribZi.deal.landing.landingRewards[sliderVal].leaderReward.value +
            TribZi.deal.landing.landingRewards[sliderVal].leaderReward.typeDescription);
    }
}
function UpdateFriendRewardTypes(sliderVal,RewardType) {
    if (TribZi.deal.landing.landingRewards[sliderVal].friendReward.typeDescription == '$') {
        $(RewardType).text('' + TribZi.deal.landing.landingRewards[sliderVal].friendReward.typeDescription +
            TribZi.deal.landing.landingRewards[sliderVal].friendReward.value);
    }
    else {
        $(RewardType).text('' + TribZi.deal.landing.landingRewards[sliderVal].friendReward.value +
            TribZi.deal.landing.landingRewards[sliderVal].friendReward.typeDescription);
    }
}
function UpdateFriendRewardTypesVal(sliderVal,RewardType) {
    if (TribZi.deal.landing.landingRewards[sliderVal].friendReward.typeDescription == '$') {
        $(RewardType).val('' + TribZi.deal.landing.landingRewards[sliderVal].friendReward.typeDescription +
            TribZi.deal.landing.landingRewards[sliderVal].friendReward.value);
    }
    else {
        $(RewardType).val('' + TribZi.deal.landing.landingRewards[sliderVal].friendReward.value +
            TribZi.deal.landing.landingRewards[sliderVal].friendReward.typeDescription);
    }
}
function updateRewards(sliderVal) {

    $('#LeaderRewardPhrase').text(TribZi.deal.landing.landingRewards[sliderVal].leaderReward.description);
    $('#LeaderReward').val(TribZi.deal.landing.landingRewards[sliderVal].leaderReward.typeDescription +
       TribZi.deal.landing.landingRewards[sliderVal].leaderReward.value);

    //UpdateRewardTypes(sliderVal);
    UpdateleaderRewardTypes(sliderVal,'#info_you');
    $('#info_you_desc').text('' + TribZi.deal.landing.landingRewards[sliderVal].leaderReward.type);
	

    $('#FriendRewardPhrase').text(TribZi.deal.landing.landingRewards[sliderVal].friendReward.description);
    UpdateFriendRewardTypes(sliderVal,'#percent_friends');
    UpdateFriendRewardTypesVal(sliderVal,'#FriendReward');
    $('#info_friend_desc').text('' + TribZi.deal.landing.landingRewards[sliderVal].friendReward.type);


    TribZi.setRewardIndex(sliderVal);

    setTwitterMessage();
}
function updateBoxPosition(){
    //Get the window height and width
    var winH = $(window).height();
    var winW = $(window).width();
    //Set the popup window to center
    $('.box-wrapper').css('top',  winH/2-$('.box-wrapper').height()/2);
    $('.box-wrapper').css('left', winW/2-$('.box-wrapper').width()/2);
}