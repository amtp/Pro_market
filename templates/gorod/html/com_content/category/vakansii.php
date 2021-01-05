<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
jimport( 'joomla.application.module.helper' );
$user = JFactory::getUser();
?>
<div class="catalg_items <?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Blog">

	<?php if ($this->params->get('show_category_title', 1) or $this->params->get('page_subheading')) : ?>
		<h1> <?php echo $this->escape($this->params->get('page_subheading')); ?>
			<?php if ($this->params->get('show_category_title')) : ?>
				<span class="subheading-category"><?php echo $this->category->title; ?></span>
			<?php endif; ?>
		</h1>
	<?php endif; ?>
<?php if($user->guest) { ?>
<div class="mobile add_button mini_menu">
	<ul class="menu">
		<li >
			<a href="#login" class="add_btn">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить вакансию</span>
				</span>
			</a>
		</li>
		<li>
			<a href="#login" class="add_btn">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить резюме</span>
				</span>
			</a>
		</li>		
	</ul>
</div>
<?php } else { ?>
<div class="mobile add_button mini_menu">
	<ul class="menu">
		<li >
			<a href="/add-vakansiya" class="add_btn">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить вакансию</span>
				</span>
			</a>
		</li>
		<li>
			<a href="/add-resume" class="add_btn">
				<span class="fa fa-plus"></span>
				<span class="menu_txt">
					<span>Добавить резюме</span>
				</span>
			</a>
		</li>		
	</ul>
</div>
<?php } ?>



    <div class="rabota padding catex">
        <?php
        $module = JModuleHelper::getModules('catex_vacancy');
        echo JModuleHelper::renderModule($module[0]);
        ?>
    </div>

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


	<?php $leadingcount = 0; ?>
	<?php if (!empty($this->lead_items)) : ?>
		<?php foreach ($this->lead_items as &$item) : ?>
			<div class="kat_item rabota"
				itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
				<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
				?>
			</div>
			<?php $leadingcount++; ?>
		<?php endforeach; ?>
	<?php endif; ?>
<?php echo JHtml::_('content.prepare', '{loadposition reklama_vakansii,none}'); ?>
	<?php
	$introcount = count($this->intro_items);
	$counter = 0;
	?>

	<?php if (!empty($this->intro_items)) : ?>
		<?php foreach ($this->intro_items as $key => &$item) : ?>
				<div class="kat_item rabota"
					itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
					<?php
					$this->item = &$item;
					echo $this->loadTemplate('item');
					?>
				</div>
		<?php endforeach; ?>
	<?php endif; ?>


	<?php if (($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
		<div class="pagination">
			<?php if ($this->params->def('show_pagination_results', 1)) : ?>
				<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
			<?php endif; ?>
			<?php echo $this->pagination->getPagesLinks(); ?> </div>
	<?php endif; ?>
</div>