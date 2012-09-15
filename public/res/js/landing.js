$(document).ready(function() {
	//$( ".selector" ).slider({ values: [1,5,9] });
	$("#slider").slider({
		min : 0,
		max : 2,
		value : 1,
		change : function(event, ui) {
			var val = ui.value;
			//alert(ui.value);
			updateRewards(ui.value);

		}
	});
});
function updateRewards(sliderVal) {
	$("#LeaderReward").val((3 - sliderVal) * 5);
	$("#FriendReward").val((sliderVal + 1) * 5);
}