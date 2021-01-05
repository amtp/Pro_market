<?php
defined('_JEXEC') or die;
require dirname(__FILE__) . '/php/pro-portal.php';
require dirname(__FILE__) . '/php/init.php';
if (1 < 2) {
    $user = JFactory::getUser();
    $user_id = $user->id;
    $db = JFactory::getDbo();

    $app = JFactory::getApplication('gorod');
    $template = $app->getTemplate('gorod');
    $gorod = $template->params->get('gorod', '');
    $like = $template->params->get('vk_like');
    $stroka = $template->params->get('stroka', '');
    $logo_img = $template->params->get('logo_img');
    $icon_logo = $template->params->get('icon_logo');
    $logo1 = $template->params->get('logo1');
    $logo2 = $template->params->get('logo2');
    $logo_slogan = $template->params->get('logo_slogan');

    $vozrast = $template->params->get('vozrast');
    $valuta = $template->params->get('strana', '');
    $valuta1 = $template->params->get('valuta', '');
    $holiday = $template->params->get('holiday', '');
    $holiday_text = $template->params->get('holiday_text', '');
    $domen = JUri::base();
    $yandex = $template->params->get('yandex', '');

    require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';
    if (method_exists('UsersHelper', 'getTwoFactorMethods')) {
        $twoFactors = UsersHelper::getTwoFactorMethods();
    }
    ?><?php echo $tpl->renderHTML(); ?>
    <head>

        <?php echo $tpl->renderHead2(); ?>

        <link rel="stylesheet" type="text/css" href="/templates/gorod/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="/templates/gorod/css/responsive.css">
        <link rel="stylesheet" type="text/css" href="/templates/gorod/css/carousel.css">
        <link href="/modules/mod_slogin/tmpl/default/slogin.min.css" rel="stylesheet" type="text/css"/>
        <link href="/modules/mod_vm_cart/assets/css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="citytmpl/favicon.ico" type="image/x-icon">

        <script src="/modules/mod_slogin/media/slogin.min.js" type="text/javascript"></script>
        <script src="/modules/mod_vm_cart/assets/js/update_cart.js" type="text/javascript"></script>

        <script src="/media/jui/js/jquery.min.js"></script>
        <script src="/media/jui/js/jquery-noconflict.js"></script>
        <script src="/media/jui/js/jquery-migrate.min.js"></script>
        <script src="/media/system/js/caption.js"></script>
        <script src="/templates/gorod/js/template.js"></script>
        <script src="/components/com_virtuemart/assets/js/jquery-ui.min.js?vmver=1.9.2"></script>
        <script src="/components/com_virtuemart/assets/js/jquery.ui.autocomplete.html.js"></script>
        <script src="/components/com_virtuemart/assets/js/jquery.noconflict.js" async></script>
        <script src="/components/com_virtuemart/assets/js/fancybox/jquery.fancybox-1.3.4.pack.js?vmver=1.3.4"></script>
        <script src="/components/com_virtuemart/assets/js/vmprices.js?vmver=da81180f"></script>
        <script src="/media/sigplus/js/initialization.min.js" defer></script>
        <script src="/media/sigplus/engines/boxplusx/js/boxplusx.min.js?v=9c64bad073ce14d5d8a41c8beb2bb8b3"
                defer></script>
        <script src="/media/sigplus/engines/captionplus/js/captionplus.min.js?v=1bd5251e4bc8f44c979e7e5e056ad349"
                defer></script>
        <script src="/plugins/content/vrvote/assets/vrvote.js"></script>
        <script src="/media/jui/js/chosen.jquery.min.js?de003d97721bd52e71b9c64326ebd484"></script>
        <script src="/media/jui/js/jquery.autocomplete.min.js?de003d97721bd52e71b9c64326ebd484"></script>
        <script src="/modules/mod_vm_cart/assets/js/update_cart.js"></script>

        <script type="text/javascript" src="/templates/gorod/js/carousel.js"></script>
    </head>
    <body class="err-full">


    <div class="topallmax">
        <div class="new_all_portal">
            <div class="reklama_big">


                <div class="custom">
                </div>

            </div>
            <div class="gorod_logo">

                <a href="/" title="">
                    <img src="<?php echo $domen; ?>/images/logo-2.png"
                         data-src="<?php echo $domen; ?>/images/logo-2.png" alt="">
                </a>
            </div>
            <div class="stroka">
								<span class="usd">
				<small>сегодня</small>
				<?php
                $months = array(1 => 'января', 'Февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
                echo date('d ' . $months[date('n')]); ?>
			</span>


            </div>
            <div class="shop_phone" style="width: 15%;">

            </div>
            <div class="shop_cart">


                <div class="custom">
                    <article class="info-modern"><span class="fas fa-phone-alt"
                                                       style="font-size: 25px;padding-right: 10px;"
                                                       aria-hidden="true"></span><span style="font-size: 24pt;"><a
                                    href="tel:84232516516" class="phonemain">2-516-516</a></span></article>
                    <p><small>Справочная служба твоего города</small></p></div>

            </div>

        </div>
    </div>
    <div class="errt-full">
        <div class="new_all_portal err-full">
            <div class="content_error">
                <div class="table_error">
                    <div class="cell_error">
                        <div class="error_text">
                            <h1><?php echo $this->error->getCode(); ?></h1>
                            <div class="errorinfo">
                                <?php


                                echo htmlspecialchars($this->error->getMessage()."5");
                                ?>
                            </div>
                            <a href="<?php echo $this->baseurl; ?>/"
                               title="<?php echo JText::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>">На главную</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bott-err">
            <div class="footerbg1">
                <div class="new_all_portal">

                    <div class="bottom_block">
                        <?php echo JHtml::_('content.prepare', '{loadposition bottom_block,top}'); ?>
                    </div>

                    <div class="footer">
                        <div class="footer_block">
                            <?php echo JHtml::_('content.prepare', '{loadposition footer_block,top}'); ?>
                        </div>
                    </div>

                </div>
            </div>

            <div class="footerbg2">
                <div class="new_all_portal">
                    <div class="copy" style="width: 89% !important;">
                        <?php echo JHtml::_('content.prepare', '{loadposition copy,none}'); ?>
                        <div class="vozrast"><?php echo $vozrast ?></div>
                    </div>

                    <div class="counter">
                        <?php echo $yandex ?>
                    </div>


                </div>
            </div>
        </div>

    </div>


    </body>
    </html>
    <style>

        .vmCartModule svg {
            fill: #eb4120
        }

        .cart_top .total_products,
        .cart_content .show_cart a {
            background: #eb4120;
        }

        .js-ready {
            height: 100%;
        }

        .vmCartModule {
            border-color: #eb4120;
        }

        .vmCartModule a,
        .vmCartModule a:hover,
        .vmCartModule .product_name a,
        .vmCartModule .product_name a:hover,
        .cart_top .total strong,
        .cart_top .total strong:hover {
            color: #eb4120;
        }

        .total_products {
            display: inline-block;
            vertical-align: middle;
            -webkit-transform: translateZ(0);
            transform: translateZ(0);
            box-shadow: 0 0 1px rgba(0, 0, 0, 0);
            -webkit-backface-visibility: hidden;
            backface-visibility: hidden;
            -moz-osx-font-smoothing: grayscale;
        }

        #vmCartModule:hover .total_products {
            -webkit-animation-name: hvr-wobble-vertical;
            animation-name: hvr-wobble-vertical;
            -webkit-animation-duration: 1s;
            animation-duration: 1s;
            -webkit-animation-timing-function: ease-in-out;
            animation-timing-function: ease-in-out;
            -webkit-animation-iteration-count: 1;
            animation-iteration-count: 1;
        }
    </style>

    <script type="text/javascript">

        jQuery(document).ready(function () {
            jQuery('.spoiler').click(function () {
                if (jQuery(this).next('.spoiler_text').css("display") == "none") {
                    jQuery('.spoiler_text').hide('normal');
                    jQuery(this).next('.spoiler_text').fadeToggle('normal');
                } else jQuery('.spoiler_text').hide('normal');
                return false;
            });


            jQuery('.left_block .gruz_top h3').click(function () {
                if (jQuery(this).next('.left_block .gruz_top ul.menu').css("display") == "none") {
                    jQuery('.left_block .gruz_top ul.menu').hide('normal');
                    jQuery(this).next('.left_block .gruz_top ul.menu').fadeToggle('normal');
                } else jQuery('.left_block .gruz_top ul.menu').hide('normal');
                return false;
            });

            jQuery('.left_block .gruz_top h3').click(function () {
                if (jQuery(this).next('.left_block .gruz_top .newsflash').css("display") == "none") {
                    jQuery('.left_block .gruz_top .newsflash').hide('normal');
                    jQuery(this).next('.left_block .gruz_top .newsflash').fadeToggle('normal');
                } else jQuery('.left_block .gruz_top .newsflash').hide('normal');
                return false;
            });

            jQuery('.mob_shop').click(function () {
                if (jQuery(this).next('.shop_menu ul.menu').css("display") == "none") {
                    jQuery('.shop_menu ul.menu').hide('normal');
                    jQuery(this).next('.shop_menu ul.menu').fadeToggle('normal');
                } else jQuery('.shop_menu ul.menu').hide('normal');
                return false;
            });

            jQuery('.mobile_link').click(function () {
                if (jQuery(this).next('.mobile_menu').css("display") == "none") {
                    jQuery('.mobile_menu').hide('normal');
                    jQuery(this).next('.mobile_menu').fadeToggle('normal');
                } else jQuery('.mobile_menu').hide('normal');
                return false;
            });

        });

        //МАСКИ ДЛЯ ФОРМ
        jQuery(function ($) {
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
    <?php require dirname(__FILE__) . '/css/style.php'; ?>
<?php } else { ?>
    <?php require_once dirname(__FILE__) . '/php/no_lic.php'; ?>
<?php } ?>