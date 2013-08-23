var map, marker;

function initialize(){
	var mapProp = {
		center:new google.maps.LatLng(10.76155,78.815768),
		zoom:16,
		mapTypeId:google.maps.MapTypeId.ROADMAP
	};
	
	map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

	var oldloc = new google.maps.LatLng(oldlat, oldlng);
	console.log(oldloc);

	marker = new google.maps.Marker({
	 	position: oldloc,
	 	map: map,
	});
}

google.maps.event.addDomListener(window, 'load', initialize);