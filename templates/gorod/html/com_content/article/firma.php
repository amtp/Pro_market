<?php
defined('_JEXEC') or die;

use Joomla\Registry\Registry;
use Medoo\Medoo;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
$authorised = JFactory::getUser()->getAuthorisedViewLevels();
$item_id = $this->item->id;
require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/rsform.php';

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
//$images  = json_decode($this->item->images);
$user = JFactory::getUser();
//die("this is OK!)");
$app = JFactory::getApplication();
$template = $app->getTemplate(true);
//$gorod = $template->params->get('gorod', '');
//$gorod = "Владивосток";

$maps = $template->params->get('maps', '');
$center_map = $template->params->get('center_map', '');

$center_map = "131.889898, 43.116710";
$api_key = $template->params->get('api_key', '');
$ya_knopki = $template->params->get('ya_knopki', '');
$rating_user = $template->params->get('rating_user', '');
$money_no = $template->params->get('money_no', '');
$domen = JUri::base();

$urip = JFactory::getURI();
$thisurl = $urip->toString();

global $database;
$datasimg = $database->select("object_file", "filename", ["AND" => ["object" => "common\models\Company", "object_guid" => $this->item->rowguid]]);

$dataprice = $database->select("object_file", "filename", ["AND" => ["object" => "object_company_price", "object_guid" => $this->item->rowguid]]);

$price='';
if(count($dataprice)>0){
    $tmpprice= DIRECTORY_SEPARATOR . substr($dataprice[0], 0, 2) . DIRECTORY_SEPARATOR . $dataprice[0];
    $price = "/orgimg/price" . $tmpprice;
}
$count_photo = count($datasimg);
$imgnull = '/uploads/net-foto-200x200.png';
if ($count_photo > 0) {
    $img = DIRECTORY_SEPARATOR . substr($datasimg[0], 0, 2) . DIRECTORY_SEPARATOR . $datasimg[0];
    $image_intro = "orgimg/logo" . $img;
    $shareimg=$domen.$image_intro;
}else{
    $shareimg=$domen.$imgnull;
}




$dataslg = $database->select("object_file", "filename", ["AND" => ["object" => "object_company_images", "object_guid" => $this->item->rowguid]]);
$dopimgcount = count($dataslg);
$dopimgs = array();
if ($dopimgcount > 0) {
    foreach ($dataslg as $data) {
        $imgm = DIRECTORY_SEPARATOR . substr($data, 0, 2) . DIRECTORY_SEPARATOR . $data;
        $dopimgs[] = "orgimg/photo" . $imgm;
    }
}


//die($center_map);
$town = $database->select("Towns", "*", ["rowguid" => $this->item->Town_num]);
$gorod = $town[0]["Name"];
$street = $database->select("Streets", "name", ["rowguid" => $this->item->Street_num]);
$ofice = $this->item->Office;
if ($ofice != "") $ofice = ", " . $ofice;
$strit = " ул." . $street[0] . " " . $this->item->Home . $ofice;


$dataphone = $database->select("Phones", "*", ["Firm_Num" => $this->item->rowguid]);

$rguuid = $this->item->rowguid;
$datafilial = $database->query("  DECLARE	@return_value int

EXEC	@return_value = [dbo].[CP_GET_FIRM_ADRESSES_WEB]
		@CompanyGuid = :guid

SELECT	'Return Value' = @return_value", [":guid" => $this->item->rowguid])->fetchAll();


$tcnt = 0;
$phoneprio = "";
$phone = "";
$phonediscript = "";
$phonediscript_proi = "";
$rtphone = "";
$dfcnt = count($dataphone);
$phonelist = array();
if ($dfcnt > 0) {
    foreach ($dataphone as $datap) {

        $rtphone = $datap["Phone"];
        if (strlen($rtphone) <= 9) {
            $rtphone = '+7(' . $town[0]["Phone_Code"] . ')' . $rtphone;

        }
        $phonediscript = $datap["Description"];
        if ($datap["prio"] == "1") {
            $phoneprio = $rtphone;
            $phonediscript_proi = $datap["Description"];
        } else {
            $tmparry = array();
            $tmparry["id"] = $datap["Number"];
            $tmparry["phone"] = $rtphone;
            $tmparry["text"] = $datap["Description"];
            $phonelist[] = $tmparry;
        }

    }
}

if ($phoneprio != "") {
    $phone = $phoneprio;
    $phonediscript = $phonediscript_proi;
} else {
    $phone = $rtphone;
}





//$date_now = strtotime(date("d.m.Y G:i:s"));
//$date = $date_now; //выделение цветом
// $d = new DateTime($date);
// //$d->modify('+'.$f[103].' day');
// $data_color_end = strtotime($d->format("d.m.Y G:i:s"));//выделение цветом


$date_now = strtotime(date("d.m.Y G:i:s"));
$d = new DateTime();
$data_color_end = $date_now;
$addrlist = "";


$datcatmr = $database->query("SELECT [_Classifier].[rowguid] AS [catex],[_Classifier].[Folder_Name] AS [name] ,[_Classifier].[level] as[lvl] FROM [Object_Classes] AS [_Classes] 
RIGHT JOIN [Classifier] AS [_Classifier] ON 
[_Classes].[Class_Num] = [_Classifier].[rowguid] 
AND '1' = [_Classifier].[level]  WHERE [_Classes].[Object_Num] = :ruid ",
    [":ruid" => $this->item->rowguid])->fetchAll();


if (count($datcatmr) == 0) {
    $catex = "t";
    $catex_name = "m";

} else {
    $catex = $datcatmr[0]["catex"];
    $catex_name = $datcatmr[0]["name"];
}
$hpx = 40;
$baseaddr = 'г. ' . $gorod . ', ' . $strit;
?>
<?php if (!$user->guest) { ?>
    <?php if ($user->company == $this->item->rowguid) { ?>
        <div class="panel_left">
            <div class="edit_button">
                <a href="#edit-firma"><i class="fa fa-pencil-square-o"></i> Редактировать</a>
            </div>

        </div
        >
        <div class="panel_right">

            <?php if ($user->company == $this->item->rowguid) { ?>
                <?php if ($money_no == 1) { ?>
                    <div class="item_pay_block">
                        <div class="item_pay_btn">
			<span class="pay_btn">
				<span class="pay_btn_cell">
					<a href="#pay-vip"><i class="fa fa-star"></i></a>
				</span>
				<span class="pay_btn_txt">
					<span>VIP статус</span>
				</span>
			</span>
                        </div>
                        <div class="item_pay_btn">

                            <?php if ($data_color_end < $date_now) { ?>
                                <span class="pay_btn">
					<span class="pay_btn_cell">
						<a href="#pay-color"><i class="fa fa-paint-brush"></i></a>
					</span>
					<span class="pay_btn_txt">
						Выделить цветом
					</span>
				</span>
                            <?php } else { ?>
                                <span class="pay_btn">
					<span class="pay_btn_cell">
						<i class="fa fa-paint-brush"></i>
					</span>
					<span class="pay_btn_txt">
						до <?php echo $d->format("d.m.Y G:i") ?>
					</span>
				</span>
                            <?php } ?>
                        </div>
                        <div class="item_pay_btn">
			<span class="pay_btn">
				<span class="pay_btn_cell">
					<a href="#pay-top"><i class="fa fa-arrow-up"></i></a>
				</span>
				<span class="pay_btn_txt">
					Поднять наверх
				</span>
			</span>
                        </div>
                        <div class="item_pay_btn">
			<span class="pay_btn">
				<span class="pay_btn_cell">
					<a href="#pay-home"><i class="fa fa-home"></i></a>
				</span>
				<span class="pay_btn_txt">
					Вывести на главную
				</span>
			</span>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>

        </div>
    <?php } ?>
<?php } ?>
<script src="https://api-maps.yandex.ru/2.1/?apikey=85ad9d82-083c-4878-a858-401ac7bf15d1&lang=ru_RU"
        type="text/javascript"></script>
<script type="text/javascript">
    jQuery.fn.textToggle = function (d, b, e) {
        return this.each(function (f, a) {
            a = jQuery(a);
            var c = jQuery(d).eq(f),
                g = [b, c.text()],
                h = [a.text(), e];
            c.text(b).show();
            jQuery(a).click(function (b) {
                b.preventDefault();
                c.text(g.reverse()[0]);
                a.text(h.reverse()[0])
            })
        })
    };
    jQuery(function () {
        jQuery('.click-tel<?php echo "999" ?>').textToggle(".hide-tail<?php echo "999" ?>", "<?php echo $phone[0] ?><?php echo $phone[1] ?><?php echo $phone[2] ?><?php echo $phone[3] ?><?php echo $phone[4] ?><?php echo $phone[5] ?><?php echo $phone[6] ?><?php echo $phone[7] ?><?php echo $phone[8] ?><?php echo $phone[9] ?><?php echo $phone[10] ?><?php echo $phone[11] ?><?php echo $phone[12] ?><?php echo $phone[13] ?>-XX", "скрыть телефон")
    });



    <?php foreach ( $phonelist as $key => $value) : ?>
    <?php if ($value["phone"] != $phone) : ?>

    jQuery(function () {
        jQuery('.click-tel<?php echo $value["id"] ?>').textToggle(".hide-tail<?php echo $value["id"] ?>", "<?php echo $value["phone"][0] ?><?php echo $value["phone"][1] ?><?php echo $value["phone"][2] ?><?php echo $value["phone"][3] ?><?php echo $value["phone"][4] ?><?php echo $value["phone"][5] ?><?php echo $value["phone"][6] ?><?php echo $value["phone"][7] ?><?php echo $value["phone"][8] ?><?php echo $value["phone"][9] ?><?php echo $value["phone"][10] ?><?php echo $value["phone"][11] ?><?php echo $value["phone"][12] ?><?php echo $value["phone"][13] ?>-XX", "скрыть телефон")
    });

    <?php endif; ?>
    <?php endforeach; ?>


</script>

<div class="necontent">
<div class="firma-page<?php echo $this->pageclass_sfx; ?>" itemscope itemtype="https://schema.org/Organization">

    <h1 itemprop="name">
        <?php echo $this->escape($this->item->Official_Name); ?>
    </h1>


    <div class="mini_icons">

        <div class="ic_cat">категории:
            <?php foreach ($datcatmr as $ival) : ?>
                <a href="<?php echo JRoute::_(ContentHelperRoute::getCategoryRoute($ival["catex"])); ?>"
                   title="<?php echo $ival["name"] ?>">
                    <?php echo $ival["name"] ?>
                </a>
            <?php endforeach; ?>

            <ul class="tags inline">
                <?php foreach ($this->item->tags->itemTags as $i => $tag) : ?>
                    <?php if (in_array($tag->access, $authorised)) : ?>
                        <?php $tagParams = new Registry($tag->params); ?>
                        <?php $link_class = $tagParams->get('tag_link_class', 'label label-info'); ?>
                        <li class="tag-<?php echo $tag->tag_id; ?> tag-list<?php echo $i; ?>">
                            <a href="<?php echo JRoute::_(TagsHelperRoute::getTagRoute($tag->tag_id . '-' . $tag->alias)); ?>"
                               class="<?php echo $link_class; ?>">
                                <span class="fa fa-hashtag"></span> <?php echo $this->escape($tag->title); ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div
    >
    <div class="ic_big_phone">
        <div class="mini_icons">

            <div class="ic">
                <i class="fa fa-eye"></i>
                <?php echo $this->item->Counter ?>
            </div>
            <div class="ic">
                <i class="fa fa-comments"></i>
                <?php

                $comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
                if (file_exists($comments)) {
                    require_once($comments);
                    $options = array();
                    $options['object_id'] = $this->item->id;
                    $options['object_group'] = 'company';
                    $options['published'] = 1;
                    $options['con_type'] = 1;
                    $count = JCommentsModel::getCommentsCount($options);
                    echo $count ? '' . $count . '' : '0';
                } ?>
            </div>
            <div class="ic">
                <?php if ($rating_user == '0') { ?>
                    <?php JPluginHelper::importPlugin('content', 'vrvote');
                    $dispatcher = JDispatcher::getInstance();
                    $results = $dispatcher->trigger('vrvote', $this->item->id); ?>
                <?php } else { ?>
                    <?php if ($user->guest) { ?>
                        <span class="no_rating">
						<a class="no_link" href="#login"></a>
						<?php JPluginHelper::importPlugin('content', 'vrvote');
                        $dispatcher = JDispatcher::getInstance();
                        $results = $dispatcher->trigger('vrvote', $this->item->id); ?>
					</span>
                    <?php } else { ?>
                        <?php JPluginHelper::importPlugin('content', 'vrvote');
                        $dispatcher = JDispatcher::getInstance();
                        $results = $dispatcher->trigger('vrvote', $this->item->id); ?>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php if ($ya_knopki == '1') { ?>
                <div class="ic social_button">
                    <script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
                    <script src="//yastatic.net/share2/share.js"></script>

                    <div class="ya-share2" data-services="whatsapp,vkontakte,facebook,odnoklassniki,moimir,gplus"
                         data-description="<?php if ($this->item->id) { ?><?php echo $this->item->Official_Name ?><?php } ?>"
                         data-counter="" data-image="<?php echo $shareimg; ?>">


                    </div>
                    <div class="js-share copy fa fa-link"   onclick="  copyTextToClipboard('<?php echo $thisurl ?>');" title="Скопировать">
                         </div>
                </div>
            <?php } ?>

        </div>
    </div
    >

</div>


<div id="YMapsID">
		<span class="loading">
			<i class="fa fa-spinner fa-spin"></i>
			<span>Загружаем карту</span>
		</span>
    <div class="map_info">


        <div class="tabf">
            <input id="tabn1" type="radio" name="tabf" checked>
            <label for="tabn1" title="Инфо."><i class="fa fa-info"></i> Инфо.</label>

            <input id="tabn2" type="radio" name="tabf">
            <label for="tabn2" title="Адреса" class="firmadreseslst"><i class="fa fa-map-marker"></i> Адреса
                (<?php echo count($datafilial); ?>)
            </label>

            <section id="content-tabn1" class="content-tabn1">
                <div class="firma_logo">

                    <?php if ($count_photo > 0) { ?>
                        <img itemprop="logo" class="lazy b-image__image b-image_type_fit b-image_fit-cover"
                             src="<?php echo $image_intro ?>">
                    <?php } else { ?>
                        <img itemprop="logo" class="lazy b-image__image b-image_type_fit b-image_fit-cover"
                             src="<?php echo $domen ?><?php echo $imgnull ?>">
                    <?php } ?>
                </div>
                <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <div class="mini_icons">
                        <div class="ic_cat">
                            <i class="fa fa-map-marker"></i>
                            <span itemprop="streetAddress"><?php echo $baseaddr ?></span>
                        </div>

                        <div class="ic_cat">
                            <i class="fa fa-clock-o"></i>
                            <?php echo $this->item->WorkHours ?>
                        </div>



                        <?php if ($price != "") { ?>
                            <div class="ic_big">
                                <i class="fa fa-download"></i>
                               <a href="<?php echo $price ?>"><span class="price-download">Скачать прайс компании</span> </a>
                            </div>
                        <?php } else { ?>
                            <div class="ic_big">
                                <i class="fa fa-download"></i>
                                <span class="price-download">Прайс компании не найден</span>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="list-view phone_block">
                        <!--noindex-->
                        <?php if ($this->item->Email != "") { ?>
                            <div class="ic_big">
                                <i class="fa fa-envelope-o"></i>
                                <span><?php echo $this->item->Email ?></span>
                            </div>
                        <?php } else { ?>
                            <div class="ic_big">
                                <i class="fa fa-envelope-o"></i>
                                <span>не указан</span>
                            </div>
                        <?php } ?>

                        <?php if ($this->item->URL != "") { ?>
                            <div class="ic_big">
                                <i class="fa fa-internet-explorer"></i>
                                <span>
				<a href="http://<?php echo $this->item->URL ?>" target="_blank">
					<?php echo $this->item->URL ?>
				</a>
				</span>
                            </div>
                        <?php } else { ?>
                            <div class="ic_big">
                                <i class="fa fa-internet-explorer"></i>
                                <span>
                                    не указан
                                </span>
                            </div>
                        <?php } ?>

                        <p></p>
                        <h5>Соцсети:</h5>
                        <?php if ($this->item->link_vk != "") { ?>
                            <div class="ic_big">
                                <i class="fa fa-vk"></i>
                                <span>
				<a href="<?php echo $this->item->link_vk ?>" target="_blank">
					<?php echo $this->item->link_vk ?>
				</a>
				</span>
                            </div>
                        <?php } else { ?>
                            <div class="ic_big">
                                <i class="fa fa-vk"></i>
                                <span> не указан </span>
                            </div>
                        <?php } ?>

                        <?php if ($this->item->link_inst != "") { ?>
                            <div class="ic_big">
                                <i class="fa fa-instagram"></i>
                                <span>
				<a href="<?php echo $this->item->link_inst ?>" target="_blank">
					<?php echo $this->item->link_inst ?>
				</a>
				</span>
                            </div>
                        <?php } else { ?>
                            <div class="ic_big">
                                <i class="fa fa-instagram"></i>
                                <span> не указан </span>
                            </div>
                        <?php } ?>
                        <?php if ($this->item->link_fb != "") { ?>
                            <div class="ic_big">
                                <i class="fa fa-facebook-f"></i>
                                <span>
				<a href="<?php echo $this->item->link_fb ?>" target="_blank">
					<?php echo $this->item->link_fb ?>
				</a>
				</span>
                            </div>
                        <?php } else { ?>
                            <div class="ic_big">
                                <i class="fa fa-facebook-f"></i>
                                <span> не указан </span>
                            </div>
                        <?php } ?>


                        <!--/noindex-->
                    </div>
                </div>
            </section>

            <section id="content-tabn2" class="content-tabn2">

                <table class="table table-condensed table-striped price table-hover">
                    <thead>
                    </thead>
                    <tbody>
                    <?php $i = 0; ?>
                    <tr>
                        <td class="fadd-item" onclick="setmapfcentr('ndx0')">
                            <div class="faddr-block">
                                <h3><?php echo $this->item->Official_Name; ?></h3>
                                <i class="fa fa-map-marker"></i><span class="ladres"><?php echo $baseaddr; ?></span>

                            </div>
                        </td>
                    </tr>
                    <?php foreach ($datafilial as $itemf) : ?>
                        <?php $i++; ?>
                        <?php $faddr = "г. " . $itemf['ltown'] . " ул." . $itemf['lstreet'] . " " . $itemf['Home'];
                        $faddrfull = $faddr . " " . $itemf['Office']; ?>

                        <?php $addrlist .= " addmappoints('$faddr','" . $itemf['name'] . "', '" . $itemf['phone'] . "', '" . $itemf['WorkHours'] . "','ndx".$i."',false);" ?>

                        <tr>
                            <td class="fadd-item" onclick="setmapfcentr('ndx<?php echo $i; ?>')">
                                <div class="faddr-block">
                                    <h3><?php echo $itemf['name']; ?></h3>
                                    <i class="fa fa-map-marker"></i><span
                                            class="ladres"><?php echo $faddrfull; ?></span>

                                </div>
                            </td>
                        </tr>


                    <?php endforeach; ?>

                    </tbody>
                </table>
            </section>


        </div>


    </div>
</div>
<script type="text/javascript">
    var myMap;
    var coordlistf = [];
    var markbaloons = [];

    function addmappoints(addrf, fname, fphone, fworkhoure,ndx, is_start = false) {
        var geocode = ymaps.geocode(addrf, {results: 1});
        geocode.then(
            function (res) {
                // Выбираем первый результат геокодирования.
                var firstGeoObject = res.geoObjects.get(0);
                coords = firstGeoObject.geometry.getCoordinates();
                coordlistf[ndx] = coords;

               // coordlistf.push(coords);
                if (is_start) {
                    setmapfcentr(ndx,true);

                }


                myMap.behaviors.disable('scrollZoom');


                myPlacemark = new ymaps.Placemark(coords, {
                    balloonContentHeader: fname,
                    balloonContentBody: "<div>" + addrf + "</div><div> <b><i class='fa fa-mobile'></i> " + fphone + "</b></div>",
                    balloonContentFooter: "<div>Режим работы/подробнее: " + fworkhoure + "  </div>",
                    hintContent: "Нажмите, для того, что бы посмотреть подробности"
                });
                markbaloons[ndx] = myPlacemark;
                myMap.geoObjects.add(myPlacemark);
            },
            function (err) {
            }
        );
    }

    function setmapfcentr(idx,isstart=false) {
        var coords = coordlistf[idx];
        if (screen.width <= '480') {
            myMap.setCenter([coords[0] - 0.001, coords[1] + 0.000]);
        } else {
            myMap.setCenter([coords[0], coords[1] + 0.008]);
        }
        if(isstart==false)
            markbaloons[idx].balloon.open();
    }


    ymaps.ready(init);

    function init() {
        myMap = new ymaps.Map("YMapsID", {
            center: [<?php echo $center_map ?>],
            zoom: 15,
            controls: ['zoomControl']
        });

        addmappoints('<?php echo $baseaddr ?>', '<?php echo $this->item->Official_Name ?>', '<?php echo $phone ?>', '<?php echo $this->item->WorkHours ?>','ndx0', true);
        <?php echo $addrlist ?>
        console.log(coordlistf);
        // setmapfcentr(  jcmp  );

    }

</script>
<div class="gallery b-tire-scroll__scrollable" style="margin-top:   <?php if ($hpx != 0) echo $hpx; ?>px;">
    <div class="items b-tire-scroll__items" id="chfotos">
        <?php if ($dopimgcount > 0) { ?>
            <?php $zi = 0; ?>
            <?php foreach ($dopimgs as $value) : ?>
                <?php $zi++; ?>
                <div data-pop class="b-tire-scroll_glr" title="(<?php echo $zi; ?>/<?php echo $dopimgcount; ?>)">
                    <div class="b-image-outer">
                        <img class="b-image-inner b-image_type_fit b-image_fit-cover" src="<?php echo $value; ?>">
                    </div>
                </div>
            <?php endforeach; ?>
        <?php } ?>
    </div>
</div>


<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Описание"><i class="fa fa-files-o"></i> Подробнее</label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Услуги компании"><i class="fa fa-file-text-o"></i> Услуги компании</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Отзывы"><i class="fa fa-comments-o"></i> Отзывы
        (<?php
        $comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
        if (file_exists($comments)) {
            require_once($comments);
            $options = array();
            $options['object_id'] = $this->item->id;
            $options['object_group'] = 'company';
            $options['published'] = 1;
            $options['con_type'] = 1;
            $count = JCommentsModel::getCommentsCount($options);
            echo $count ? '' . $count . '' : '0';
        } ?>)
    </label>


    <section id="content-tab1">
        <div class="desc">


            <h3>Номера телефонов</h3>
            <span style="font-size: 16px;">
                 <ul>
        <?php foreach ($phonelist as $key => $value) : ?>

            <li>
                <i class="fa fa-mobile"></i>
                <span itemprop="telephone"
                      class="hide-tail<?php echo $value["id"] ?>"><?php echo $value["phone"] ?></span>
                <small>
                     <?php echo $value["text"] ?>
                    <i class="fa fa-eye"></i> <a href="#"
                                                 class="click-tel<?php echo $value["id"] ?>"> показать телефон</a>
                </small>
                </li>

        <?php endforeach; ?>
                     </ul>
        </span>


            <?php if ($this->item->HowToGetScheme != "") { ?>
                <div class="ic_big">
                    <h5>Как проехать</h5>
                    <i class="fa fa-car"></i>
                    <span><?php echo $this->item->HowToGetScheme ?></span>
                </div>
                </hr>
            <?php } ?>


        </div>
    </section>

    <section id="content-tab2">
        <div class="desc">
            <?php
            $prices = $database->select("Price3", "Reference1", ["firm_num" => $this->item->rowguid]);
            $nameses = $database->select("Names", "Name", ["rowguid" => $prices]);
            ?>
            <table class="table table-condensed table-striped table-hline price">
                <thead>
                <tr>
                    <th class="text-center">Товар/услуга</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($nameses as $value) : ?>

                    <tr>
                        <td><?php echo $value ?></td>
                    </tr>
                <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </section>

    <section id="content-tab3">
        <?php
        echo $this->item->id;
        $comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
        if (file_exists($comments)) {
            require_once($comments);
            echo JComments::showComments($this->item->id, 'company', $this->item->Official_Name, 1);
        }
        //	echo  $this->item->rowguid;
        ?>
    </section>


</div>
</div>
<?php if (!$user->guest) { ?>
    <?php if ($user->company == $this->item->rowguid) { ?>

        <a href="#x" class="overlay" id="edit-firma"></a>
        <div class="popup">
            <?php echo RSFormProHelper::displayForm('10'); // ФОРМА РЕДАКТИРОВАНИЯ ОРГАНИЗАЦИИ ?>
            <a class="close1" title="Закрыть" href="#close"></a>
        </div>

        <a href="#x" class="overlay" id="delete-firma"></a>

        <a href="#x" class="overlay" id="pay-vip"></a>
        <div class="popup">
            <?php echo RSFormProHelper::displayForm('33'); // ПОМЕСТИТЬ ОРГАНИЗАЦИЮ В VIP ?>
            <a class="close1" title="Закрыть" href="#close"></a>
        </div>

        <a href="#x" class="overlay" id="pay-color"></a>
        <div class="popup">
            <?php echo RSFormProHelper::displayForm('30'); // ФОРМА ВЫДЕЛЕНИЯ ОРГАНИЗАЦИИ ЦВЕТОМ ?>
            <a class="close1" title="Закрыть" href="#close"></a>
        </div>

        <a href="#x" class="overlay" id="pay-top"></a>
        <div class="popup">
            <?php echo RSFormProHelper::displayForm('32'); // ФОРМА ПОДНЯТИЯ ОРГАНИЗАЦИИ ВВЕРХ ?>
            <a class="close1" title="Закрыть" href="#close"></a>
        </div>

        <a href="#x" class="overlay" id="pay-home"></a>
        <div class="popup">
            <?php echo RSFormProHelper::displayForm('34'); // ФОРМА ДОБАВЛЕНИЯ ОРГАНИЗАЦИИ НА ГЛАВНУЮ ?>
            <a class="close1" title="Закрыть" href="#close"></a>
        </div>


    <?php } ?>
<?php } ?>
</div>


