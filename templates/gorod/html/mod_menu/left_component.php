<?php
defined('_JEXEC') or die;
$app = JFactory::getApplication('gorod');
$temparam = $app->getTemplate('gorod');
$count_menu = $temparam->params->get('count_menu', '');

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
if($count_menu > 0) {
    $catid = $item->query['id'];
    $db = JFactory::getDbo();
    $listarrprnt=array();
    if($item->parent && ($item->alias !="cacacat" && $item->alias !="rereret" )) {
        $queryP = $db->getQuery(true);
        $queryP->select('a.id');
        $queryP->from('#__categories AS a');
        $queryP->where('a.parent_id = ' . (int)$catid);
        $db->setQuery($queryP);
        $listarrprnt= $db->loadRowList2();
    }
    if (count($listarrprnt)>0)
    {
        $listarrp_rnt = implode(',', $listarrprnt);
        $db->setQuery("SELECT COUNT(`id`) FROM #__content WHERE state='1' AND catid IN ($listarrp_rnt)");
    }
    else{
        $db->setQuery("SELECT COUNT(`id`) FROM #__content WHERE state='1' AND catid='$catid'");
    }
$count = $db->loadResult();
}

?>

<a href="<?php echo $item->flink ?>#link">


        <span class="menu_txt">
              	<span class="nmencatx">

<?php if($item->anchor_css) { ?>
<span class="<?php echo $item->anchor_css ?>">
    </span><?php } ?>
       </span>
		<span class="ttext">
			<?php echo $item->title ?>
		</span>
		<sup><?php echo $count ?></sup>

	<?php if($item->anchor_title && $item->parent) { ?>
        <small><?php echo $item->anchor_title ?></small>
    <?php } ?>
	</span>


</a>
<?php if($item->parent && ($item->alias !="vakansii" && $item->alias !="rezyume" )) { ?>
<i class="fa fa-angle-down spoiler"></i>
<?php } ?>