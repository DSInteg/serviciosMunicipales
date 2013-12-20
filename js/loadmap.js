// DSInteg
// Inicializa Mapa dependiendo las coordenadas

function inicializamapa(latitud,longitud) {
		var mapOptions = {
		center: new google.maps.LatLng(latitud,longitud),
		zoom: 20,
		mapTypeId: google.maps.MapTypeId.HYBRID
	};
	var map = new google.maps.Map(document.getElementById("map_canvas"),
	mapOptions);

}