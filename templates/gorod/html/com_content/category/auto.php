<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
$this->category->text = $this->category->description;
$this->category->description = $this->category->text;

?>

<div class="auto catalg_items <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">
	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h1> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if($this->category->level == '3') { ?>
				<?php echo $this->category->getParent()->title ?>
			<?php } ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title; ?></span>
			<?php endif; ?>
		</h1>
	<?php endif; ?>
<div class="add_button mini_menu">
	<?php echo JHtml::_('content.prepare', '{loadposition home_auto,none}'); ?>
</div>	
	<?php if ($this->maxLevel != 0 && !empty($this->children[$this->category->id])) : ?>
		<div class="cat-children">
			<?php if($this->category->getParent()->title == 'ROOT') {//показываем выбор только на главной АВТО ?>
			<div class="auto_cool">
				<a href="#" class="grid active">Популярные</a>
				<a href="#" class="list">Все</a>
			</div>	
			<?php } ?>
			<?php echo $this->loadTemplate('children'); ?> 
		</div>
	<?php endif; ?>
	
	<div class="product-view-button">
		<span>Вид: </span>
		<a href="#" class="grid active"><i class="fa fa-th-list"></i></a>
		<a href="#" class="list"><i class="fa fa-th"></i></a>
	</div>	

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
	<?php if (!empty($this->lead_items)) : ?>
		
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

	<?php endif; ?>
<?php echo JHtml::_('content.prepare', '{loadposition reklama_auto,none}'); ?>
	<?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
				<div class="kat_item"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
		<?php endforeach; ?>
	<?php endif; ?>
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
	
	
   var productView = localStorage.getItem('auto');
    if(productView == 'list'){
        jQuery('.auto_cool .grid').removeClass('active');
        jQuery('.auto_cool .list').addClass('active');
        jQuery('.cat_child').removeClass('auto_cool').addClass('auto_all');    
    }
    jQuery('.auto_cool .grid').click(function(){
        localStorage.removeItem('auto');
        localStorage.setItem('auto', 'grid');
        jQuery('.auto_cool .list').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.cat_child').removeClass('auto_all').addClass('auto_cool');
        return false;
    });
    jQuery('.auto_cool .list').click(function(){
        localStorage.removeItem('auto');
        localStorage.setItem('auto', 'list');
        jQuery('.auto_cool .grid').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.cat_child').removeClass('auto_cool').addClass('auto_all');
        return false;
    });	
</script>
