var text = "";
var delimiter = "|";

$(document).ready(function() {

	// PAGE LOADING --> EVERYTHING BELOW
	if ($("#process-data").length != 0) {
		console.log('processing data');
		text = "Loading Data. Please Wait.";
		$("#content").text(text);
	}
	//whenever next span class is added, remove the old one
	if ($("#successInsert").length != 0) {
		console.log("successfully inserted!");

		var data = document.getElementById('successInsert');

		if ($("#successInsert").hasClass('usernotexist')) {

			$.ajax({
				url: "/League/php/calc_match_length.php",
				type: "POST",
				data: {
					summoner: data.dataset.summ,
					summid: data.dataset.summid
				},
				success: function(text) {
					console.log("match length calculated");
					$("#successInsert").removeClass("calc_length");
					$("#successInsert").addClass("create_json");
					$("#content").text(text+" games found. We can write 5 games/sec to your JSON file. You do the math.");
					$("#bar").text('Creating JSON file');
					$("#bar").attr('aria-valuenow', 20);
					$("#bar").attr("style", 'width:20%');
					$("#bar").removeClass("progress-bar-danger");
					$("#bar").addClass("progress-bar-warning");
					create_json(text, data);
				},
				error: function() {
					$("#content").text("Could not process match length. Please email us.");
				}
			});
		}else if ($("#successInsert").hasClass('userexists')) {
			analyze_info(data);
		}
	}
});


function create_json(numgames, data) {

	$.ajax({
		url: "/League/php/user_loading.php",
		type: "POST",
		data: {
			summoner: data.dataset.summ,
			summid: data.dataset.summid,
			numgames: numgames
		},
		success: function() {
			console.log("loaded");
			$("#successInsert").removeClass("create_json");
			$("#successInsert").addClass("analyze");
			$("#content").text("Phew, that was hard. Analyzing your game data now...");
			$("#bar").text('Crunching Numbers');
			$("#bar").attr('aria-valuenow', 60);
			$("#bar").attr("style", 'width:60%');
			$("#bar").removeClass("progress-bar-warning");
			$("#bar").addClass("progress-bar-info");
			analyze_info(data);
		},
		error: function() {
			$("#content").text("Could not create JSON file. Please email us.");
		}
	});
}


function analyze_info(data) {

	$.ajax({
		url: "/League/php/analyze_matches.php",
		type: "POST",
		data: {
			summid: data.dataset.summid,
			delimiter: delimiter
		},
		success: function(text) {
			console.log("finished analyzing");
			$("#content").text("Great! Now give us a moment to write to the database.");
			$("#bar").text('Writing to Database');
			$("#bar").attr('aria-valuenow', 80);
			$("#bar").attr("style", 'width:80%');
			$("#bar").removeClass("progress-bar-warning");
			$("#bar").addClass("progress-bar-info");
			//console.log(text);
			database_insert(text, data);
		},
		error: function() {
			$("#content").text("Could not analyze the info. Please email us.");
		}
	});
}

function database_insert(info, data) {

	$.ajax({
		url: "/League/php/sql_analyze.php",
		type: "POST",
		data: {
			info: info,
			summid: data.dataset.summid,
			delimiter: delimiter
		},
		success: function(text) {
			$("#content").text("We're just constructing tables now. It'll be done in a moment.");
			$("#bar").text('Creating Website');
			$("#bar").attr('aria-valuenow', 95);
			$("#bar").attr("style", 'width:95%');
			$("#bar").removeClass("progress-bar-info");
			$("#bar").addClass("progress-bar-success");
			//console.log(text);
			load_website(data, text);
		},
		error: function(text) {
			$("#content").text("Could not construct the information. Please email us.");
		}
	});
}

function load_website(data, add_stats) {

	$.ajax({
		type: 'GET',
		url: "/League/userstats_constructed.php?summid="+data.dataset.summid+"&summoner="+data.dataset.summ
		+"&icon="+data.dataset.icon+"&elo="+data.dataset.elo,
		dataType: 'html',
		success: function(text) {
			$("#loaded-content").html(text);
			//load_minmax(add_stats);

			// hover for table-info
			if ($(".table-info").length !=0) {
				$(".table-info").mouseover(function(){
					var id = $(this).attr('id');
					if (id == "metric1" || id=="metric2") {
						$("#"+id).tooltip({
							content: "These are the stats that are being compared."
						});
					}else if (id == "wins1") {
						$("#"+id).tooltip({
							content: "Your Average [Division Average].<br>" 
							+ "Stats in red mean you're doing worse than the division average and green means better."
						});
					}else if (id=="losses1") {
						$("#"+id).tooltip({
							content: "Your Average [Division Average].<br>" 
							+ "Stats in red mean you're doing worse than the division average and green means better."
						});
					}else if (id=="wins2") {
						$("#"+id).tooltip({
							content: "Division Average [Your Average Difference].<br>" 
							+ "Stats in red mean you're doing worse than the division average and green means better."
						});
					}else if (id=="losses2") {
						$("#"+id).tooltip({
							content: "Division Average [Your Average Difference].<br>" 
							+ "Stats in red mean you're doing worse than the division average and green means better."
						});
					}
				});
			}
		},
		error: function(text) {
			$("#content").text("Website could not be constructed.");
			console.log(text);
		}
	});
}
// THIS FUNCTION ISN'T UPDATED FOR THE NEW WEBSITE FORMAT
function load_minmax(string) {
	var array = string.split(delimiter);
	array = array.slice(0, -1);
	console.log(array);
	for (var x=0; x<array.length; x+=2) {
		$('#minmax'+x).html("("+array[x+1]+" - "+array[x]+")");
	}
}


