<?php
defined('_JEXEC') or die;
require dirname(__FILE__) . '/php/pro-portal.php';
require dirname(__FILE__) . '/php/init.php';

$doc = JFactory::getDocument();
$user = JFactory::getUser();
$user_id = $user->id;

$db = JFactory::getDbo();

$app = JFactory::getApplication();
$jinput = $app->input;
$jcookie  = $jinput->cookie;

$template = $app->getTemplate(true);
$gorod = $template->params->get('gorod', '');
$like = $template->params->get('vk_like');
$vk_group = $template->params->get('vk_group');
$stroka = $template->params->get('stroka', '');

$icon_logo = $template->params->get('icon_logo');
$logo1 = $template->params->get('logo1');
$logo2 = $template->params->get('logo2');
$logo_slogan = $template->params->get('logo_slogan');

$logo_img = $template->params->get('logo_img');
$mini_logo_img = $template->params->get('mini_logo_img');

$vozrast = $template->params->get('vozrast');

$valuta = $template->params->get('strana', '');
$valuta1 = $template->params->get('valuta', '');
$holiday = $template->params->get('holiday', '');
$holiday_text = $template->params->get('holiday_text', '');
$holiday_link = $template->params->get('holiday_link', '');
$yandex = $template->params->get('yandex', '');
$domen = JUri::base();


$detect = new Mobile_Detect;
if($user->guest){

}else{


}
$topalmx="";
 $menu = JFactory::getApplication()->getMenu();




//$cityname='Все города';
//$cityid='00000000-0000-0000-0000-000000000000';

//$cityname="Все города";

$session = JFactory::getSession();
//echo $session->getId();
if($user->guest){
    $cityname=$session->get('cityname', 'Все города');
    $cityid=$session->get('cityid', '00000000-0000-0000-0000-000000000000');
    $cityid=$session->get('citynid', '');
}else{
    $cityname=$user->cityname;// $session->get('cityname', 'Все города');
    $cityid=$user->cityid;// $session->get('cityid', '00000000-0000-0000-0000-000000000000');
    $cityid=$user->citynid;// $session->get('citynid', '');
}
$ismobil =JFactory::$ismobile;

//echo $cityname."+".$cityid."U";
$params     = isset($this->state->params) ? $this->state->params : new JObject;
//303
//$uri = JFactory::getURI();
//$link = $uri->toString();
//echo $link;
//print_r(JFactory::getURI());
//echo $menu->getActive()->id;
//if( $menu->getActive()->id==2357);
if(isset($menu->getActive()->id)){
    if( $menu->getActive()->id==2357) {
        $doc->addStyleSheet('citytmpl/css/taricont.css',array('version'=>'auto'));
    }
    if ($menu->getActive()->id == $menu->getDefault()->id){
        $doc->addScriptDeclaration("
    jQuery(window).on('load',  function() {
           // initside_menu('app-mini',0);
           initslide_menu('appmcontent');
        });");
    }
}




$doc->addStyleSheet('citytmpl/css/responsive.css',array('version'=>'auto'));

if ($ismobil == 1)
    $doc->addStyleSheet('citytmpl/css/style.bundle.css',array('version'=>'auto'));
?>
<?php echo $tpl->renderHTML(); ?>
<head>
    <jdoc:include type="head" />
    <link rel="stylesheet" type="text/css" href="citytmpl/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="citytmpl/css/font-alcityfont.css">
    <link rel="stylesheet" type="text/css" href="citytmpl/css/carousel.css">
    <link rel="shortcut icon" href="citytmpl/favicon.ico" type="image/x-icon">
    <script type="text/javascript" src="citytmpl/js/carousel.js"></script>
    <script type="text/javascript" src="citytmpl/js/maskedinput.js"></script>

    <script type="text/javascript" src="citytmpl/js/njax.js"></script>
    <script type="text/javascript" src="citytmpl/js/slideout.min.js"></script>

</head>



<body class="<?php echo $tpl->getBodyClasses(); ?>">
<nav id="menu" class="tmmenu">

    <div class="m-menuhead-l">
    <span class="mobile-m-cls"> <span class="mobile-m-cls-t"><i class="fa fa-arrow-left"></i></span></span>



    <div class="user_panel">
        <?php if($user->guest) { ?>
            <a href="#login" class="linkuser_bt" title="Войти или зарегистрироваться">
					<span class="user_avatar">
						<span><i class="fa fa-user"></i></span>
					</span
                    ><span class="userltx">Личный кабинет<p>вход на сайт</p></span>
            </a>

        <?php } else { ?>
            <jdoc:include type="modules" name="login"/>
        <?php } ?>


    </div
    >
    </div>

    <div class="m-lmain first">
        <jdoc:include type="modules" name="mainmenu"/></div>
    <div class="m-lmain-ad">
        <?php if($user->guest) { ?>
            <div class="add_col">
                <a href="/platnoe-razmeshenie"><i class="fa fa-briefcase"></i><span>Добавить организацию</span></a>
            </div
            ><div class="add_col">
                <a href="#login"><i class="fa fa-handshake-o"></i><span>Разместить объявление</span></a>
            </div
            ><div class="add_col">
                <a href="#login"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
            </div
            ><div class="add_col">
                <a href="#login"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
            </div
            >
        <?php } else { ?>
            <div class="add_col">
                <a href="/platnoe-razmeshenie"><i class="fa fa-briefcase"></i><span>Добавить организацию</span></a>
            </div
            ><div class="add_col">
                <a href="/add-doska"><i class="fa fa-handshake-o"></i><span>Разместить объявление</span></a>
            </div
            ><div class="add_col">
                <a href="/add-vakansiya"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
            </div
            ><div class="add_col">
                <a href="/add-resume"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
            </div
            >
        <?php } ?>
    </div>
    <div class="m-lmain">
        <jdoc:include type="modules" name="footer_block" style="top"/>
    </div>
    <?php if(!$user->guest) { ?>
    <div class="m-lmain-lout">
        <div class="add_col">
            <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure', 0)); ?>" method="post" id="login-form" class="form-vertical">

                <div class="logout-button">
                    <input type="submit" name="Submit" class="btn btn-primary" value="<?php echo JText::_('JLOGOUT'); ?>" />
                    <input type="hidden" name="option" value="com_users" />
                    <input type="hidden" name="task" value="user.logout" />
                    <input type="hidden" name="return" value="<?php echo $domen; ?>ob-yavleniya/" />
                    <?php echo JHtml::_('form.token'); ?>
                </div>
            </form>
        </div>
    </div>
    <?php } ?>

</nav>

<main id="panel">
<div class="top_panel">

    <div class="new_all_portal hall-top">




        <div class="nonmobile-inl">
            <div class="mob_btn mobile-m-btn">

                <div class="toggle-button"> <i class="fa fa-navicon"></i>
                    <span>Меню</span></div>
            </div>

        </div>
    <div class="m-logontp">
        <div class="mobile_logo-m">
            <a href="/" title="">
                <?php if($mini_logo_img) { ?>
                    <img src="<?php echo $mini_logo_img ?>" class="m-logo" alt="" />
                <?php } else { ?>
                    <i class="<?php echo $icon_logo ?>"></i>

                <?php } ?>
            </a>
        </div
        >
     </div>
        <div class="mobile-inl user_panel">
            <?php if($user->guest) { ?>
                <a href="#login" class="linkuser_bt" title="Войти или зарегистрироваться">
					<span class="user_avatar">
						<span><i class="fa fa-user"></i></span>
					</span
                    ><span class="userltx">Личный кабинет<p>вход на сайт</p></span>
                </a>

            <?php } else { ?>
                <jdoc:include type="modules" name="login"/>
            <?php } ?>
        </div
        ><div class="mainmenu">


            <div class="mobile_menu">
                <jdoc:include type="modules" name="mainmenu"/>
            </div>

        </div>
        <div class="nonmobile-inl topadd-m">
            <jdoc:include type="modules" name="addlink"/>
        </div>
    </div>
</div>
<div class="panel_height"></div>
<?php if ($tpl->isError()) : ?>
    <jdoc:include type="message" />
<?php endif; ?>

<div class="topallmax <?php echo $topalmx; ?>">
    <div class="new_all_portal" style="margin-top: 0;">
        <div class="reklama_big">
            <jdoc:include type="modules" name="reklama_big"/>
        </div>	<div class="gorod_logo">

            <a href="/" title="">
                <?php if($logo_img) { ?>
                    <img src="<?php echo $logo_img ?>"  alt=""/>
                <?php } else { ?>
                    <i class="<?php echo $icon_logo ?>"></i
                    ><span class="logo_txt">
				<span class="logo1">
					<?php echo $logo1 ?>
				</span>
				<span class="logo2">
					<?php echo $logo2 ?>
				</span>
				<span class="logo_slogan">
					<?php echo $logo_slogan ?>
				</span>
			</span>
                <?php } ?>
            </a>
        </div
        ><div class="stroka">

            <span class="usd">
				<small>сегодня</small>
				<?php
                $months = array( 1 => 'января' , 'Февраля' , 'марта' , 'апреля' , 'мая' , 'июня' , 'июля' , 'августа' , 'сентября' , 'октября' , 'ноября' , 'декабря' );
                echo date( 'd ' . $months[date( 'n' )]);?>
			</span>
            <span class="pogoda">

			</span>




        </div
        >

        <div class="shop_cart">
            <jdoc:include type="modules" name="cart"/>
        </div>

    </div>
</div>
    <?php if($ismobil==1 ) {?>
    <div class="topmax-mobadd bgonly-mob">
        <?php } ?>
<div class="new_all_portal">
    <div class="logo_block">
        <div class="like_block">
            <div class="gorod">
                <div class="cssload-loader" id="cityloader" style="display: none;"></div>
                <h3> <span itemprop="name"><?php echo $cityname ?></span></h3>
                <p><small class="smallcity">Выбранный город</small></p>
            </div>
            <script type="text/javascript" src="//vk.com/js/api/openapi.js?146"></script>

        </div
        >
        <div class="add_block">
            <div class="top_menu">
                <div class="mobi-t-menu">
                    <ul class="nav menu">
                        <li class=" item-101 default current active">
                            <a href="/#link">
                                <span class="fa fa-home"></span>
                                <span class="menu_txt">
                                        <span>Главная</span></span>
                            </a>
                        </li>
                        <li class=" item-281">
                            <a href="/katalog/uchrezhdeniya/uslugi-zhkkh">
                                <span class="fa fa-briefcase"></span>
                                <span class="menu_txt"><span>Организации</span>
                                    </span>
                            </a></li>

                        <li class=" item-2566"><a href="/ob-yavleniya#link">
                                <span class="fa fa-handshake-o"></span>
                                <span class="menu_txt">
                                        <span>Объявления</span>
                                    </span>
                            </a>
                        </li>
                        <li class="it-m-pre-last"><a href="#add-mass">
                                <span class="fa fa-plus"></span>
                                <span class="menu_txt">
                                        <span>Добавить</span>
                                    </span>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="mobile_menut">
                    <jdoc:include type="modules" name="top_menu"/>
                </div>
            </div>
            <div class="add_links">

                <div class="mobile_add_block mobile_menu">
                    <?php if($user->guest) { ?>
                        <div class="add_col">
                            <a href="/platnoe-razmeshenie"><i class="fa fa-briefcase"></i><span>Добавить организацию</span></a>
                        </div
                        ><div class="add_col">
                            <a href="#login"><i class="fa fa-handshake-o"></i><span>Разместить объявление</span></a>
                        </div
                        ><div class="add_col">
                            <a href="#login"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
                        </div
                        ><div class="add_col">
                            <a href="#login"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
                        </div
                        ><div class="add_col">
                            <a href="/reklama"><i class="fa fa-area-chart"></i><span>Реклама на сайте</span></a>
                        </div>
                    <?php } else { ?>
                        <div class="add_col">
                            <a href="/platnoe-razmeshenie"><i class="fa fa-briefcase"></i><span>Добавить организацию</span></a>
                        </div
                        ><div class="add_col">
                            <a href="/add-doska"><i class="fa fa-handshake-o"></i><span>Разместить объявление</span></a>
                        </div
                        ><div class="add_col">
                            <a href="/add-vakansiya"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
                        </div
                        ><div class="add_col">
                            <a href="/add-resume"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
                        </div
                        ><div class="add_col">
                            <a href="/reklama"><i class="fa fa-area-chart"></i><span>Реклама на сайте</span></a>
                        </div>
                    <?php } ?>
                </div>
            </div
            ><div class="vozrast">
                <span><?php echo $vozrast ?></span>
            </div>
        </div>
    </div>

    <?php if($ismobil==0 ) {?>
        <div class="poisk" >
            <jdoc:include type="modules" name="poisktop"/>
        </div
        ><?php } ?>



    <div class="shop_menu big-pnl">
        <jdoc:include type="modules" name="shop_menu"/>
        <div class="mob_shop_last">
            <div class="mob_shop">
                <jdoc:include type="modules" name="shop_phone"/>
            </div>
        </div>
    </div>





    </div>

<?php if($ismobil==1 )  {?>
    </div>
<?php } ?>

<?php if($this->countModules('home_map')) {?>
    <div class="map_block">
        <jdoc:include type="modules" name="home_map"/>
    </div>
<?php } ?>
<div class="new_all_portal">


    <div class="shop_menu">
            <div id="app-mini" class="app-mini">
                <div class="mapp-link"  onclick="slidemenub('appmcontent')" id="1-header">
                    <i class="fa fa-download" aria-hidden="true"></i> Загрузить приложение</div>
                <div class="app-m-content" id="appmcontent" style="display: none">
                    <div class="text">

                        <div class="mob_shop_dev">
                            <div class="mob_dev">
                                <jdoc:include type="modules" name="shop_phone"/>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    </div>


    <?php if($this->countModules('breadcrumb')) {?>
        <jdoc:include type="modules" name="breadcrumb"/>
    <?php } ?>
    <?php if($this->countModules('full_content')) {?>
        <jdoc:include type="modules" name="full_content"/>
    <?php } ?>
    <a id="link"></a>
    <?php if($this->countModules('reklama_home')) {?>
        <div class="partner_home">
            <jdoc:include type="modules" name="reklama_home" style="top" />
        </div>
    <?php } ?>
    <?php if($this->countModules('rabota')) {?>
        <div class="rabota">
            <jdoc:include type="modules" name="rabota" style="top" />
        </div>
    <?php } ?>

    <?php if($this->countModules('top_block')) {?>
        <div class="top_block">
            <jdoc:include type="modules" name="top_block" style="top"/>
        </div>
    <?php } ?>

    <?php if($this->countModules('news')) {?>
        <div class="home_news">
            <div class="news">

                <jdoc:include type="modules" name="news" style="top"/>
            </div
            >
        </div><?php } ?><?php if($this->countModules('world_news')) {?><div class="home_world_news">
        <jdoc:include type="modules" name="world_news" style="top"/>
    </div>
    <?php } ?>

    <?php if($this->countModules('forum_home')) {?>
        <div class="work_padding">
            <div class="header_work">
                <h3><span class="fa fa-users"></span> Люди о нашем городе</h3>
                <div class="work_button">
                    <a class="add_button" href="/forum"><i class="fa fa-pencil-square-o"></i> Написать на форуме</a>

                </div>
            </div>
            <div class="work_home">
                <div class="work_reklama people_reklama">
                    <jdoc:include type="modules" name="people_reklama" style="top"/>
                </div>
                <div class="reklama_people">
                    <jdoc:include type="modules" name="forum_home" style="top"/>
                    <jdoc:include type="modules" name="comment_home" style="top"/>
                </div>
            </div>

            <div class="header_work">
                <h3><span class="fa fa-bullhorn"></span> Последнее в блогах</h3>
                <div class="work_button">
                    <?php if($user->guest) { ?>
                        <a class="add_button" href="#login"><i class="fa fa-pencil-square-o"></i> Написать в блог</a>
                    <?php } else { ?>
                        <a class="add_button" href="/add-blog"><i class="fa fa-pencil-square-o"></i> Написать в блог</a>
                    <?php } ?>
                </div>
                <div class="home_user_blog">
                    <jdoc:include type="modules" name="blog_home"/>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="left_block">


        <?php if($ismobil!=1 )  {?>
            <jdoc:include type="modules" name="left_blockm" style="top"/>
        <?php } ?>

        <jdoc:include type="modules" name="left_block" style="top"/>


    </div
    ><div id="main_block" class="<?php if($this->countModules('left_block')) {?>main_block<?php } else { ?>big_main_block<?php } ?>">
        <?php if($this->countModules('block_top')) {?>
            <div class="block_top">
                <jdoc:include type="modules" name="block_top" style="top"/>
            </div>
        <?php } ?>
        <?php if($this->countModules('blockcatex_top')) {?>
            <div class="catex">
                <jdoc:include type="modules" name="blockcatex_top" style="top"/>
            </div>
        <?php } ?>
        <jdoc:include type="component" />
    </div>
    <?php if($this->countModules('bottom_block')) {?>
        <div class="bottom_block">
            <jdoc:include type="modules" name="bottom_block" style="top"/>
        </div>
    <?php } ?>

</div>


<div class="mobile footerbg1">
    <div class="new_all_portal">
        <div class="footer">
            <div class="footer_block">
                <jdoc:include type="modules" name="footer_block" style="top"/>
            </div>
        </div>
    </div>
</div>
<div class="footerbg2">
    <div class="new_all_portal">
        <div class="copy">
            <jdoc:include type="modules" name="copy"/>
            <div class="vozrast"><?php echo $vozrast ?></div>
        </div
        ><div class="counter">
            <?php echo $yandex ?>
        </div>
        <div class="cookie">
            <jdoc:include type="modules" name="cookie"/>
        </div>

        <a href="#x" class="overlay" id="login"></a>
        <div class="popup login">
            <jdoc:include type="modules" name="login" style="top" />
            <a class="close1" title="Закрыть" href="#close"></a>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function(){
        jQuery("#back-top").hide();
        jQuery(function () {
            jQuery(window).scroll(function () {
                if (jQuery(this).scrollTop() > 100) {
                    $q('#back-top').addClass("bgsh");
                    jQuery('#back-top').fadeIn();
                } else {
                    $q('#back-top').removeClass("bgsh");
                    jQuery('#back-top').fadeOut();
                }
            });
            jQuery('#back-top a').click(function () {
                jQuery('body,html').animate({
                    scrollTop: 0
                }, 800);
                return false;
            });
        });
    });
</script>

<div class="new_all_portal">






<div  id="wdg-r" class="btn-wgt">

    <div id="back-top">

            <a href="#top"><i class="fa fa-arrow-up"></i></a>

    </div>
    <?php if ($ismobil == 1) { ?>

                    <jdoc:include type="modules" name="poisk"/>

    <?php } ?>



</div>


</div>
<div class="gorod_all">
    <div id="popupCitycnt" class="popupcity with-shifted-close" >
        <div class="backloadbg" id="loadref" >
            <p class="chloader">Обновляем город...</p>
            <div class="cssload-container" id="citychnj" style="display: block;">
                <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
            </div>
        </div>
        <a href="#"  onclick="Citycntcls();" class="closePopup">&nbsp;</a>
        <div class="city-select-control state-region" data-started="true" style="display: block;">
            <div class="top-panel">
                <h1>Выбор города</h1>
                <div class="search-container">
                    <input class="search" name="search" id="fcytinp" placeholder="Название города..." onkeyup="searchTown(this.value)">
                    <a href="javascript:void(0);" onclick="searchTown()" class="close"></a>
                    <div class="tagspopular shtr" style="position: absolute;top: 40px;">
                        <ul>
                            <li>
                                <a href="javascript:void(0);" onclick="SetCity('E6D830DB-FA47-4D7C-8D6E-5BD09E037E98');">
                                    <span>Владивосток</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0);" onclick="SetCity('BB2287A8-EB92-4CEE-A606-D09353452996');">
                                    <span>Находка</span>
                                </a>
                            </li>

                            <li>
                                <a href="javascript:void(0);" onclick="SetCity('0A674AF6-378E-4A52-932E-A27ACC16581A');">
                                    <span>Уссурийск</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="SetCity('FEB01130-4C36-4006-81F6-52F5CD64DD2C');">
                                    <span>Артём</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" onclick="SetCity('4E69AEB1-FC35-42A4-A313-F2A8B2158CCF');" >
                                    <span>Угловое пос.</span>
                                </a>
                            </li>

                        </ul>
                    </div>


                </div>

            </div>
            <div class="federal-district block" id="federallist">
                <div>
                    <div class="countries">

                        <div class="bottom-fade-out"></div>
                    </div>
                    <div class="federal-districts with-next-step">
                        <ul data-selected="0" id="regionlist" class="reglist237">

                        </ul>
                    </div>
                </div>
            </div>

            <div class="city block" id="ctityblock">
                <div class="padded-frame">
                    <div class="cssload-container" id="cityloader2" style="display: none;">
                        <div class="cssload-loading"><i></i><i></i><i></i><i></i></div>
                    </div>
                    <ul data-selected="0" id="townlist">

                    </ul>
                </div>
                <div class="bottom-fade-out"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
    <div class="new_all_portal">
    <div id="popupcatexM" class="popupcity with-shifted-close" >
        <a href="#"  onclick="swctexcls();" class="closePopup">&nbsp;</a>
        <div class="city-select-control state-region" data-started="true" style="display: block;">
            <div class="top-panel catexlst">
                <h1><span class="fa fa-bars"></span> Категории</h1>

            </div>
            <div class="pcatex block" id="tcaceex">
                <div>

                    <div class="federal-districts with-next-step">

                            <jdoc:include type="modules" name="left_blockm" style="top"/>



                    </div>
                </div>
            </div>


            <div class="clear"></div>
        </div>
    </div>
    </div>

    <a href="#x" class="overlay" id="add-mass"></a>
    <div class="popup">
        <div class="m-lmain-ad">
            <?php if($user->guest) { ?>
                <div class="add_col">
                    <a href="/platnoe-razmeshenie"><i class="fa fa-briefcase"></i><span>Добавить организацию</span></a>
                </div
                ><div class="add_col">
                    <a href="#login"><i class="fa fa-handshake-o"></i><span>Разместить объявление</span></a>
                </div
                ><div class="add_col">
                    <a href="#login"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
                </div
                ><div class="add_col">
                    <a href="#login"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
                </div
                >
            <?php } else { ?>
                <div class="add_col">
                    <a href="/platnoe-razmeshenie"><i class="fa fa-briefcase"></i><span>Добавить организацию</span></a>
                </div
                ><div class="add_col">
                    <a href="/add-doska"><i class="fa fa-handshake-o"></i><span>Разместить объявление</span></a>
                </div
                ><div class="add_col">
                    <a href="/add-vakansiya"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
                </div
                ><div class="add_col">
                    <a href="/add-resume"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
                </div
                >
            <?php } ?>
        </div>
        <a class="close1" title="Закрыть" href="#close"></a>
    </div>


    <a href="#x" class="overlay" id="add-job"></a>
    <div class="popup">
        <div class="m-lmain-ad">
            <?php if($user->guest) { ?>
             <div class="add_col">
                    <a href="#login"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
                </div
                ><div class="add_col">
                    <a href="#login"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
                </div
                >
            <?php } else { ?>
                <div class="add_col">
                    <a href="/add-vakansiya"><i class="fa fa-wrench"></i><span>Добавить вакансию</span></a>
                </div
                ><div class="add_col">
                    <a href="/add-resume"><i class="fa fa-wrench"></i><span>Добавить резюме</span></a>
                </div
                >
            <?php } ?>
        </div>
        <a class="close1" title="Закрыть" href="#close"></a>
    </div>
</main>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery('.spoiler').click(function(){
            if (jQuery(this).next('.spoiler_text').css("display")=="none") {
                jQuery('.spoiler_text').hide('normal');
                jQuery(this).next('.spoiler_text').fadeToggle('normal');
            }
            else jQuery('.spoiler_text').hide('normal');
            return false;
        });


        jQuery('.left_block .gruz_top h3').click(function(){
            if (jQuery(this).next('.left_block .gruz_top ul.menu').css("display")=="none") {
                jQuery('.left_block .gruz_top ul.menu').hide('normal');
                jQuery(this).next('.left_block .gruz_top ul.menu').fadeToggle('normal');
            }
            else jQuery('.left_block .gruz_top ul.menu').hide('normal');
            return false;
        });

        jQuery('.left_block .gruz_top h3').click(function(){
            if (jQuery(this).next('.left_block .gruz_top .newsflash').css("display")=="none") {
                jQuery('.left_block .gruz_top .newsflash').hide('normal');
                jQuery(this).next('.left_block .gruz_top .newsflash').fadeToggle('normal');
            }
            else jQuery('.left_block .gruz_top .newsflash').hide('normal');
            return false;
        });

        jQuery('.mob_shop').click(function(){
            if (jQuery(this).next('.shop_menu ul.menu').css("display")=="none") {
                jQuery('.shop_menu ul.menu').hide('normal');
                jQuery(this).next('.shop_menu ul.menu').fadeToggle('normal');
            }
            else jQuery('.shop_menu ul.menu').hide('normal');
            return false;
        });

        jQuery('.mobile_link').click(function(){
            if (jQuery(this).next('.mobile_menu').css("display")=="none") {
                jQuery('.mobile_menu').hide('normal');
                jQuery(this).next('.mobile_menu').fadeToggle('normal');
            }
            else jQuery('.mobile_menu').hide('normal');
            return false;
        });

    });

    //МАСКИ ДЛЯ ФОРМ
    jQuery(function($){
        $("#zp").mask("9999?99 руб");
        $("#edit_zp").mask("9999?99 руб");
        $("#phone").mask("+7 (999) 999-99-99");
        $("#edit_phone").mask("+7 (999) 999-99-99");
        $("#edit_phone").mask("+7 (999) 999-99-99");
        $("#date").mask("99.99.9999 г.");
        $("#god").mask("9999? г.");
        $("#etazh").mask("9?9 этаж");
        $("#etazhey").mask("9?9 этажей в доме");
        $("#ploshad").mask("99?9 кв.м");
        $("#ploshad1").mask("99?9 кв.м");
        $("#ploshad2").mask("9?99 кв.м");
        $("#probeg").mask("9?99999 км");
        $("#obem").mask("9.9? л");
        $("#moshnost").mask("99?9 л/с");
    });
</script>
<script>
    var slideout = new Slideout({
        'panel': document.getElementById('panel'),
        'menu': document.getElementById('menu'),
        'padding': 256,
        'tolerance': 70
    });

    // Toggle button
    document.querySelector('.toggle-button').addEventListener('click', function() {
        slideout.toggle();
    });
    document.querySelector('.mobile-m-cls').addEventListener('click', function() {
        slideout.toggle();
    });
</script>

<?php require dirname(__FILE__) . '/css/style.php';?>
</body>
</html>
