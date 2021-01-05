<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');
$user = JFactory::getUser();
?>
<div class="catalg_items doska" itemscope itemtype="https://schema.org/Blog">
    <div class="page-header">
        <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
    </div>



<div class="add_button mini_menu">
	<?php echo JHtml::_('content.prepare', '{loadposition home_doska,none}'); ?>
    <span class="mobile" style="margin-top: 10px;">
            <?php if($user->guest) { ?>
                <ul class="menu">
		<li>
			<a href="#login" class="add_btn">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить объявление</span>
				</span>
			</a>
		</li>
	</ul>
            <?php } else { ?>
                <ul class="menu">
		<li>
			<a href="/add-doska" class="add_btn">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить объявление</span>
				</span>
			</a>
		</li>

	</ul>
            <?php } ?>






    </span>
</div>	
	<div class="product-view-button">
		<span>Вид: </span>
		<a href="#" class="grid active"><i class="fa fa-th-list"></i></a>
		<a href="#" class="list"><i class="fa fa-th"></i></a>
	</div>
    <?php
    $modules = JModuleHelper::getModules('cont_filter_d');
    foreach ($modules as  $mdlsitm){
        echo JModuleHelper::renderModule($mdlsitm);
    }
    ?>
	<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>

	<?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
		<div class="category-desc clearfix">
			<?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
				<img src="<?php echo $this->category->getParams()->get('image'); ?>" alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
			<?php endif; ?>
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
<div class="items-leading clearfix">
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->items_incity)) { ?>
		
			<?php foreach ($this->lead_items as &$item) : ?>
				<div class="kat_item"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
				<?php $leadingcount++; ?>
			<?php endforeach; ?>
    <?php } else { ?>
        <div class="nondoska">Объявлений по вашему запросу не найденно</div>
        <?php if (!empty($this->lead_items)) : ?>

            <h1>Объявления из ближайших городов:</h1>
            <?php foreach ($this->lead_items as $key => &$item) : ?>
                <div class="kat_item"
                     itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                    <?php
                    $this->item = &$item;
                    echo $this->loadTemplate('item');
                    ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
	<?php } ?>

	<?php
	$introcount = count($this->lead_items);
	$counter = 0;
	?>
<?php echo JHtml::_('content.prepare', '{loadposition reklama_doska,none}'); ?>

</div>



	<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?> </div>
	<?php endif; ?>
</div>
<script>
    var productView = localStorage.getItem('productView');
    if(productView == 'list'){
        jQuery('.product-view-button .grid').removeClass('active');
        jQuery('.product-view-button .list').addClass('active');
        jQuery('.items-leading .kat_item').removeClass('grid-view').addClass('list-view');    
    }
    jQuery('.product-view-button .grid').click(function(){
        localStorage.removeItem('productView');
        localStorage.setItem('productView', 'grid');
        jQuery('.product-view-button .list').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.items-leading .kat_item').removeClass('list-view').addClass('grid-view');
        return false;
    });
    jQuery('.product-view-button .list').click(function(){
        localStorage.removeItem('productView');
        localStorage.setItem('productView', 'list');
        jQuery('.product-view-button .grid').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.items-leading .kat_item').removeClass('grid-view').addClass('list-view');
        return false;
    });
</script>
