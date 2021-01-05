<?php
defined('_JEXEC') or die;

$attributes = array();

if ($item->anchor_title)
{
	$attributes['title'] = $item->anchor_title;
}

if ($item->anchor_css)
{
	$attributes['class'] = $item->anchor_css;
}

if ($item->anchor_rel)
{
	$attributes['rel'] = $item->anchor_rel;
}

$linktype = $item->title;

if ($item->menu_image)
{
	$linktype = JHtml::_('image', $item->menu_image, $item->title);

	if ($item->params->get('menu_text', 1))
	{
		$linktype .= '<span class="image-title">' . $item->title . '</span>';
	}
}

if ($item->browserNav == 1)
{
	$attributes['target'] = '_blank';
}
elseif ($item->browserNav == 2)
{
	$options = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes';

	$attributes['onclick'] = "window.open(this.href, 'targetWindow', '" . $options . "'); return false;";
} 
?>
<a href="<?php echo $item->flink ?>#link">
	<?php if($item->anchor_css) { ?>
		<span class="<?php echo $item->anchor_css ?>"></span>
	<?php } ?>
	<span class="menu_txt">
		<span><?php echo $item->title ?></span>
	<?php if($item->anchor_title) { ?>
		<small><?php echo $item->anchor_title ?></small>
	<?php } ?>
	</span>
	<?php if($item->note) { //дополнение к меню (пишеться в примечании пункта меню)?>
		<span class="note">
			<?php echo $item->note ?>
		</span>
	<?php } ?>
</a>

