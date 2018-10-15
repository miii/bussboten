map = new Array();
m = new Array();
line = new Array();
fakeMarker = new google.maps.LatLng(40.659271,17.177896);

date = new Array();
timeString = new Array();

if(typeof(Storage)!=="undefined") {
	$(document).ready(function() {
		savedStops = JSON.parse(localStorage.getItem('savedStops')) == null ? new Array() : JSON.parse(localStorage.getItem('savedStops'));
		savedStops.reverse();
		$.each(savedStops, function(index, value) {
			$('#favorites').append('<option value="' + value.url + '">' + value.name + '</option>');
		});
		savedStops.reverse();
		
		$('#stoplist select').change(function() {
			if ($('option:selected', this).text() != "Hitta närmaste") {
				var self = this;
				$.each(savedStops, function(index, value) {
					if (value.url == $(self).val()) spliceIndex = index;
				});
				if (spliceIndex !== undefined) savedStops.splice(spliceIndex, 1);
				savedStops.push({
					name: $('option:selected', this).text(),
					url: $(this).val()
				});
				localStorage.setItem('savedStops', JSON.stringify(savedStops));
			}
			location.href = $(this).val();
		});
	});
} else {
	console.warn("Can't save stop history, no localStorage support");
}

function UpdateData(stopID, lines, defaultCoords) {
	
	$.getJSON(base_url + 'api/nextbus?stopID=' + stopID + '&lineID=' + lines.join(','), function(data) {
		
		var i = 0;
		
		for(line in data.data.lines) {
		
			date[i] = new Date();
			date[i].setTime(data.data.lines[line].estimatedDeparture);
			timeString[i] = TimeString(date[i].getHours(), date[i].getMinutes(), data.data.lines[line].departureIn);
			
			$('#time' + i).text(timeString[i]['clock']);
	        $('#string' + i).text(timeString[i]['string']);
		
			if (data.data.lines[line].name != null) {
		        m[i].setPosition(new google.maps.LatLng(data.data.lines[line].latitude, data.data.lines[line].longitude));
				map[i].panTo(m[i].getPosition());
			} else {
				m[i].setPosition(fakeMarker);
				map[i].panTo(defaultCoords);
			}
			
			i++;
			
		}

		setTimeout(function() {
			UpdateData(stopID, lines, defaultCoords);
		}, 10000);
		
	});
}

function TimeString(hours, minutes, departureIn) {
	var data = new Array();
	
	hours = hours.toString().length > 1 ? hours : "0" + hours;
	minutes = minutes.toString().length > 1 ? minutes : "0" + minutes;
	
	if (departureIn == null) {
		data['clock'] = 'Avgått';
		data['string'] = '';
		return data;
	}
	
	data['clock'] = hours + ':' + minutes;
	
	if (departureIn == 0)
		data['string'] = 'Om några sekunder';
	else if (departureIn < 100)
		data['string'] = 'Om ' + departureIn + ' ' + (departureIn == 1 ? 'minut' : 'minuter');
	else
		data['string'] = 'Om ' + Math.round(departureIn / 60) + ' timmar';
	
	return data;
}