<?php defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

$item_id = $this->item->id;

require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';
$user = JFactory::getUser();	
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);	
$rating_user = $templ->params->get('rating_user', '');
?>


<div class="padding">

	<div class="mod_news_img">
        <a href="<?php echo $this->item->link ?>" target="_blank" title="<?php echo $this->item->header ?>"><span class="podlozhka"></span></a>
        <div id="sigplus_1012" class="sigplus-gallery sigplus-center sigplus-lightbox-boxplusx">
            <ul>
                <li>
                    <a class="sigplus-image" href="#" target="_blank" title=" (1/1)"
                       data-summary=" (1/1)">
                        <img class="sigplus-preview" src="<?php echo $this->item->image ?>" width="170" height="270" alt="" sizes="170px"></a>
                </li>
            </ul>
        </div>
    </div>

<div class="afisha_item_info">
	<h3>
		<a href="<?php echo $this->item->link?>#link" target="_blank" title="<?php echo $this->item->header ?>">
			<span><?php echo $this->item->header ?></span>
		</a>
	</h3>
</div>
		<div class="mini_icon">

			<div>
			<div class="ic">
				<?php if($rating_user == '0') { ?>
					<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $this->item->id ); ?>
				<?php } else { ?>
					<?php if($user->guest) { ?>
					<span class="no_rating">
						<a class="no_link" href="#login"></a>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $this->item->id ); ?>
					</span>
					<?php } else { ?>
						<?php JPluginHelper::importPlugin( 'content', 'vrvote' ); $dispatcher = JDispatcher::getInstance(); $results = $dispatcher->trigger( 'vrvote', $this->item->id ); ?>
					<?php } ?>
				<?php } ?>
			</div>
			</div>
		</div>
		<div class="mod_cat">

				<?php echo $this->item->descript ?>

		</div>
<?php if($this->item->name) { ?>
<div class="data_afisha">
	<i class="fa fa-clock-o"></i> <span><?php echo $this->item->name ?></span>
</div>
<?php } ?>
<?php if($this->item->descript) { ?>

<?php } ?>
</div>

