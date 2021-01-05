<?php defined('_JEXEC') or die;
$document = JFactory::getDocument();
$app = JFactory::getApplication('site');
$templateparam = $app->getTemplate('true');
$gorod = $templateparam->params->get('gorod', '');
$center_map = $templateparam->params->get('center_map', '');
?>
<script src="https://api-maps.yandex.ru/2.1/?apikey=85ad9d82-083c-4878-a858-401ac7bf15d1&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("map", { 
		center: [<?php echo $center_map ?>], 
		zoom: 13, 
		controls: ['zoomControl']
	});
	<?php foreach ($list as $item) : ?>
<?php 

$img = json_decode($item->images);
foreach($item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	} ?>	
	var geocode = ymaps.geocode('г. <?php echo $gorod ?>, <?php echo $f[1] ?>', {results: 1});
	geocode.then(
		function (res) {
			// Выбираем первый результат геокодирования.
			var firstGeoObject = res.geoObjects.get(0);
			coords = firstGeoObject.geometry.getCoordinates();
			myMap.setCenter([coords[0], coords[1]+0]);
			myMap.behaviors.disable('scrollZoom');	

myPlacemark<?php echo $item->id ?> = new ymaps.Placemark(coords, { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<a href="<?php echo $item->link ?>"><?php echo $item->title ?></a>', 
				balloonContentBody: "<div><?php echo $gorod ?>, <?php echo $f[1] ?></div><div>Телефон: <b><i class='fa fa-mobile'></i> <?php echo $f[2] ?></b></div>", 
				balloonContentFooter: "<div>Режим работы: <?php echo $f[5] ?>, выходные: <?php echo $f[6] ?></div>", 
				hintContent: "Нажмите, для того, что бы посмотреть подробности" 
}); 
			myMap.geoObjects.add(myPlacemark<?php echo $item->id ?>); 
		},
		function (err) {
		}
	);
	<?php endforeach; ?>
} 
    </script>
	
<div id="map">
<div class="new_all_portal">
	<div class="mod_vip">
		<?php echo JHtml::_('content.prepare', '{loadposition home_vip}'); ?>
	</div>
</div>
</div>