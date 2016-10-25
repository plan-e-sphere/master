  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <style type="text/css">
		#map-canvas {width: 100%; height: 400px; margin: 0; padding: 0;}
    </style>
<script>
var map;
var lat;
var lng;

function maPosition(position) {
	lat=position.coords.latitude;
	lng=position.coords.longitude;
}
navigator.geolocation.getCurrentPosition(maPosition);

function initialize() {
	var mapOptions = {
		zoom: 12,
		center: new google.maps.LatLng((lat+<?php echo $events->adresses_lat;?>)/2, (lng+<?php echo $events->adresses_lng;?>)/2)
	};
	map = new google.maps.Map(document.getElementById('map-canvas'),mapOptions);
	directionsDisplay = new google.maps.DirectionsRenderer({draggable:true});
	directionsDisplay.setMap(map);
	directionsDisplay.setPanel(document.getElementById("map-panel"));
	
	current_pos = new google.maps.LatLng(lat,lng);
	end_pos = new google.maps.LatLng(<?php echo $events->adresses_lat;?>, <?php echo $events->adresses_lng;?>);
	var request = {
		origin:current_pos,
		destination:end_pos,
		travelMode: google.maps.TravelMode.DRIVING
	};
	var directionsService = new google.maps.DirectionsService();
	directionsService.route(request, function(result, status) {
		if (status == google.maps.DirectionsStatus.OK) {
			directionsDisplay.setDirections(result);
		}
	});
	
}
</script>	
<div class="col-md-5">
	<h2>Adresse</h2>
	<?php echo $events->adresses_num_voie." ".$events->adresses_voie."<br/>".$events->adresses_cp." ".$events->adresses_ville."<br/>".$events->adresses_pays;?>
</div>
<div class="col-md-7">
	<div id="map-canvas"></div>
	<div id="map-panel"></div>
</div>