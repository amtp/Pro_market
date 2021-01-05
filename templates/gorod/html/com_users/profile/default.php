<?php
defined('_JEXEC') or die;
$app = JFactory::getApplication();
$template = $app->getTemplate(true);
$money_no = $template->params->get('money_no', '');

require_once JPATH_ADMINISTRATOR.'/components/com_rsform/helpers/rsform.php';
$user = JFactory::getUser();
$db = JFactory::getDbo();

$user_id = $user->id; 
//$db->setQuery("SELECT `avatar` FROM #__plg_slogin_profile WHERE user_id = '$user_id'");
//$avatar = $db->loadResult();

$db->setQuery("SELECT balans FROM #__users WHERE id = '$user_id'");
$balans = $db->loadResult();
?>
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Личные данные"><i class="fa fa-money"></i> Личные данные</label>

    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Редактировать"><i class="fa fa-pencil-square-o"></i> Редактировать</label>

    <input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Материалы"><i class="fa fa-file-text-o"></i> Материалы</label>


    <section id="content-tab1">
		<div class="us_lk1">
			<div class="ava_block">
				<div class="ava">
                    <?php echo RSFormProHelper::displayForm('50'); // ФОРМА ИЗМЕНЕНИЕ АВАТАРА?>


					<small><a href="/add-foto">Привязанные соцсети</a></small>

				</div>
			</div
			><div class="lk_user">
				<h3><?php echo $user->name ?></h3>
				<div class="lk_mail"><?php echo $user->email ?></div>
				<?php if($money_no == 1) { ?>	
					<div class="lk_balans">
						<label>Баланс:</label>
						<span><?php echo number_format($balans,0,'',' '); ?> <i class="fa fa-rub"></i></span>
					</div>
				<?php } ?>
				<form action="<?php echo JRoute::_('index.php?option=com_users&task=user.logout'); ?>" method="post" class="form-horizontal well">
					<div class="control-group">
						<div class="controls">
							<button type="submit" class="rsform-submit-button btn btn-primary">
								<span class="icon-arrow-left icon-white"></span>
								<?php echo JText::_('JLOGOUT'); ?>
							</button>
						</div>
					</div>
					<?php if ($this->params->get('logout_redirect_url')) : ?>
						<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_url', $this->form->getValue('return'))); ?>" />
					<?php else : ?>
						<input type="hidden" name="return" value="<?php echo base64_encode($this->params->get('logout_redirect_menuitem', $this->form->getValue('return'))); ?>" />
					<?php endif; ?>
					<?php echo JHtml::_('form.token'); ?>
				</form>
			</div
			><?php if($money_no == 1) { ?><div class="add_balans">
				<?php echo RSFormProHelper::displayForm('31'); // ФОРМА ПОПОЛНЕНИЯ БАЛАНСА ?>
			</div><?php } ?>
		</div>
		
<?php if($money_no == 1) { ?>		
<?php
$userId = JFactory::getUser()->get('id');
$userName = JFactory::getUser()->get('name');
$html = '';
$query = '
select id, pay_id, pay_data, pay_name, pay_summa, pay_item_id 
from #__history_pay
where user_id = '.$userId.'';

$db->setQuery($query);
$rows_one = $db->loadObjectList(); 
$rows = array_reverse($rows_one);
?>
<div class="history">
<h4><i class="fa fa-history"></i> История платежей</h4>
<div class="top_history">
	<div class="top_row"><span>ID платежа</span>
	</div
	><div class="top_row"><span>Дата платежа</span>
	</div
	><div class="top_row"><span>Услуга</span>
	</div
	><div class="top_row"><span>Сумма</span>
	</div>
</div>

<?php 
$rows1 = array_slice($rows, 0, 6);//первые три платежа
foreach($rows1 as $key => $row) { 
?>
<div class="bottom_history one">
	<div class="row">
	<?php if($row->pay_id) { ?>
		<?php echo $row->pay_id;?>
	<?php } else { ?>
		<?php echo $row->id;?>
	<?php } ?>
	</div
	><div class="row">
		<?php 
			$date = $row->pay_data;
			$d = new DateTime($date);
			$d->modify('+3 hours');
			$data = $d->format("d.m.Y G:i");
			echo $data;
		?>
	</div
	><div class="row">
		<?php echo $row->pay_name ?>
	</div
	><div class="row">
		<?php if($row->pay_summa > 0) { ?>
			<span class="color_plus"><?php echo $row->pay_summa ?> руб.</span>
		<?php } else { ?>
			<span class="color_minus"><?php echo $row->pay_summa ?> руб.</span>
		<?php } ?>
	</div>
</div>
<?php } ?>
<div class="history right">
	<a href="#" class="all-history"><i class="fa fa-angle-double-down"></i> <span>Смотреть все платежи</span></a>
</div>

<div class="old_history">
<?php 
$rows2 = array_slice($rows, 6);//остальные платежи
foreach($rows2 as $key => $row) { 
?>

	<div class="row">
	<?php if($row->pay_id) { ?>
		<?php echo $row->pay_id;?>
	<?php } else { ?>
		<?php echo $row->id;?>
	<?php } ?>
	</div
	><div class="row">
		<?php 
			$date = $row->pay_data;
			$d = new DateTime($date);
			$d->modify('+3 hours');
			$data = $d->format("d.m.Y G:i");
			echo $data;
		?>
	</div
	><div class="row">
		<?php echo $row->pay_name ?>
	</div
	><div class="row">
		<?php if($row->pay_summa > 0) { ?>
			<span class="color_plus"><?php echo $row->pay_summa ?> руб.</span>
		<?php } else { ?>
			<span class="color_minus"><?php echo $row->pay_summa ?> руб.</span>
		<?php } ?>
	</div>

<?php } ?>	
</div>
<?php } ?>	
    </section>  

	<section id="content-tab2">
		<div class="edit_profile">
			<?php echo RSFormProHelper::displayForm('22'); // ФОРМА РЕДАКТИРОВАНИЯ ПРОФИЛЯ ?>	
		</div>
    </section> 

    <section id="content-tab3">
<?php
defined('_JEXEC') or die;
require_once JPATH_SITE.'/components/com_content/helpers/route.php';
$db = JFactory::getDBO();
$userId = JFactory::getUser()->get('id');
$userName = JFactory::getUser()->get('name');
$html = '';
$query = '
select a.hits as hits, a.id as aid, a.catid as catid, a.alias as aailas, a.title as atitle, a.introtext as atext,a.images as images, c.alias as catalias, c.title as ctitle
from #__content as a
join #__categories as c on c.id = a.catid
where a.state = 1 and a.created_by = "'.$userId.'"
';

$db->setQuery($query);
$rows = $db->loadObjectList(); ?>


<?php foreach ($rows as $row) {
	
$rowslug = $row->aid.':'.$row->aailas;
$rowcatslug = $row->catid.':'.$row->catalias;
$link = JRoute::_(ContentHelperRoute::getArticleRoute($rowslug, $rowcatslug));
$clink = JRoute::_(ContentHelperRoute::getCategoryRoute($row->catid));
$img_param = json_decode($row->images);
$img = $img_param->image_intro;?>

	<div class="my-firma">
		<div class="padding">
			<div class="col_img">
			<a href="<?php echo $link ?>">
				<img class="lazy" src="<?php echo $img ?>" width="80" height="70" />
			</a>
			</div
			><div class="col_info">
			<h3><a href="<?php echo $link ?>"><?php echo $row->atitle?></a></h3>
			<div class="mini_icons">
				<div class="ic">
					<i class="fa fa-eye"></i>
					<?php echo $row->hits ?>
				</div>
				<div class="ic">
					<i class="fa fa-comments"></i>
					<?php
						$comments = JPATH_SITE . '/components/com_jcomments/jcomments.php';
						if (file_exists($comments)) {
						require_once($comments);
						$options = array();
						$options['object_id'] = $row->aid;
						$options['object_group'] = 'com_content';
						$options['published'] = 1;
						$count = JCommentsModel::getCommentsCount($options);
						echo $count ? ''. $count . '' : '0';
					} ?>
				</div>
				<div class="ic_cat">
					<a href="<?php echo $clink?>"><?php echo $row->ctitle ?></a>
				</div>			
			</div>
			<div class="edit_block">
				<div class="edit_button">
					<a href="<?php echo $link ?>#edit"><i class="fa fa-pencil-square-o"></i> Редактировать</a>
				</div>
				<div class="delete_button">
					<a href="<?php echo $link ?>#delete"><i class="fa fa-trash-o"></i> Удалить</a>
				</div>	
			</div>
			</div>
		</div>
	</div>

<?php } ?>
    </section> 
 
</div>

<div class="">
	<?php //echo RSFormProHelper::displayForm('26'); // обратная связь ?>
</div>


<script type="text/javascript">
jQuery(document).ready(function(){
  jQuery('.history').click(function(){
    if (jQuery(this).next('.old_history').css("display")=="none") {
        jQuery('.old_history').hide('normal');
        jQuery(this).next('.old_history').fadeToggle('normal');
    }
    else jQuery('.old_history').hide('normal');
    return false;
 }); 
 });
</script>
