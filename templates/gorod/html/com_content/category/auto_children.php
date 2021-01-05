<?php defined('_JEXEC') or die;
$lang  = JFactory::getLanguage();
if ($this->maxLevel != 0 && count($this->children[$this->category->id]) > 0) : ?>
	<?php foreach ($this->children[$this->category->id] as $id => $child) : ?>
		<?php
		if ($this->params->get('show_empty_categories') || $child->numitems || count($child->getChildren())) :
			if (!isset($this->children[$this->category->id][$id + 1])) :
				$class = ' class="last"';
			endif; ?>

<div class="cat_child <?php echo $child->note ?> <?php if($child->parent_id  == '290') { ?> cat_level0<?php } //скрываем непопулярные авто?>">
			<?php $class = ''; ?>
			<?php if ($lang->isRtl()) : ?>
			<h3 class="page-header item-title">
				<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
					<?php echo $child->getNumItems(true); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>">
				<?php echo $this->escape($child->title); ?></a>
			</h3>
			<?php else : ?>
			<h3 class="page-header item-title"><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>">
				<?php echo $this->escape($child->title); ?></a>
				<?php if ( $this->params->get('show_cat_num_articles', 1)) : ?>
					<sup><?php echo $child->getNumItems(true); ?></sup>
				<?php endif; ?>
			</h3>
			<?php endif; ?>

			<?php if ($this->params->get('show_subcat_desc') == 1) : ?>
			<?php if ($child->description) : ?>
				<div class="category-desc">
					<?php echo JHtml::_('content.prepare', $child->description, '', 'com_content.category'); ?>
				</div>
			<?php endif; ?>
			<?php endif; ?>


</div>
		<?php endif; ?>
	<?php endforeach; ?>

<?php endif;
