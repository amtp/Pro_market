<?php
 // если пришли с страницы списка пользователей
$jinput = JFactory::getApplication()->input;
$userIDlist = $jinput->get('userid', '', '');
 require_once JPATH_SITE.'/components/com_content/helpers/route.php';
$db = JFactory::getDBO();
$userId = $userIDlist;
$html   = '';
$query = '                select a.id as aid, a.catid as catid, u.username, u.name, a.alias as aailas, a.title as atitle, a.introtext as atext, a.images as images, c.alias as catalias, c.title as ctitle
                from #__content as a                join #__categories as c on c.id = a.catid
                join #__users as u on u.id = a.created_by                where a.state = 1 and a.created_by = "'.$userId.'"
        '; 
$db->setQuery($query);
$rows = $db->loadObjectList();?>

<h3>Блог пользователя <?php echo $rows['0']->name ?></h3>
<p></p>
<?php foreach ($rows as $row){
        $rowslug = $row->aid.':'.$row->aailas;
		$rowcatslug = $row->catid.':'.$row->catalias;
		$link = JRoute::_(ContentHelperRoute::getArticleRoute($rowslug, $rowcatslug)); 
		$img = json_decode($row->images);
		?>
	
		<?php if($row->catid >= '1962' && $row->catid <= '1974') {?>
		<?php 
$i_id = $row->aid; 
$dir = opendir(''.JPATH_BASE.'/images/blog/'.$i_id.'');
	$count_photo = 0;
	while($file = readdir($dir)){
	if($file == '.' || $file == '..' || is_dir(''.JPATH_BASE.'/images/blog/'.$i_id.'' . $file)){
		continue;
	}
	$count_photo++;
} ?>

		<div class="kat_item padding">
<?php if($count_photo > 0) { ?>
	<div class="mod_news_img">
		<a href="<?php echo $link?>" title="<?php echo $item->title ?>"><span class="podlozhka"></span></a>
		<?php echo JHtml::_('content.prepare', '{gallery preview-width=255 preview-height=170}blog/'.$i_id.'{/gallery}'); ?>
	</div>
<?php } else { ?>
	<div class="old_mod_news_img">
		<a href="<?php echo $link?>" title="<?php echo $item->title ?>"><img class="lazy" src="<?php echo $img->image_intro ?>" alt="<?php echo $item->title ?>" /></a>
	</div><?php } ?><div class="kat_item_info">
				<h3><a href="<?php echo $link ?>"><?php echo $row->atitle ?></a></h3>
				<div class="intro_text">
					<?php echo $row->atext ?>
				</div>
				<div class="readmore">
					<a href="<?php echo $link ?>">Подробнее</a>
				</div>
			</div>
		</div>
		<?php } ?>
<?php } 


echo $html; 

?>

