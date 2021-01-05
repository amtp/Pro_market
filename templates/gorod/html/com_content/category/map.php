<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

$user = JFactory::getUser();
$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$center_map = $template->params->get('center_map', '');

?>
<script src="https://api-maps.yandex.ru/2.1/?apikey=85ad9d82-083c-4878-a858-401ac7bf15d1&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("YMaps_catalog", { 
		center: [<?php echo $center_map ?>], 
		zoom: 13, 
		 controls: ['zoomControl']
	});
	<?php foreach ($this->lead_items as &$item) : ?>
		<?php $this->item = &$item;
			foreach($this->item->jcfields as $field) { 
				$f[$field->id] = $field->value;
			} ?>		
	var geocode = ymaps.geocode('г. <?php echo $gorod ?>, <?php echo $f[1] ?>', {results: 1});
	geocode.then(
		function (res) {
			// Выбираем первый результат геокодирования.
			var firstGeoObject = res.geoObjects.get(0);
			coords = firstGeoObject.geometry.getCoordinates();
			if (screen.width <= '480') {
				myMap.setCenter([coords[0], coords[1]+0.000]);
			} else {
				myMap.setCenter([coords[0], coords[1]+0.008]);
			}
			//myMap.setCenter([coords[0], coords[1]+0.008]);
			myMap.behaviors.disable('scrollZoom');	

			myPlacemark = new ymaps.Placemark(coords, { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<?php echo $this->item->title ?>', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[1] ?></div><div>Телефон: <b><i class='fa fa-mobile'></i> <?php echo $f[2] ?></b></div>", 
				balloonContentFooter: "<div>Режим работы: <?php echo $f[5] ?>, выходные: <?php echo $f[6] ?></div>", 
				hintContent: "Нажмите, для того, что бы посмотреть подробности" 
			}); 
	
			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
	<?php endforeach; ?>
} 
</script>
<div id="YMaps_catalog"></div>