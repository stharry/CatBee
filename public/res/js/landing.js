
$(document).ready(function() {
    CreateAndInitializeSlider();

    SetFormPopup();
});


function CreateAndInitializeSlider()
{
    //$( ".selector" ).slider({ values: [1,5,9] });
    $("#slider").slider({
        min : 0,
        max : $('#rewardsCount').text() - 1,
        value : 0,
        change : function(event, ui) {
            var val = ui.value;
            updateRewards(ui.value);
        }
    });
}

function SetFormPopup()
{
    /*
    $(".pnlBox").fancybox({
        helpers : {
            title : {
                type : 'inside'
            },
            overlay : {
                css : {
                    'background' : 'rgba(238,238,238,0.85)'
                }
            }
        }

    });

    $(".pnlBox").fancybox().trigger('click');
*/
}

function updateRewards(sliderVal) {

    var leaderText = $('#leaderRewardDesc' + sliderVal).text();
    var friendText = $('#friendRewardDesc' + sliderVal).text();

    $('#LeaderRewardPhrase').text(leaderText);
    $('#FriendRewardPhrase').text(friendText);

}
