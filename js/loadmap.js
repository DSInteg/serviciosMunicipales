// DSInteg
// Inicializa Mapa dependiendo las coordenadas

function inicializamapa() {
	var mapOptions = {
		center: new google.maps.LatLng(-34.397, 150.644),
		zoom: 20,
		mapTypeId: google.maps.MapTypeId.HYBRID
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"),
	mapOptions);
}