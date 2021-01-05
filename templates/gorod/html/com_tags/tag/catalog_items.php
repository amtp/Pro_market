<?php

defined('_JEXEC') or die;

$user = JFactory::getUser();
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);
$rating_user = $templ->params->get('rating_user', '');
$money_no = $templ->params->get('money_no', '');


JFactory::getDocument()->addScriptDeclaration("
		var resetFilter = function() {
		document.getElementById('filter-search').value = '';
	}
");

?>
<div class="add_button mini_menu">
	<?php echo JHtml::_('content.prepare', '{loadposition home_catalog,none}'); ?>
</div>
<div class="category list-striped" itemscope itemtype="http://schema.org/ItemList">
	<?php foreach ($this->items as $i => $item) :
	foreach($item->jcfields as $field) {
		$f[$field->id] = $field->value;
	}
$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
$img = json_decode($item->images)->image_intro;
$item_id = $item->id;
$phone= $f[2];

	$date_now =  strtotime(date("d.m.Y G:i:s"));
    $date = $f[104]; //выделение цветом
    $d = new DateTime($date);
    $d->modify('+'.$f[103].' day');
    $data_color_end = strtotime($d->format("d.m.Y G:i:s"));//выделение цветом
?>
<script>
jQuery.fn.textToggle = function(d, b, e) {
    return this.each(function(f, a) {
        a = jQuery(a);
        var c = jQuery(d).eq(f),
            g = [b, c.text()],
            h = [a.text(), e];
        c.text(b).show();
        jQuery(a).click(function(b) {
            b.preventDefault();
            c.text(g.reverse()[0]);
            a.text(h.reverse()[0])
        })
    })
};
jQuery(function(){
jQuery('.click-tel<?php echo $item->id ?>').textToggle(".hide-tail<?php echo $item->id ?>","<?php echo $phone[0] ?><?php echo $phone[1] ?><?php echo $phone[2] ?><?php echo $phone[3] ?><?php echo $phone[4] ?><?php echo $phone[5] ?><?php echo $phone[6] ?><?php echo $phone[7] ?><?php echo $phone[8] ?><?php echo $phone[9] ?><?php echo $phone[10] ?><?php echo $phone[11] ?><?php echo $phone[12] ?><?php echo $phone[13] ?><?php echo $phone[14] ?>-XX","скрыть телефон")
});
</script>
<?php $dir = opendir(''.JPATH_BASE.'/images/katalog/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/katalog/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<div class="kat_item padding cat-list-row <?php if($data_color_end >= $date_now) { ?>pay_color<?php } ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo JRoute::_($item->link); ?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=255 preview-height=150}katalog/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_news_img">
		<a href="<?php echo JRoute::_($item->link); ?>" title="<?php echo $this->item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $item->title ?>" /></a>
	</div>
<?php } ?><div class="kat_item_info">
		<h3 itemprop="name">
			<a href="<?php echo JRoute::_($item->link); ?>" itemprop="url">
				<?php echo $this->escape($item->core_title); ?>
			</a>
		</h3>
		<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<div class="mini_icon">
			<?php if($f[73]) { ?>
			<div class="ic">
				<i class="fa fa-video-camera"></i>
			</div>
			<?php } ?>
			<div class="ic">
				<i class="fa fa-comments"></i>
					<?php
					$comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
					if (file_exists($comments)) {
					require_once($comments);
					$options = array();
					$options['object_id'] = $item->id;
					$options['object_group'] = 'com_content';
					$options['published'] = 1;
					$count = JCommentsModel::getCommentsCount($options);
					echo $count ? ''. $count . '' : '0';
				} ?>
			</div>
			<div class="ic">
				<?php if($rating_user == '0') { ?>
					<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $item->id ); ?>
				<?php } else { ?>
					<?php if($user->guest) { ?>
					<span class="no_rating">
						<a class="no_link" href="#login"></a>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $item->id ); ?>
					</span>
					<?php } else { ?>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $item->id ); ?>
					<?php } ?>
				<?php } ?>
			</div>
			<div class="ic_cat">
				<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($item->catid)); ?>" title="<?php echo $item->category_title ?>">
				<?php echo $item->category_title ?>
				</a>
			</div>
			<div class="ic_cat">
				<i class="fa fa-map-marker"></i>
				<span itemprop="streetAddress"><?php echo $f[1] ?></span>
			</div>
			<?php if($f[5]) { ?>
			<div class="ic_cat">
				<i class="fa fa-clock-o"></i>
				<?php echo $f[5] ?>
			</div>
			<?php } ?>
			<?php if($f[6]) { ?>
			<div class="ic_cat">
				<span>Выходные:</span>
				<?php echo $f[6] ?>
			</div>
			<?php } ?>
		</div
		><div class="phone_block">
			<div class="ic_big_phone">
				<i class="fa fa-mobile"></i>
				<span itemprop="telephone" class="hide-tail<?php echo $item->id ?>"><?php echo $phone ?></span>
				<small>
					<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $item->id ?>"> показать телефон</a>
				</small>
			</div>
			<!--noindex-->
			<?php if($f[3]) { ?>
			<div class="ic_big">
				<i class="fa fa-envelope-o"></i>
				<span><?php echo $f[3] ?></span>
			</div>
			<?php } ?>
			<?php if($f[4]) { ?>
			<div class="ic_big">
				<i class="fa fa-internet-explorer"></i>
				<a href="http://<?php echo $f[4] ?>" target="_blank">
					<span><?php echo $f[4] ?></span>
				</a>
			</div>
			<?php } ?>
			<!--/noindex-->
		</div>
	</div>
</div>
</div>
<?php endforeach; ?>
</div>

