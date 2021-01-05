<?php defined('_JEXEC') or die;
$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);
$valuta1 = $templ->params->get('valuta', '');

$item_id = $this->item->id;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($this->item->slug, $this->item->catid, $this->item->language));
$img = json_decode($this->item->images)->image_intro;
foreach($this->item->jcfields as $field) { 
	$f[$field->id] = $field->value;
}
require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';
$user = JFactory::getUser();	
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);	
$rating_user = $templ->params->get('rating_user', '');
$money_no = $templ->params->get('money_no', '');	
$phone= $f[66];

	$date_now =  strtotime(date("d.m.Y G:i:s"));
    $date = $f[104]; //выделение цветом
    $d = new DateTime($date);
    $d->modify('+'.$f[103].' day');
    $data_color_end = strtotime($d->format("d.m.Y G:i:s"));//выделение цветом


$path   = JPATH_ROOT.'/templates/'.$app->getTemplate().'/';
if(!class_exists('Mobile_Detect'))require_once ($path.'Mobile_Detect.php');
$detect = new Mobile_Detect;
$ismobl=0;
if( $detect->isMobile())$ismobl=1;

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
jQuery('.click-tel<?php echo $this->item->id ?>').textToggle(".hide-tail<?php echo $this->item->id ?>","<?php echo $phone[0] ?><?php echo $phone[1] ?><?php echo $phone[2] ?><?php echo $phone[3] ?><?php echo $phone[4] ?><?php echo $phone[5] ?><?php echo $phone[6] ?><?php echo $phone[7] ?><?php echo $phone[8] ?><?php echo $phone[9] ?><?php echo $phone[10] ?><?php echo $phone[11] ?><?php echo $phone[12] ?><?php echo $phone[13] ?><?php echo $phone[14] ?>-XX","скрыть телефон")
});
</script>
<?php $dir = opendir(''.JPATH_BASE.'/images/realty/'.$item_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/realty/'.$item_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>
<div class="<?php if($data_color_end >= $date_now) { ?>pay_color<?php } ?>">
	<?php if($money_no == 1) { ?>	
	<div class="pay_block">
		<?php if($user->guest) { ?>
			<a class="pay_button" href="#login"><i class="fa fa-bar-chart"></i> Продать быстрее</a>
		<?php } else { ?>
			<?php if($user->id == $this->item->created_by) { ?>
				<span class="pay_btn">
					<span class="pay_btn_cell">
						<a href="<?php echo $link ?>#pay-vip"><i class="fa fa-star"></i></a>
					</span>
					<span class="pay_btn_txt">
						<span>VIP статус</span>
					</span>
				</span>				
			<?php if($data_color_end < $date_now) { ?>
				<span class="pay_btn">
					<span class="pay_btn_cell">
						<a href="<?php echo $link ?>#pay-color"><i class="fa fa-paint-brush"></i></a>
					</span>
					<span class="pay_btn_txt">
						Выделить цветом
					</span>					
				</span>
			<?php } else { ?>
				<span class="pay_btn">
					<span class="pay_btn_cell">
						<i class="fa fa-paint-brush"></i>
					</span>
					<span class="pay_btn_txt">
						до <?php echo $d->format("d.m.Y G:i") ?>
					</span>					
				</span>			
			<?php } ?>
				<span class="pay_btn">
					<span class="pay_btn_cell">
						<a href="<?php echo $link ?>#pay-top"><i class="fa fa-arrow-up"></i></a>
					</span>
					<span class="pay_btn_txt">
						Поднять наверх
					</span>						
				</span>
			<?php } ?>
		<?php } ?>
	</div>
	<?php } ?>

    <?php if ($ismobl != 0){ ?>
    <div class="kat_item_head">	<h3>
            <a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>">
                <span itemprop="name"><?php echo $this->item->title ?></span>
            </a>
        </h3></div>
    <?php }?>
    <div class="paddingonl">
<?php if($count_photo > 10000) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=255 preview-height=170}realty/'.$item_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
    <div class="old_mod_news_img">
        <a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>"><img class="lazy" src="<?php echo $img ?>" alt="<?php echo $this->item->title ?>" /></a>
    </div>
<?php } ?>	
<div class="kat_item_info">
    <?php if ($ismobl == 0){ ?>
        <div class="kat_item_head">	<h3>
                <a href="<?php echo $link?>#link" title="<?php echo $this->item->title ?>">
                    <span itemprop="name"><?php echo $this->item->title ?></span>
                </a>
            </h3></div>
    <?php }?>
	
		<div itemprop="address" class="additm" itemscope itemtype="http://schema.org/PostalAddress">
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
			<div class="ic_cat">
				<i class="fa fa-level-up"></i>
				Этаж: <?php echo $f[48] ?> из <?php echo $f[49] ?>
			</div>
			<div class="ic_cat">
				<i class="fa fa-map-marker"></i>
				<?php echo $f[41] ?>
			</div>
			<div class="ic_cat">
				<i class="fa fa-building-o"></i>
				Дом: <?php echo $f[43] ?>
			</div>			
			<div class="ic_cat">
				<i class="fa fa-calculator"></i>
				Площадь: <?php echo $f[50] ?> м<sup>2</sup>
			</div>
			<div class="ic_cat">
				<i class="fa fa-s15"></i>
				Санузел: <?php echo $f[53] ?>
			</div>		
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
					<span><?php

                        echo number_format(intval($f[62]),0,'',' ')

                        ?></span> <?php echo $valuta1 ?>
				</div>
			</div>
			<div class="ic_cat">
				<i class="fa fa-check"></i>
				<?php echo $f[64] ?>
			</div>				
			<div class="ic_cat">
				<i class="fa fa-user"></i>
				<?php echo $f[65] ?>
			</div>
		</div>
	</div>	
</div>
    </div>
</div>

