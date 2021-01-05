<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

$user = JFactory::getUser();
$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$center_map = $template->params->get('center_map', '');


$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
?>
<script src="https://api-maps.yandex.ru/2.1/?apikey=85ad9d82-083c-4878-a858-401ac7bf15d1&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("YMaps_catalog", { 
		center: [<?php echo $center_map ?>], 
		zoom: 14, 
		 controls: ['zoomControl']
	});
	<?php foreach ($this->lead_items as &$item) : ?>
		<?php $this->item = &$item;
			foreach($this->item->jcfields as $field) { 
				$f[$field->id] = $field->value;
			} 
			$item_id = $this->item->id;
			$img = json_decode($this->item->images)->image_intro;
			$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
			?>

<?php $dir = opendir(''.JPATH_BASE.'/images/problem/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/problem/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>			
	var geocode = ymaps.geocode('г. <?php echo $gorod ?>, <?php echo $f[106] ?>', {results: 1});
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

			<?php if($f[108]) { ?>
			myPlacemark = new ymaps.Placemark([<?php echo $f[108] ?>], { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div><?php if($count_photo == 0) { ?><img src="/images/no_image.jpg" width="200px"/><?php } else { ?><img src="<?php echo $img ?>" width="250px"/><?php } ?> </div> <a href="<?php echo $link ?>"><?php echo $this->item->title ?></a>', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[106] ?></div>", 
				balloonContentFooter: "<div></div>", 
				hintContent: "<?php echo $this->item->title ?>, <?php echo $f[106] ?>" 
			}); 			
			<?php } else { ?>
			myPlacemark = new ymaps.Placemark(coords, { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<div class="problem_img"><div class="problem_status"><?php echo $f[107] ?></div><?php if($count_photo == 0) { ?><img src="/images/no_image.jpg" width="200px"/><?php } else { ?><img src="<?php echo $img ?>" width="250px"/><?php } ?> </div> <a href="<?php echo $link ?>"><?php echo $this->item->title ?></a>', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[106] ?></div>", 
				balloonContentFooter: "<div></div>", 
				hintContent: "<?php echo $this->item->title ?>, <?php echo $f[106] ?>" 
			}); 			
			<?php } ?>
	
			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
	<?php endforeach; ?>
} 
</script>
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h1> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title; ?></span>
			<?php endif; ?>
		</h1>
	<?php endif; ?>
<?php if($user->guest) { ?>
<div class="add_button mini_menu">
	<ul class="menu">
		<li class="add_resume">
			<a href="#login">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить проблему</span>
				</span>
			</a>
		</li>		
	</ul>
</div>
<?php } else { ?>
<div class="add_button mini_menu">
	<ul class="menu">
		<li class="add_resume">
			<a href="/add-problem">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить проблему</span>
				</span>
			</a>
		</li>		
	</ul>
</div>
<?php } ?>	
	
<div id="YMaps_catalog"></div>
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
			<?php foreach ($this->lead_items as &$item) : ?>
				<div class="kat_item kat_problem"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = & $item;
					echo $this->loadTemplate('item');
					?>
				</div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
	<?php endif; ?>

	<?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
				<div class="kat_item kat_problem"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = & $item;
					echo $this->loadTemplate('item');
					?>
				</div>
		<?php endforeach; ?>
	<?php endif; ?>

			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>