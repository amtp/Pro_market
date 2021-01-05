<?php defined('_JEXEC') or die;

use Company\Company_List;

//$params = $this->item->params;
JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

use Joomla\Registry\Registry;

JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
global $database;
$authorised = JFactory::getUser()->getAuthorisedViewLevels();
//echo $displayData."dddddddd";
if (isset($displayData)) $this->item = $displayData;
$item_id = $this->item->rowguid;
//echo $item_id;

$datcatmr = $database->select("Object_Classes(_Classes)", [
    "[>]Classifier(_Classifier)" => ["_Classes.Class_Num" => "rowguid"],
], [
    "_Classifier.rowguid(catex)",
    "_Classifier.Folder_Name(name)",
], ["AND" => ["_Classes.Object_Num" => $item_id, "_Classifier.level" => '1'],
]);
if ($datcatmr != array()) {
    $datcatmr = $database->select("Object_Classes(_Classes)", [
        "[>]Classifier(_Classifier)" => ["_Classes.Class_Num" => "rowguid"],
    ], [
        "_Classifier.rowguid(catex)",
        "_Classifier.Folder_Name(name)",
    ], ["AND" => ["_Classes.Object_Num" => $item_id, "_Classifier.level" => '0'],
    ]);
}

$catex = "t";
$catex_name = "m";

//$catex=$datcatmr[0]["catex"];
//$catex_name=$datcatmr[0]["name"];
$this->item->category_title = $catex_name;
//echo "</br>";
//echo $catex;
//echo $this->category->alias;
//echo '<pre>';
//print_r($datcatmr);
//echo '</pre>';

$link = JRoute::_(ContentHelperRoute::getArticleRoute2("", $catex, "*"));
$link = $link . "/" . $catex . "/91784593210" . $this->item->nid . "-" . $catex_name;
//$link = "/index.php/katalog/";
//echo "link-".$link;

$datasimg = $database->select("object_file", "filename", ["AND" => ["object" => "common\models\Company", "object_guid" => $item_id]]);
$dimgcount = count($datasimg);
if ($dimgcount > 0) {
    $img = DIRECTORY_SEPARATOR . substr($datasimg[0], 0, 2) . DIRECTORY_SEPARATOR . $datasimg[0];
}

$imgnull = '/citytmpl/images/none_img.png';


$data_color_end = $this->item->prioritet;
if ($data_color_end != "1") $data_color_end = $this->item->townprioritet;


if ($data_color_end == 1) {
    $isblock = 0;
} elseif ($this->item->Color_Index == "1") {
    $isblock = 0;
} else {
    $isblock = 1;
}
if ($isblock == 1) {
    $dimgcount = 0;
    $imgnull = '/citytmpl/images/none_img_g.png';
}

$town = $database->select("Towns", "*", ["rowguid" => $this->item->Town_num]);
$street = $database->select("Streets", "name", ["rowguid" => $this->item->Street_num]);
$ofice = $this->item->Office;
if ($ofice != "") $ofice = ", " . $ofice;
$strit = "г." . $town[0]["Name"] . ", ул." . $street[0] . " " . $this->item->Home . $ofice;


//foreach($this->item->jcfields as $field) {
//	$f[$field->id] = $field->value;
//}


require_once JPATH_ADMINISTRATOR . '/components/com_rsform/helpers/rsform.php';
$user = JFactory::getUser();
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);
$session = JFactory::getSession();
$rating_user = $templ->params->get('rating_user', '');
$money_no = $templ->params->get('money_no', '');




$ismobl =JFactory::$ismobile;

$dataphone = $database->select("Phones", "*", ["Firm_Num" => $item_id]);
$tcnt = 0;
$phoneprio = "";
$phone = "";
$rtphone = "";
$dfcnt = count($dataphone);
if ($dfcnt > 0) {
    foreach ($dataphone as $datap) {

        $rtphone = $datap["Phone"];
        if (strlen($rtphone) <= 9) {
            $rtphone = '+7(' . $town[0]["Phone_Code"] . ')' . $rtphone;

        }
        if ($datap["prio"] == "1") $phoneprio = $rtphone;
    }
}
if ($phoneprio != "") {
    $phone = $phoneprio;
} else {
    $phone = $rtphone;
}
//$phone= $this->item->Phones;

//$date_now =  strtotime(date("d.m.Y G:i:s"));
//  $date = $f[104]; //выделение цветом
// $d = new DateTime($date);
//  $d->modify('+'.$f[103].' day');
//$data_color_end = strtotime($d->format("d.m.Y G:i:s"));//выделение цветом

?>
<script>
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
        jQuery('.click-tel<?php echo $this->item->nid ?>').textToggle(".hide-tail<?php echo $this->item->nid ?>", "<?php echo $phone[0] ?><?php echo $phone[1] ?><?php echo $phone[2] ?><?php echo $phone[3] ?><?php echo $phone[4] ?><?php echo $phone[5] ?><?php echo $phone[6] ?><?php echo $phone[7] ?><?php echo $phone[8] ?><?php echo $phone[9] ?><?php echo $phone[10] ?><?php echo $phone[11] ?><?php echo $phone[12] ?><?php echo $phone[13] ?>-XX", "скрыть телефон")
    });
</script>
<?php
$count_photo = 1;
$isblock = 0;
?>

<div class="<?php
if ($data_color_end == 1) {
    ?>pay_color<?php
} elseif ($this->item->Color_Index == "1") {
    ?>grn_color<?php
} else {
    ?>nog_color<?php
    $isblock = 1;
}
?>">

    <?php if ($money_no == 1) { ?>

    <?php if ($isblock == "1") { ?>
    <div class="pay_block redtxt">
        <span style="color: #eb4120;">Данные компании возможно устарели! </span>
        <?php } else { ?>
        <div class="pay_block">
            <?php } ?>



            <?php if ($user->guest) { ?>
                <a class="pay_button" href="#login"><i class="fa fa-bar-chart"></i> Увеличить продажи</a>
            <?php } else { ?>
                <?php

                if ($user->company == $item_id) { ?>
                    <?php if ($data_color_end != 1) { ?>
                        <span class="pay_btn">
					<span class="pay_btn_cell">
						<a href="<?php echo $link ?>#pay-color"><i class="fa fa-paint-brush"></i></a>
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
						до <?php echo "2020" ?>
					</span>
				</span>
                    <?php } ?>
                    <span class="pay_btn">
					<span class="pay_btn_cell">
						<a href="<?php echo $link ?>#pay-home"><i class="fa fa-home"></i></a>
					</span>
					<span class="pay_btn_txt">
						Вывести на главную
					</span>
				</span>
                <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>

 <?php if ($ismobl != 0){ ?>
        <div class="kat_item_head"><h3>
                <a href="<?php echo $link ?>#link" title="<?php echo $this->item->Official_Name ?>">
                    <span itemprop="name"><?php echo $this->item->Official_Name ?></span>
                </a>
            </h3></div>
 <?php }?>

        <div class="paddingonl">


            <?php if ($dimgcount > 0) { ?>


                <div class="old_mod_news_img">
                    <a href="<?php echo $link ?>#link" title="<?php echo $this->item->Official_Name ?>">
                        <img class="lazy" src="/orgimg/logo<?php echo $img ?>"
                             title="<?php echo $this->item->Official_Name ?>"/></a>
                </div>

            <?php } else { ?>
                <div class="old_mod_news_img">
                    <a href="<?php echo $link ?>#link" title="<?php echo $this->item->Official_Name ?>">
                        <img class="lazy" src="<?php echo $imgnull ?>"
                             title="<?php echo $this->item->Official_Name ?>"/></a>
                </div>


            <?php } ?>


            <div class="kat_item_info">

                <?php if ($ismobl == 0){ ?>
                    <div class="kat_item_head"><h3>
                            <a href="<?php echo $link ?>#link" title="<?php echo $this->item->Official_Name ?>">
                                <span itemprop="name"><?php echo $this->item->Official_Name ?></span>
                            </a>
                        </h3></div>
                <?php }?>

                <div class="additm" itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
                    <div class="mini_icon">

                        <div class="ic thid">
                            <i class="fa fa-eye"></i>
                            <?php echo $this->item->counter ?>
                        </div>
                        <div class="ic thid">
                            <i class="fa fa-comments"></i>
                            <?php
                            $comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
                            if (file_exists($comments)) {
                                require_once($comments);
                                $options = array();
                                $options['object_id'] = $this->item->nid;
                                $options['object_group'] = 'com_content';
                                $options['published'] = 1;
                                $count = JCommentsModel::getCommentsCount($options);
                                echo $count ? '' . $count . '' : '0';
                            } ?>
                        </div>

                        <div class="ic thid">
                            <?php $tlparm = array($this->item->nid, 1); ?>
                            <?php if ($rating_user == '0') { ?>
                                <?php JPluginHelper::importPlugin('content', 'vrvote');
                                $dispatcher = JDispatcher::getInstance();
                                $results = $dispatcher->trigger('vrvote', $tlparm); ?>
                            <?php } else { ?>
                                <?php if ($user->guest) { ?>
                                    <span class="no_rating">
						<a class="no_link" href="#login"></a>
						<?php JPluginHelper::importPlugin('content', 'vrvote');
                        $dispatcher = JDispatcher::getInstance();
                        $results = $dispatcher->trigger('vrvote', $tlparm); ?>
					</span>
                                <?php } else { ?>
                                    <?php JPluginHelper::importPlugin('content', 'vrvote');
                                    $dispatcher = JDispatcher::getInstance();
                                    $dispatcher->trigger('vrvote', $tlparm);
                                    ?>
                                <?php } ?>
                            <?php } ?>
                        </div>




                        <div class="ic_cat">
                            <i class="fa fa-map-marker"></i>
                            <span itemprop="streetAddress"><?php echo $strit ?></span>
                        </div>

                        <?php
                        $workhour = "";
                        $workhourp = "";
                        $timetagr = str_ireplace("%,%", ";", $this->item->WorkHours);
                        $timejob = explode(";", $timetagr);
                        switch (count($timejob)) {
                            case 2:
                                if (strripos($timejob[0], 'круг') != false) $workhourp = $timejob[0];
                                if (strripos($timejob[1], 'круг') != false) $workhourp = $timejob[1];
                            case 3:
                                if (strripos($timejob[0], 'круг') != false) $workhourp = $timejob[0];
                                if (strripos($timejob[1], 'круг') != false) $workhourp = $timejob[1];
                                // if (strripos($timejob[2],'круг')!=false  )$workhourp=$timejob[2];
                                break;
                            case 4:
                                if (strripos($timejob[0], 'круг') != false) $workhourp = $timejob[0];
                                if (strripos($timejob[1], 'круг') != false) $workhourp = $timejob[1];
                                if (strripos($timejob[2], 'круг') != false) $workhourp = $timejob[2];
                                if (strripos($timejob[3], 'круг') != false) $workhourp = $timejob[3];
                                break;
                            case 5:
                                if (strripos($timejob[0], 'круг') != false) $workhourp = $timejob[0];
                                if (strripos($timejob[1], 'круг') != false) $workhourp = $timejob[1];
                                if (strripos($timejob[2], 'круг') != false) $workhourp = $timejob[2];
                                if (strripos($timejob[3], 'круг') != false) $workhourp = $timejob[3];
                                if (strripos($timejob[4], 'круг') != false) $workhourp = $timejob[4];
                                break;


                        }
                        $workhour = $this->item->WorkHours;
                        ?>

                        <div class="ic_cat mobhid">
                            <i class="fa fa-clock-o"></i>
                            <?php echo $workhour ?>
                        </div>

                        <?php if ($workhourp != "") { ?>
                            <div class="ic_cat mobhid">
                                <span>Режим работы:</span>
                                <span class="onlihour"><?php echo $workhourp ?></span>
                            </div>
                        <?php } ?>


                    </div
                    >
                    <div class="phone_block">

                        <div class="ic_big_phone">
                            <i class="fa fa-mobile"></i>
                            <span itemprop="telephone"
                                  class="hide-tail<?php echo $this->item->nid ?>"><?php echo $phone ?></span>
                            <small>
                                <i class="fa fa-eye"></i> <a href="#" class="click-tel<?php echo $this->item->nid ?>">
                                    показать
                                    телефон</a>
                            </small>
                        </div>

                        <!--noindex-->
                        <?php if ($this->item->Email != "") { ?>
                            <div class="ic_big mobhid">
                                <i class="fa fa-envelope-o"></i>
                                <span><?php echo $this->item->Email ?></span>
                            </div>
                        <?php } ?>

                        <?php if ($this->item->URL != "") { ?>
                            <div class="ic_big mobhid">
                                <i class="fa fa-internet-explorer"></i>
                                <a href="http://<?php echo $this->item->URL ?>" target="_blank" rel="nofollow ">
                                    <span><?php echo $this->item->URL ?></span>
                                </a>
                            </div>
                        <?php } ?>
                        <!--/noindex-->
                    </div>

                </div>
            </div>
        </div>

</div>
<?php
$twrkh = $workhour;
if ($workhourp != "") $twrkh .= "Режим работы: " . $workhourp;
$this->item->fortable->setData($this->item->Official_Name, $strit, $phone, $twrkh, $this->item->URL, $this->item->Email, $link);
// $this->item->fortable->setData($this->item->Official_Name,$link,$link,$link,$link,$link,$link);
//   $this->item->fortable->Official_Name=$this->item->Official_Name;
?>

