<?php defined('_JEXEC') or die('(@)|(@)');
$app = JFactory::getApplication();
$templ = $app->getTemplate(true);
$money_no = $templ->params->get('money_no', '');

$db = JFactory::getDbo();
$user = JFactory::getUser();

$user_id = $user->id;
$db->setQuery("SELECT balans FROM #__users WHERE id = '$user_id'");
$balans = $db->loadResult();
$db->setQuery("SELECT COUNT(id) FROM #__content WHERE created_by = '$user_id'");
$count_tex = $db->loadResult();

if(!$user->guest) {
    $davatar = $user->avatar;
    if ($davatar != null && $davatar != "") {
        $davatar = "/images/avatar/" . $davatar;
    } else {
        $davatar = "/uploads/net-foto-200x200.png";
    }
}
?>
<noindex>
<div class="jlslogin">
<?php if ($type == 'logout') : ?>

<form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form">


        <div class="slogin-avatar">
			<a href="/lk">
				<img src="<?php echo $davatar; ?>" alt=""/>
			</a>
        </div>


    <div class="login-greeting">
        <a href="/lk">
			<?php echo JText::sprintf(htmlspecialchars($user->get('name')));	 ?>
			<?php if($money_no == 1) { ?><small>Баланс: <span><?php echo $balans ?> <i class="fa fa-rub"></i></span></small><?php } ?>
		</a>
    </div>

	<div class="user_menu">
		<div class="us_panel">
			<?php if($money_no == 1) { ?>
			<div class="us_balans">
				<span>
					<label>Баланс:</label> <span><?php echo $balans ?> <i class="fa fa-rub"></i></span>
				</span>
				<a href="/lk">пополнить</a>
			</div>
			<?php } ?>
			<div class="us_block">
				<ul>
					<li><i class="fa fa-file-text-o"></i> <a href="/lk">Мои материалы</a> <sup><?php echo $count_tex ?></sup></li>
				</ul>
				<ul>
					<li><i class="fa fa-user-circle-o"></i> <a href="/lk">Личный кабинет</a></li>
					<li><i class="fa fa-pencil-square-o"></i> <a href="/lk">Редактировать профиль</a></li>
				</ul>
				<ul>
					<li><i class="fa fa-history"></i> <a href="/lk">История платежей</a></li>

				</ul>
			</div>
			<div class="logout-button">
				<input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGOUT'); ?>" />
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.logout" />
				<input type="hidden" name="return" value="<?php echo $return; ?>" />
				<?php echo JHtml::_('form.token'); ?>
			</div>
		</div>
	</div>
</form>
<?php else : ?>
<?php if ($params->get('inittext')): ?>

    <div class="pretext">
        <p><?php echo $params->get('inittext'); ?></p>
    </div>
    <?php endif; ?>

<div id="slogin-buttons" class="slogin-buttons slogin-compact">
    <?php if (count($plugins)): ?>
        <?php
        foreach($plugins as $link):
            $linkParams = '';
            if(isset($link['params'])){
                foreach($link['params'] as $k => $v){
                    $linkParams .= ' ' . $k . '="' . $v . '"';
                }
            }
            $title = (!empty($link['plugin_title'])) ? ' title="'.$link['plugin_title'].'"' : '';
            ?>
            <a  rel="nofollow" <?php echo $linkParams.$title;?> href="<?php echo JRoute::_($link['link']);?>"><span class="<?php echo $link['class'];?>">&nbsp;</span></a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div class="slogin-clear"></div>

    <?php if ($params->get('pretext')): ?>
    <div class="pretext">
        <p><?php echo $params->get('pretext'); ?></p>
    </div>
    <?php endif; ?>

<?php if ($params->get('show_login_form')): ?>
    <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form" >
        <fieldset class="userdata">
            <p id="form-login-username">
                <input id="modlgn-username" type="text" name="username" class="inputbox"  size="18" placeholder="<?php echo JText::_('MOD_SLOGIN_VALUE_USERNAME') ?>"/>
            </p>
            <p id="form-login-password">
                <input id="modlgn-passwd" type="password" name="password" class="inputbox" size="18" placeholder="<?php echo JText::_('JGLOBAL_PASSWORD') ?>" />
            </p>
            <?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <p id="form-login-remember">
				 <label for="modlgn-remember">
				  	<input id="modlgn-remember" type="checkbox" name="remember" class="inputbox" value="yes"/>
				  	<?php echo JText::_('MOD_SLOGIN_REMEMBER_ME') ?>
				 </label>
			</p>
			<div class="slogin-clear"></div>
            <?php endif; ?>
            <input type="submit" name="Submit" class="button" value="<?php echo JText::_('JLOGIN') ?>" />
            <input type="hidden" name="option" value="com_users" />
            <input type="hidden" name="task" value="user.login" />
            <input type="hidden" name="return" value="<?php echo $return; ?>" />
            <?php echo JHtml::_('form.token'); ?>
        </fieldset>
        <ul class="ul-jlslogin">
            <li>
                <a  rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
                    <?php echo JText::_('MOD_SLOGIN_FORGOT_YOUR_PASSWORD'); ?></a>
            </li>
            <li>
                <a  rel="nofollow" href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>">
                    <?php echo JText::_('MOD_SLOGIN_FORGOT_YOUR_USERNAME'); ?></a>
            </li>
        </ul>
        <?php if ($params->get('posttext')): ?>
        <div class="posttext">
            <p><?php echo $params->get('posttext'); ?></p>
        </div>
        <?php endif; ?>
    </form>
    <?php endif; ?>
<?php endif; ?>
</div>
</noindex>
