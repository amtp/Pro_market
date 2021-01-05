<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');

$user = JFactory::getUser();

?>
<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
<script src="//yastatic.net/share2/share.js"></script>

<div class="afisha_items" itemscope itemtype="https://schema.org/Blog">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
		</div>
	<?php endif; ?>
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
					<span>Учавствовать</span>
				</span>
			</a>
		</li>
	</ul>
</div>
<?php } else { ?>
<div class="add_button mini_menu">
	<ul class="menu">
		<li class="add_resume">
			<a href="/add-photo">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Учавствовать</span>
				</span>
			</a>
		</li>
	</ul>
</div>
<?php } ?>
	
	<?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
		<?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
		<?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
	<?php endif; ?>


		<div class="category-desc clearfix">
			<?php if ($this->params->get('show_description') && $this->category->description) : ?>
				<?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
			<?php endif; ?>
		</div>

	
		<div class="cat-children">
			<?php echo $this->loadTemplate('children'); ?> 
		</div>
			
<div class="items-leading clearfix">
	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
			<?php foreach ($this->lead_items as &$item) : ?>
				<div class="afish_item"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = &$item;
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
				<div class="afish_item"
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
