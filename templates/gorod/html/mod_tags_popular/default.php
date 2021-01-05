<?php
defined('_JEXEC') or die;

?>
<?php JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php'); ?>
<div class="tagspopular<?php echo $moduleclass_sfx; ?>">
<?php if (!count($list)) : ?>
	<div class="alert alert-no-items"><?php echo JText::_('MOD_TAGS_POPULAR_NO_ITEMS_FOUND'); ?></div>
<?php else : ?>
	<ul>
<?php foreach ($list as $item) : ?>
<li>
		<a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($item->tag_id . '-' . $item->alias)); ?>">
			<span class="fa fa-hashtag"></span>
			<?php echo htmlspecialchars($item->title, ENT_COMPAT, 'UTF-8'); ?>
		<?php if ($display_count) : ?>
			<sup class="tag-count badge badge-info"><?php echo $item->count; ?></sup>
		<?php endif; ?>			
		</a>
</li>
<?php endforeach; ?>
	</ul>
<?php endif; ?>
</div>
