var map, marker;

function initialize(){
	var mapProp = {
		center:new google.maps.LatLng(10.76155,78.815768),
		zoom:16,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

	google.maps.event.addListener(map, 'click', function(event) {
		placeMarker(event.latLng);
	});

	//var oldlat="<?php echo $row['lat'] ?>";
	//var oldlng="<?php echo $row['lng'] ?>";
	var oldloc = new google.maps.LatLng(oldlat, oldlng);
	console.log(oldloc);

	marker = new google.maps.Marker({
	 	position: oldloc,
	 	map: map,
	});
}

function placeMarker(location){
	marker.setMap(null);
	marker = new google.maps.Marker({
		position: location,
		map: map,
	});
	placed=1;
	document.getElementById('lat').value=location.lat();
	document.getElementById('lng').value=location.lng();
}

google.maps.event.addDomListener(window, 'load', initialize);