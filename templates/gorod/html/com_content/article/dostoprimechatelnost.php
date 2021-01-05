<?php
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$images = json_decode($this->item->images);
$user = JFactory::getUser();
JHtml::_('behavior.caption');
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';

$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$maps = $template->params->get('maps', '');
$center_map = $template->params->get('center_map', '');
$api_key = $template->params->get('api_key', '');
$ya_knopki = $template->params->get('ya_knopki', '');

foreach($this->item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}
$domen = JUri::base();	
?>

<script src="https://api-maps.yandex.ru/2.1/?apikey=85ad9d82-083c-4878-a858-401ac7bf15d1&lang=ru_RU" type="text/javascript"></script>
<script type="text/javascript">
ymaps.ready(init); 
function init () { 
    var myMap = new ymaps.Map("YMapsID", { 
		center: [<?php echo $center_map ?>], 
		zoom: 15, 
		 controls: ['zoomControl']
	});
	
	var geocode = ymaps.geocode('г. <?php echo $gorod ?>, <?php echo $f[67] ?>', {results: 1});
	geocode.then(
		function (res) {
			// Выбираем первый результат геокодирования.
			var firstGeoObject = res.geoObjects.get(0);
			coords = firstGeoObject.geometry.getCoordinates();
			myMap.setCenter([coords[0], coords[1]+0]);
			myMap.behaviors.disable('scrollZoom');	

			
			myPlacemark = new ymaps.Placemark(coords, { 
				// Чтобы балун и хинт открывались на метке, необходимо задать ей определенные свойства. 
				balloonContentHeader: '<?php echo $this->item->title ?>', 
				balloonContentBody: "<div>г. <?php echo $gorod ?>, <?php echo $f[67] ?></div>", 
				balloonContentFooter: "<?php if($f[68]) { ?><div>Режим работы: <?php echo $f[68] ?></div><?php } ?>", 
				hintContent: "Нажмите, для того, что бы посмотреть подробности" 
			}); 

			myMap.geoObjects.add(myPlacemark); 
		},
		function (err) {
		}
	);
} 
    </script>

<div class="news_all <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Article">

<?php if($this->item->featured)	{ ?>
	<div class="featured">
		<span class="fa-stack fa-lg">
		<i class="fa fa-thumbs-o-up fa-stack-1x"></i>
		<i class="fa fa-circle-o-notch fa-spin fa-stack-2x"></i>
		</span>
		<span>Мы рекомендуем</span>
	</div>
<?php } ?>
	<meta itemprop="inLanguage" content="<?php echo ($this->item->language === '*') ? JFactory::getConfig()->get('language') : $this->item->language; ?>" />
	<h1 itemprop="headline">
		<?php echo $this->escape($this->item->title); ?>
	</h1>
	<div class="mini_icons">
		<div class="ic">
			<i class="fa fa-calendar-check-o"></i>
			<?php echo JHTML::_('date', $this->item->created , JText::_('DATE_FORMAT_LC3')); ?>
		</div>
		<div class="ic">
			<i class="fa fa-eye"></i>
			<?php echo $this->item->hits ?>
		</div>
		<div class="ic">
			<i class="fa fa-comments"></i>
				<?php
					$comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
					if (file_exists($comments)) {
					require_once($comments);
					$options = array();
					$options['object_id'] = $this->item->id;
					$options['object_group'] = 'com_content';
					$options['published'] = 1;
					$count = JCommentsModel::getCommentsCount($options);
					echo $count ? ''. $count . '' : '0';
				} ?>
		</div>	
		<div class="ic_cat">
			<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($this->item->catid)); ?>" title="<?php echo $this->item->category_title ?>">
			<?php echo $this->item->category_title ?>
			</a>
			<ul class="tags inline">
				<?php foreach ($this->item->tags->itemTags as $i => $tag) : ?>
					<?php if (in_array($tag->access, $authorised)) : ?>
						<?php $tagParams = new Registry($tag->params); ?>
						<?php $link_class = $tagParams->get('tag_link_class', 'label label-info'); ?>
						<li class="tag-<?php echo $tag->tag_id; ?> tag-list<?php echo $i; ?>" itemprop="keywords">
							<a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($tag->tag_id . '-' . $tag->alias)); ?>" class="<?php echo $link_class; ?>">
								<span class="fa fa-hashtag"></span> <?php echo $this->escape($tag->title); ?>
							</a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>				
		</div>	
	</div>
	<div class="news_logo_block">
		<div class="news_logo">
			<img class="lazy" src="<?php echo $images->image_intro ?>"/>
		</div>
	</div>
	<?php if($ya_knopki == '1') { ?>
	<div class="social_button">
		<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
		<script src="//yastatic.net/share2/share.js"></script>
		<div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,moimir,gplus" data-counter="" data-image="<?php echo $domen;?>/<?php echo $images->image_intro;?>" data-description="<?php echo $this->item->fulltext?>"></div>	
	</div>
	<?php } ?>
	<div class="icons_dostoprim">
		<div class="ic_cat">
			<i class="fa fa-map-marker"></i>
			<?php echo $f[67] ?>
		</div>
		<?php if($f[68]) { ?>
		<div class="ic_cat">
			<i class="fa fa-clock-o"></i>
			<?php echo $f[68] ?>
		</div>	
		<?php } ?>
		<?php if($f[69]) { ?>
		<div class="ic_big_phone">
			<i class="fa fa-mobile"></i>
			<?php echo $f[69] ?>
		</div>	
		<?php } ?>		
	</div>	
	<div class="intro_text_item">
		<?php echo $this->item->introtext?>
	</div>		


<div class="gallery">	

</div>
	
	
	<div class="desc">
		<?php echo $this->item->fulltext?>
	</div>	

<div id="YMapsID">
</div>


<div class="module_top">
<h3><span class="fa fa-comments"></span> Отзывы</h3>
</div>
	<?php
		$comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
		if (file_exists($comments)) {
		require_once($comments);
		echo JComments::showComments($this->item->id, 'com_content', $this->item->title);
		}
	?>
</div>


