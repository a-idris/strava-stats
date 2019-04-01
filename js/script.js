$(document).ready(function() { 

	$('#current-loc-popup').on('click', function(){
		var popup = $('#current-location .popup');
		var blanket = document.getElementsByClassName('blanket')[0];
		popup.removeClass("hidden");
		$(window).on('click', function(event) {
			if(event.target == blanket) {
				console.log("clicked not popup");
				popup.addClass("hidden");
			}
		});
	});

	$('.item').on('click', function(){
		console.log('FOCUS');
	});

	$('.graphItem').on('click', function(){
		// $.post(
			// url:"main.php",get weather element, return weather data callback(data)
		// );
	});

	var graph = document.getElementById('wind-graph');
	var graphBars = graph.children;	
	var maxHeight = 0;
	for (var i = 0; i < graphBars.length; i++) {
		var temp = graphBars[i].children[0];
		var tempHeight = temp.id * 20;  
		var height = graphBars[i].id * 20;
		maxHeight = Math.max(maxHeight,height,tempHeight);
		graphBars[i].style.height = height+"px";
		temp.style.height = tempHeight+"px";
	}
	graph.style.height = (maxHeight + 50) + "px";

});

function rg(m, n) {
    return Math.floor( Math.random() * (n - m + 1) ) + m;
}

function hex(i) {
    return i.toString(16);
}

function randColor() {
    return '#' + hex(rg(1, 15)) + hex(rg(1, 15)) + hex(rg(1, 15)) +
        hex(rg(1, 15)) + hex(rg(1, 15)) + hex(rg(1, 15));
}