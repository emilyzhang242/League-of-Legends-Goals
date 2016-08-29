//sticky filter tab
$(document).ready(function() {
	var stickyNavTop = $('#filter').offset().top-500;

	var stickyNav = function(){
		var scrollTop = $(window).scrollTop();

		if (scrollTop > stickyNavTop) { 
			$('#filter').addClass('sticky');
		} else {
			$('#filter').removeClass('sticky'); 
		}
	};

	stickyNav();

	$(window).scroll(function() {
		stickyNav();
	});
});

// this looks at the champ_stats file to try and create the tooltip
var delimiter = '|';

$(document).on("mouseover", ".table_buttons", function(){

	$(".table_buttons").mouseover(function() {
		var current = "#"+this.id;
		if ($(current).hasClass("neither")) {
			$(current).tooltip({
				disabled: true
			});
		}else{
			var strData = "";
			$.ajax({
				url : "champstats.txt",
				dataType: "text",
				async: false,
				success : function (data) {
					strData = data;
				}
			});
  			//Split values of string data
  			var array = strData.split("\n");
  			var aspects = [];
  			var final = [];
  			for (var x=0; x< array.length; x++) {
  				aspects = array[x].split(delimiter);
  				if (current.indexOf(aspects[0]) !== -1) {
  					final = aspects;
  					break;
  				}
  			}
			//decide what content to pick based on game stage
			var string = final[0]+": "+final[1]+"<br><br>";
			//creates new divs
			string += "<div class='row ttip'>";
			var pros = "<div class='col-md-6'><u>Pros</u><br>";
			var cons = "<div class='col-md-6'><u>Cons</u><br>";

			if ($(current).hasClass("early")) {
				for (var z=2; z < final.length; z++) {
					if (final[z].indexOf("lvl 6") != -1) {
						var start = final[z].indexOf(final[1]);
						var end = final[z].indexOf(":");
						if (final[z].indexOf("low") != -1) {
							cons += "Low " + final[z].substring(start+final[1].length+1, end)+"<br>";
						}else{
							pros += "High " + final[z].substring(start+final[1].length+1, end)+"<br>";
						}
					}
				}
			}else if ($(current).hasClass("mid")) {
				for (var z=2; z < final.length; z++) {
					if (final[z].indexOf("lvl11") != -1) {
						var start = final[z].indexOf(final[1]);
						var end = final[z].indexOf(":");
						if (final[z].indexOf("low") != -1) {
							cons += "Low " + final[z].substring(start+final[1].length+1, end)+"<br>";
						}else{
							pros += "High " + final[z].substring(start+final[1].length+1, end)+"<br>";
						}
					}
				}
			}else if ($(current).hasClass("late")) {
				for (var z=2; z < final.length; z++) {
					if (final[z].indexOf("lvl16") != -1) {
						var start = final[z].indexOf(final[1]);
						var end = final[z].indexOf(":");
						if (final[z].indexOf("low") != -1) {
							cons += "Low " + final[z].substring(start+final[1].length+1, end)+"<br>";
						}else{
							pros += "High " + final[z].substring(start+final[1].length+1, end)+"<br>";
						}
					}
				}
			}
			if (pros == "<div class='col-md-6'><u>Pros</u><br>") {
				pros += "No distinctive pros.";
			}
			if (cons == "<div class='col-md-6'><u>Pros</u><br>") {
				cons += "No distinctive cons.";
			}
			string = string + pros + "</div>" + cons+ "</div>";
			string+="</div>";
			$(current).tooltip({
				content: string,
			});
		}
	});
});

