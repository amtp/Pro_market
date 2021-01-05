<?php
defined('_JEXEC') or die;
$db = JFactory::getDbo();

?>
<?php if (!empty($names)) : ?>        
<ul class="latestusers<?php echo $moduleclass_sfx ?>" >
    <?php foreach ($names as $name) :?> 
		<?php 	
			$user_id = $name->id;
			$db->setQuery("SELECT COUNT(`id`) FROM #__content WHERE catid >='1962' AND catid <='1974' AND created_by='$user_id'");
			$count = $db->loadResult(); 			
			?>
		<?php if($count > 0) { ?>
		<?php $db->setQuery("SELECT `avatar` FROM #__plg_slogin_profile WHERE user_id = '$user_id'");
				$avatar = $db->loadResult(); ?>
		<li>
			<span class="userblog_avatar">
				<?php if($avatar) { ?>
					<img src="/images/avatar/<?php echo $avatar ?>" />
				<?php } else { ?>
					<img src="/images/no_image.jpg" />
				<?php } ?>
			</span
			><span class="userblog_user">
				<a href="/blogarticles?userid=<?php echo $name->id; ?>"><?php echo $name->name; ?></a>
				<small><label>Статей:</label> <?php echo $count ?></small>
			</span>
		</li>
		<?php } ?>
    <?php endforeach;  ?>        
</ul>
<?php endif; ?>