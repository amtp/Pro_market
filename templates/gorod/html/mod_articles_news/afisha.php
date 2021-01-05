<?php defined('_JEXEC') or die ?>

<?php
$session = JFactory::getSession();
$citynid=$session->get('citynid', '');

$db = JFactory::getDboT();
$query = $db->getQuery(true);
$query->select('*');
$query->from('afishа');
if ($citynid != '') {
    $query->where('city_id =' . $db->quote($citynid));
}
$db->setQuery($query);
$datas = $db->loadObjectList();

?>
<?php if(count($datas)>0) { ?>
<div class="afisha <?php echo $moduleclass_sfx; ?>">
    <div class="mini_menu">
        <?php echo JHtml::_('content.prepare', '{loadposition right_afisha,none}'); ?>
    </div>
    <div class="carousel shadow">
        <div class="carousel-button-left"><a href="#"><i class="fa fa-angle-left" aria-hidden="true"></i></a></div>
        <div class="carousel-button-right"><a href="#"><i class="fa fa-angle-right" aria-hidden="true"></i></a></div>
        <div class="carousel-wrapper">
            <div class="carousel-items">
                <?php


                foreach ($datas as $key => $item) { ?>
                    <div class="carousel-block">
                        <div class="padding">
                            <?php require JModuleHelper::getLayoutPath('mod_articles_news', '_afisha'); ?>
                        </div>
                    </div>
                <?php } ?>


            </div>
        </div>
    </div>
</div>
<?php } ?>