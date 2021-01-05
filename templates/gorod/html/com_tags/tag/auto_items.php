<?php

defined('_JEXEC') or die;

$user = JFactory::getUser();
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);	

$money_no = $templ->params->get('money_no', '');


JFactory::getDocument()->addScriptDeclaration("
		var resetFilter = function() {
		document.getElementById('filter-search').value = '';
	}
");

?>
<div class="add_button mini_menu">
	<?php echo JHtml::_('content.prepare', '{loadposition home_auto,none}'); ?>
</div>	
<div class="category list-striped" itemscope itemtype="http://schema.org/ItemList">
	<?php foreach ($this->items as $i => $item) : 
	foreach($item->jcfields as $field) { 
		$f[$field->id] = $field->value;
	}			
$link = JRoute::_(ContentHelperRoute::getArticleRoute($item->slug, $item->catid, $item->language));
$img = json_decode($item->images)->image_intro;
$item_id = $item->id;
$phone= $f[98];

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
<?php $dir = opendir(''.JPATH_BASE.'/images/avto/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/avto/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>

<div class="kat_item padding cat-list-row <?php if($data_color_end >= $date_now) { ?>pay_color<?php } ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo JRoute::_($item->link); ?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=255 preview-height=150}avto/'.$item_id.'{/gallery}'); ?>
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
		<?php if($f[100] == 'Да') { ?>
			<sup>новый</sup>
		<?php } ?>				
		</h3>
		<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<div class="mini_icon">
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
					<?php echo $this->item->parent_title ?> <?php echo $this->item->category_title ?>
				</a>
			</div>			

		<div class=" avto_icons">
		<?php if($f[93]) { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-gears"></i>
				<?php echo $f[93] ?>
			</div>
		</div>
		<?php } ?>
		<?php if($f[90]) { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-flask"></i>
				<?php echo $f[90] ?>
			</div>
		</div>
		<?php } ?>			
		
		<?php if($f[87]) { ?>
		<div class="ic_auto">	
			<div class="ic_cat">
				<i class="fa fa-automobile"></i>
				<?php echo $f[87] ?>
			</div>
		</div>
		<?php } ?>	

		<?php if($f[84]) { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-clock-o"></i>
				<?php echo $f[84] ?> г.в
			</div>
		</div>
		<?php } ?>	
		
		<?php if($f[85] > 0) { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-globe"></i>
				<?php echo number_format($f[85],0,'',' ') ?> км.
			</div>
		</div>
		<?php } else { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-globe"></i>
				Без пробега
			</div>
		</div>		
		<?php } ?>
		
		<?php if($f[89]) { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-paint-brush"></i>
				<?php echo $f[89] ?>
			</div>
		</div>
		<?php } ?>
		
		<?php if($f[94]) { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-circle-o-notch"></i>
				<?php echo $f[94] ?>
			</div>
		</div>
		<?php } ?>
		
		<?php if($f[86]) { ?>
		<div class="ic_auto">
			<div class="ic_cat">
				<i class="fa fa-cog"></i>
				<span <?php if($f[86] == 'Битый') { ?>style="color:#f00000"<?php } ?>><?php echo $f[86] ?>
			</div>
		</div>
		<?php } ?>		
		</div>
		</div
		><div class="phone_block">
			<div class="ic_big_phone">
				<i class="fa fa-mobile"></i>
				<span itemprop="telephone" class="hide-tail<?php echo $this->item->id ?>"><?php echo $phone ?></span>
				<small>
					<i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->id ?>"> показать телефон</a>
				</small>
			</div>
			<div class="ic">
				<div class="ic_big_phone doska_price">
					<span><?php echo number_format($f[96],0,'',' ') ?></span> <i class="fa fa-rub"></i>
				</div>
			</div>
			<div class="ic_cat">
				<i class="fa fa-user"></i>
				<?php echo $f[99] ?>
			</div>			
		</div>
	</div>	
</div>
</div>
<?php endforeach; ?>
</div>

