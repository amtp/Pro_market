
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("map", { 
		center: [43.1142146, 131.9259008],
		zoom: 14, 
		 controls: ['zoomControl']
	});
	
	var geocode = ymaps.geocode('г. <?php echo $this->item->category->name; ?>, <?php echo $extrafields[1];?>', {results: 1});
	geocode.then(
		function (res) {
			var firstGeoObject = res.geoObjects.get(0);
			coords = firstGeoObject.geometry.getCoordinates();
			myMap.setCenter([coords[0], coords[1]+0.010]);
			myMap.behaviors.disable('scrollZoom');	
			
			myPlacemark = new ymaps.Placemark(coords, { 
				balloonContentHeader: "<?php echo $this->item->title; ?>", 
				balloonContentBody: "<div>г. <?php echo $this->item->category->name; ?>, <?php echo $extrafields[1];?> </div>", 
				balloonContentFooter: "", 
				hintContent: "Нажмите, для того, что бы посмотреть подробности" 
			}); 

			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
} 