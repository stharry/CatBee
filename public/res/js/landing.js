$(document).ready(function() {
    $('.email-form').hide();
    $("#slider").slider({
        animate: true,
        min : 0,
        max : 2,
        value : 1,
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
        }
    });

    updateBoxPosition();
    updateRewards(1);
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
        if( $('.email-form').css('display') == 'none' ){
            //I know this is not the Way yo Call a relative URL..
            $('.box-wrapper').css({height:'810px', background:'url(../../public/res/images/catbee_blue_bg.jpg) repeat-x'});
        }else{
            //I know this is not the Way yo Call a relative URL..
            $('.box-wrapper').css({height:'500px', background: 'url(../../public/res/images/catbee_blue_bg_h500.jpg) repeat-x'});
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

    var leaderText = $('#leaderRewardDesc' + sliderVal).text();
    var friendText = $('#friendRewardDesc' + sliderVal).text();

    $('#LeaderRewardPhrase').text(leaderText);
    $('#FriendRewardPhrase').text(friendText);

}
