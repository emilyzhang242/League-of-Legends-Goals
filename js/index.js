//make sure username field is filled
$(document).ready(function() {
	$("#index").submit(function(event) {
		if ($("#summoner").val() != "" && $("#region").val() != "") {
			$(this).unbind('submit').submit();
			var summ = $("#summoner").val();
			var region = $('#region').val();
			$(this).change($(this).attr("action", "userstats.php?"+"summoner="+summ+"&region="+region));
		}
		event.preventDefault();
		var errors = "";
		if ($("#summoner").val() == "") {
			errors += "You didn't enter a summoner name! <br>";
		}
		if ($("#region").val() == "") {
			errors += "You didn't enter a region! <br>";
		}
		$("#errors").html(errors);
	});


});



