$(document).ready(function() {

    alert("Before slider 1");

    CreateAndInitializeSlider();

   // alert("Before email 1");
   // CreateAndInitializeEmailForm();
});


function CreateAndInitializeSlider()
{
    //$( ".selector" ).slider({ values: [1,5,9] });
    $("#slider").slider({
        min : 0,
        max : 4,
        value : 1,
        change : function(event, ui) {
            var val = ui.value;
            //alert(ui.value);
            updateRewards(ui.value);
        }
    });
}


function updateRewards(sliderVal) {
	$("#LeaderReward").val((3 - sliderVal) * 50);
	$("#FriendReward").val((sliderVal + 1) * 50);
}
