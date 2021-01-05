<?php
defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
jimport('joomla.application.module.helper');
require_once($_SERVER['DOCUMENT_ROOT'] . '/modules/medoo/catalog_models.php');

use Company\Company_List;
use Joomla\CMS\Mdata\MdataHelper;

JHtml::_('behavior.caption');
JHtml::_('behavior.modal');

$doc = JFactory::getDocument();
$user = JFactory::getUser();
$domen = JUri::base();
if (substr($domen, -1) == DIRECTORY_SEPARATOR) $domen = substr($domen, 0, strlen($domen) - 1);


$pagelimit = 15;

$app = JFactory::getApplication();
$jinput = $app->input;
$pgstart = $jinput->get('start', 0, 'int');

$aname = $jinput->get('aname', '', 'string');

$session = JFactory::getSession();

$cityname = $session->get('cityname', 'Все города');
$cityid = $session->get('cityid', '00000000-0000-0000-0000-000000000000');
$ismobil =JFactory::$ismobile;


//$cityid= "dasd";
$catguid = $this->category->alias;

$doc->addStyleSheet(JURI::base() . 'plugins/content/vrvote/assets/vrvote.css');
$doc->addScript(JURI::base() . 'plugins/content/vrvote/assets/vrvote.js');
$doc->addScript('citytmpl/js/catalog.js', array('version' => 'auto'));

$doc->addScript('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js');
$doc->addScript('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js');
$doc->addScript(JURI::base() . 'citytmpl/js/datatables.min.js');


$dlisttofile = array();
?>


<!-- <a href="/map-catalog">Показать на карте</a> -->
<div class="catalg_itemsd" itemscope itemtype="https://schema.org/Blog">
    <div class="page-header">
        <h1> <?php echo $this->escape($this->params->get('page_heading')); ?> </h1>
    </div>
    <input type=hidden id="cgl" name="rmparam" value="	<?php echo $catguid; ?>"/>

    <div class="pre-hfix" id="tpre_fix"></div>
    <div hmfix class="h-fix" id="clfix">

        <?php
        $modules = JModuleHelper::getModules('h_fix');
        foreach ($modules as $mdlsitm) {
            echo JModuleHelper::renderModule($mdlsitm);
        }

        ?>




        <div class="product-view-button">
            <span>Вид: </span>
            <a href="#" class="grid active"><i class="fa fa-th-list"></i></a>
            <a href="#" class="list"><i class="fa fa-th"></i></a>
        </div>
        <?php
        $modules = JModuleHelper::getModules('cont_filter');
        foreach ($modules as $mdlsitm) {
            echo JModuleHelper::renderModule($mdlsitm);
        }
        ?>


        <div class="filter-toolbar" role="toolbar" aria-label="Фильтр поиска" id="filter">
            <div class="bgfl">
                <div class="btns-fltr">

                    <div class="btn-wrapper dwnl-filtr" id="list-download" onclick="filterclic(this)">
        <span class="filter-main adn-fltr" tabindex="1">
            <i class="fa fa-download" aria-hidden="true"></i>
           <span class="filter-dtxt"> Скачать </span></span>
                        <span class="rl-prm">
                            <i class="fa fa-file-text-o" aria-hidden="true"></i>
                           <span class="n-dopj">Показанные</span>
                    </span>


                        <ul class="sub-filter">
                            <i class="fa fa-sort-up" aria-hidden="true"></i>
                            <table id="datalistbl" class="display" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Компания</th>
                                    <th>Адрес</th>
                                    <th>Оновной телефон</th>
                                    <th>Режим работы</th>
                                    <th>Сайт компании</th>
                                    <th>e-mail</th>
                                    <th>Ссылка</th>
                                </tr>
                                </thead>
                                </tbody>
                            </table>
                        </ul>
                    </div>


                    <div class="btn-wrapper" id="filter-actual" onclick="filterclic(this)">
        <span class="filter-main adn-fltr" tabindex="1">
            <i class="foff fa-star-o" aria-hidden="true"></i>
            <i class="fonn fa-star" aria-hidden="true"></i>
            Статус</span>
                        <span class="rl-prm" id="fsglc">Все</span>
                        <ul class="sub-filter">
                            <i class="fa fa-sort-up" aria-hidden="true"></i>
                            <li onclick="companylist('colr',0,1);">
                                Все
                                <i class="fa fa-check" id="fsgl0" aria-hidden="true"></i>
                            </li>
                            <li onclick="companylist('colr',1,1);">
                                Проверенные
                                <i class="fa fa-check" id="fsgl1" style="display: none" ria-hidden="true"></i>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-wrapper" id="filter-city" onclick="filterclic(this)">
                        <span class="filter-main  adn-fltr" tabindex="1">
                           <i class="foff fa-map-o" aria-hidden="true"></i>
                                 <i class="fonn fa-map" aria-hidden="true"></i>
                                     Город</span>
                        <span class="rl-prm" id="fsclc">Выбранный</span>
                        <ul class="sub-filter">
                            <i class="fa fa-sort-up" aria-hidden="true"></i>

                            <li class="filteritm" onclick="companylist('city',0,1);">
                                Выбранный
                                <i class="fa fa-check" id="fscl0" aria-hidden="true"></i>
                            </li>
                            <li class="filteritm" onclick="companylist('city',1,1);">
                                Все города
                                <i class="fa fa-check" id="fscl1" style="display: none" aria-hidden="true"></i>
                            </li>
                        </ul>
                    </div>

                    <div class="btn-wrapper btn-filter" id="filt-catex"  onclick="swctex()">
                        <span class="filter-main  adn-fltr" tabindex="1">Категории</span>
                        <span class="rl-prm"><i class="fa fa-braille" aria-hidden="true"></i></span>

                    </div>
                    <?php
                    $modules = JModuleHelper::getModules('addlink');
                    foreach ($modules as $mdlsitm) {
                        echo JModuleHelper::renderModule($mdlsitm);
                    }
                    ?>






                </div>

            </div>
        </div>


</div>
    <?php if ($this->params->get('show_cat_tags', 1) && !empty($this->category->tags->itemTags)) : ?>
        <?php $this->category->tagLayout = new JLayoutFile('joomla.content.tags'); ?>
        <?php echo $this->category->tagLayout->render($this->category->tags->itemTags); ?>
    <?php endif; ?>

    <?php if ($this->params->get('show_description', 1) || $this->params->def('show_description_image', 1)) : ?>
        <div class="category-desc clearfix">
            <?php if ($this->params->get('show_description_image') && $this->category->getParams()->get('image')) : ?>
                <img src="<?php echo $this->category->getParams()->get('image'); ?>"
                     alt="<?php echo htmlspecialchars($this->category->getParams()->get('image_alt'), ENT_COMPAT, 'UTF-8'); ?>"/>
            <?php endif; ?>
            <?php if ($this->params->get('show_description') && $this->category->description) : ?>
                <?php echo JHtml::_('content.prepare', $this->category->description, '', 'com_content.category'); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>


    <div class="items-leading clearfix" id="itemlist">
        <?php $leadingcount = 0; ?>

        <?php

        $firmcat = new newcatalog();

        //echo '<pre>';

        $cntr = 0;
        $firmlist = $firmcat->GetAllIn_cat($catguid, $cityid, $cntr, $pgstart);

        //$firmlistPremium= $firmcat->GetAllIn_cat("3780fbe9-75f4-47ad-8b4b-af43a5ff6253");
        // print_r($firmlist);
        //  print_r($firmcat);
        // echo($this->category->alias);
        //echo '</pre>';
        $firmlist2 = null;
        if ($aname != '') {
            $firmlist2 = $firmcat->GetAllIn_name($aname, $cityid, $cntr, $pgstart);
        }
        $this->pagination = new JPagination($cntr, $pgstart, $pagelimit);


        $db = JFactory::getDboC();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('Name', 'rowguid')));
        $query->from($db->quoteName('Names'));
        $query->where($db->quoteName('rowguid') . ' = ' . $db->quote($aname));

        $db->setQuery($query);
        $rname = $db->loadRow();

        if ($firmlist2 == null && $firmlist == null) {
            $this->pagination = new JPagination(0, 0, 0);
            echo "<span><h2>Для поиска организации или товара/услуги воспользуйтесь поиском или выбирите из каталога</h2></span>";
        }

        echo "<span><h2>" . $rname[0] . "</h2></span>";
        ?>


        <div id="itemlist">

            <?php if ($firmlist2 != null) : ?>
                <?php foreach ($firmlist2 as $i => &$item) : ?>

                    <div class="kat_item"
                         itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                        <?php
                        //
                        $objectField = new stdClass();
                        $fortable = new MdataHelper($domen);
                        $objectField->id = 103;

                        $this->item = &$item;
                        $this->item->jcfields = $objectField;
                        $this->item->fortable = $fortable;
                        echo $this->loadTemplate('item');
                        $dlisttofile[] = $this->item->fortable->getArray();
                        ?>
                    </div>
                    <?php $leadingcount++; ?>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($firmlist != null) : ?>
                <?php foreach ($firmlist as $i => &$item) : ?>

                    <div class="kat_item"
                         itemprop="blogPost" itemscope itemtype="https://schema.org/BlogPosting">
                        <?php
                        //
                        // $objectField = json_decode($firmcat->fieldstr, FALSE);
                        $objectField = new stdClass();
                        $fortable = new MdataHelper($domen);
                        $this->item = &$item;
                        $objectField->id = 103;
                        $this->item->jcfields = $objectField;
                        $this->item->fortable = $fortable;
                        echo $this->loadTemplate('item');
                        $dlisttofile[] = $this->item->fortable->getArray();

                        ?>
                    </div>
                    <?php $leadingcount++; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <?php echo JHtml::_('content.prepare', '{loadposition reklama_catalog,none}'); ?>
        <?php
        $introcount = count($this->intro_items);
        $counter = 0;
        $firmlistPremium = null;
        ?>


    </div>


    <?php if (2 > 3 && ($this->params->def('show_pagination', 1) == 1 || ($this->params->get('show_pagination') == 2)) && ($this->pagination->get('pages.total') > 1)) : ?>
        <div class="pagination">
            <?php if ($this->params->def('show_pagination_results', 1)) : ?>
                <p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>
            <?php endif; ?>
            <?php echo $this->pagination->getPagesLinks(); ?> </div>
    <?php endif; ?>
    <div class="pagination">
        <div id="moreloadcn" style="display: block" onclick="AjaxitemsForm();">Загрузить ещё</div>
    </div>


    <?php

    //echo '<pre>';

    //$firmlistPremium= $firmcat->GetAllIn_cat("3780fbe9-75f4-47ad-8b4b-af43a5ff6253");
    // print_r($this->pagination);
    //  print_r($firmcat);
    // echo($this->category->alias);
    //echo '</pre>';

    ?>
</div>


<script>
    function addFixCls()
    {
       // document.getElementById("hfixblock-srch").addClass('hfix-srch');
        ishup=1
       //$q(".h-fix").css('top', '50px');
     //   document.getElementById('resrch').innerHTML = "";
    }
    function remFixCls()
    {
      //  document.getElementById("hfixblock-srch").removeClass('hfix-srch');
        ishup=0
      //  $q(".h-fix").css('top', '50px');
     //   document.getElementById('resrchfx').innerHTML = "";
    }
    jQuery(document).ready(function () {
        dtablecom = jQuery('#datalistbl').DataTable({
            language: {
                url: '/citytmpl/js/ru_dat_tabl.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ]
        });
        var sds = <?php echo json_encode($dlisttofile); ?>;

        dtablecom.rows.add(sds).draw();
    });

    var productView = localStorage.getItem('productView');
    if (productView == 'list') {
        jQuery('.product-view-button .grid').removeClass('active');
        jQuery('.product-view-button .list').addClass('active');
        jQuery('.items-leading .kat_item').removeClass('grid-view').addClass('list-view');
    }
    jQuery('.product-view-button .grid').click(function () {
        localStorage.removeItem('productView');
        localStorage.setItem('productView', 'grid');
        jQuery('.product-view-button .list').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.items-leading .kat_item').removeClass('list-view').addClass('grid-view');
        return false;
    });

    jQuery('.product-view-button .list').click(function () {
        localStorage.removeItem('productView');
        localStorage.setItem('productView', 'list');
        jQuery('.product-view-button .grid').removeClass('active');
        jQuery(this).addClass('active');
        jQuery('.items-leading .kat_item').removeClass('grid-view').addClass('list-view');
        return false;
    });


</script>
