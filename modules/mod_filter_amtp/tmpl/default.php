<?php 
// No direct access
defined('_JEXEC') or die;
//echo $filter_amtp;
// <div id="myDiv1">
$activeTitle = JFactory::getApplication()->getMenu()->getActive()->title;

?>


<div class="pre-hfix" id="tpre_fix"></div>
<div hmfix class="h-fix" id="clfix">

    


    <div id="smartsrch"></div>
    <div class="filter-toolbar" role="toolbar" aria-label="Фильтр поиска" id="filter">
        <div class="bgfl">
            <div class="btns-fltr">


                <div class="btn-wrapper" id="filter-actual" onclick="filterclic(this)">
        <span class="filter-main" tabindex="1">
            <i class="foff fa-sort" aria-hidden="true"></i>
            <i class="fonn fa-sort-down" aria-hidden="true"></i>
            Сортировка</span>
                    <span class="rl-prm" id="fsglc">Новые</span>
                    <ul class="sub-filter">
                        <li onclick="companylist('colr',0,1);">
                            <span id="fsgl0"> <i class="fa fa-check" aria-hidden="true"></i></span>

                            Новые
                        </li>
                        <li onclick="companylist('colr',1,1);">
                            <span id="fsgl1" style="display: none"> <i class="fa fa-check"
                                                                       aria-hidden="true"></i></span>
                            Дешевле
                        </li>
                        <li onclick="companylist('colr',1,1);">
                            <span id="fsgl1" style="display: none"> <i class="fa fa-check"
                                                                       aria-hidden="true"></i></span>
                            Дороже
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

                <div class="btn-wrapper btn-filter" id="filt-catex" style="display:inline-block;" onclick="swctex()">
                    <span class="filter-main  adn-fltr" tabindex="1">Категории</span>
                    <span class="rl-prm"><i class="fa fa-braille" aria-hidden="true"></i></span>

                </div>

            </div>

        </div>
    </div>


</div>
<script>
    function addFixCls()
    {
    //    jQuery('#smartsrch').append( jQuery('#smartsrch_main>form') );

        jQuery(".h-fix").addClass('hfixsc-up');
    }
    function remFixCls()
    {
    //    jQuery('#smartsrch_main').append( jQuery('#smartsrch>form') );
        jQuery(".h-fix").removeClass('hfixsc-up');
    }
</script>







