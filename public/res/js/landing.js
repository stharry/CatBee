
$(document).ready(function() {
    CreateAndInitializeSlider();

    SetFormPopup();
});


function CreateAndInitializeSlider()
{
    //alert("<?=count($p->landing->landingRewards)?>");
    //$( ".selector" ).slider({ values: [1,5,9] });
    $("#slider").slider({
        min : 0,
        max : 3,
        value : 1,
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
	$("#LeaderReward").val((3 - sliderVal) * 50);
	$("#FriendReward").val((sliderVal + 1) * 50);
}
