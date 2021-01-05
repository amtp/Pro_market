<?php
defined('_JEXEC') or die;
$class = ' class="first"';
$lang  = JFactory::getLanguage();

if ($this->maxLevel != 0 && count($this->children[$this->category->id]) > 0) : ?>

	<?php foreach ($this->children[$this->category->id] as $id => $child) : 
	$item_id = $child->id;?>

<div class="afish_item" >
<div class="padding">

	<div class="mod_news_img">
		<div class="problem_img">
		<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>" title="<?php echo $this->item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=220 preview-height=330}photo/konkurs/'.$item_id.'{/gallery}'); ?>
		</div>
	</div>

<div class="afisha_item_info">			
				<h3><a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>">
				<?php echo $this->escape($child->title); ?></a></h3>

			<?php if ($this->maxLevel > 1 && count($child->getChildren()) > 0) : ?>
				<?php
				$this->children[$child->id] = $child->getChildren();
				$this->category = $child;
				$this->maxLevel--;
				echo $this->loadTemplate('children');
				$this->category = $child->getParent();
				$this->maxLevel++;
				?>
			<?php endif; ?>
			<div class="btn">
				<a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($child->id)); ?>"><i class="fa fa-bullhorn"></i> <span>Голосовать</span></a>
			</div>
	</div>
</div>
</div>	
	<?php endforeach; ?>

<?php endif;