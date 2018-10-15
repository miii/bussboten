defaultCoords = new google.maps.LatLng(stopLatitude, stopLongitude);

$(document).ready(function() {
	
	$.getJSON(base_url + 'api/departures?stopID=' + stopID, function(data) {
	    				
		lines = new Array();
		data.data.buses.sort(function(a, b) {
			if (a.lineID > b.lineID) return 1;
			if (a.lineID < b.lineID) return -1;
			return 0;
		});
		
		for (index in data.data.buses) {
			lines[index] = data.data.buses[index].lineID;
			
			lineName = data.data.buses[index].name.split('-');
			$('#cards').append('<div class="cardwrapper"><div class="card"><div class="mobile_togglemap" data-id="' + index + '">Visa bussen</div><div class="map-canvas" id="map-canvas' + index + '"></div><section class="info"><h3>' + lineName[0] + '</h3><h2 id="time' + index + '">Laddar</h2><h4 id="string' + index + '"></h4></section></div></div>');
			
			mapOptions = {
			    center: defaultCoords,
			    zoom: 15,
			    mapTypeId: google.maps.MapTypeId.ROADMAP,
			    disableDefaultUI: true
			};
		
			map[index] = new google.maps.Map(document.getElementById("map-canvas" + index), mapOptions);
			m[index] = new google.maps.Marker({
			    position: fakeMarker,
			    map: map[index]
			});
			
		}
		
		$('.mobile_togglemap').click(function() {
			$(this).hide();
			$(this).siblings('.map-canvas').show();
			google.maps.event.trigger(map[$(this).attr('data-id')], 'resize');
		});
		setTimeout(function() {
			$('.da').fadeIn(1200);
		}, 1500);
		
		UpdateData(data.data.stop.stopID, lines, defaultCoords);
		
	});
	
});