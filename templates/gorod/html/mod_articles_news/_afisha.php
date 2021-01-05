<?php defined('_JEXEC') or die;
$item_id = $item->id;


$user = JFactory::getUser();
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);
$rating_user = $templ->params->get('rating_user', '');
?>

    <div class="mod_news_img">



        <a href="<?php echo $item->link ?>" target="_blank" title="<?php echo $item->header ?>"><span class="podlozhka"></span></a>
        <div id="sigplus_1012" class="sigplus-gallery sigplus-center sigplus-lightbox-boxplusx">
            <ul>
                <li>


                        <img itemprop="logo" class="b-image__image b-image_type_fit b-image_fit-cover"
                             src="<?php echo $item->image ?>">

                </li>
            </ul>
        </div>
    </div>

    <div class="news_caption">
        <h3><a href="<?php echo $item->link ?>" target="_blank" title="<?php echo $item->header ?>"><?php echo $item->header ?></a></h3>
    </div>
    <div class="mini_icon">


        <div class="ic">
            <?php if ($rating_user == '0') { ?>
                <?php JPluginHelper::importPlugin('content', 'vrvote');
                $dispatcher = JDispatcher::getInstance();
                $results = $dispatcher->trigger('vrvote', $item->id); ?>
            <?php } else { ?>
                <?php if ($user->guest) { ?>
                    <span class="no_rating">
						<a class="no_link" href="#login"></a>
						<?php JPluginHelper::importPlugin('content', 'vrvote');
                        $dispatcher = JDispatcher::getInstance();
                        $results = $dispatcher->trigger('vrvote', '2020'.$item->id); ?>
					</span>
                <?php } else { ?>
                    <?php JPluginHelper::importPlugin('content', 'vrvote');
                    $dispatcher = JDispatcher::getInstance();
                    $results = $dispatcher->trigger('vrvote', $item->id); ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="mod_cat">

            <?php
            $pdescript = explode("<br>", $item->descript);
            if(count($pdescript)>=2)  echo $pdescript[1] ;
            else  echo $item->descript ;

            ?>

    </div>



