<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
global $Itemid;
if (!empty($newitemid))
$Itemid = $newitemid;
echo $intro_article; 
?>

<div class="dob0">
<form action="<?php echo $action_url; ?>" method="post" name="adminForm" class="form-valid2ate" novalidate="novalidate">
<div class="dob1" id="dob1">
<div class="op_inner">


<h2>Ваш заказ</h2>
<div id="top_basket_wrapper">
<?php
echo $op_basket;
echo $op_coupon; 
echo $html_in_between;
echo $google_checkout_button; 
?>

<?php
if (!empty($paypal_express_button)) { ?>
<div id="op_paypal_express" style="float: right; clear: both; width: 100%; padding-top: 10px;">
 <?php echo $paypal_express_button; ?>
</div>
<?php } 


if (!empty($checkoutAdvertises)) {
?>
<div id="checkout-advertise-box">
		<?php
		if (!empty($checkoutAdvertises)) {
			foreach ($checkoutAdvertises as $checkoutAdvertise) {
				?>
				<div class="checkout-advertise">
					<?php echo $checkoutAdvertise; ?>
				</div>
				<?php
			}
		}
		?>
	</div>
<?php } ?>
</div>

<?php $iter = 0;
if (empty($no_login_in_template)) {?>
   
<?php if (VM_REGISTRATION_TYPE != 'NO_REGISTRATION') { ?>
<div id="tab_selector">
</div>
	<div>
		<div>
			<div id="logintab" style="display: none;">
			<div>
				<input type="text" placeholder="<?php echo OPCLang::_('COM_VIRTUEMART_USERNAME'); ?>" id="username_login" name="username_login" value="" class="inputbox" size="20"  autocomplete="off" />
			</div>
			
			<div class="formField">
				
				<input type="password" placeholder="<?php echo OPCLang::_('COM_VIRTUEMART_SHOPPER_FORM_PASSWORD_1'); ?>" id="passwd_login" name="<?php 
				if ((version_compare(JVERSION,'1.7.0','ge')) || (version_compare(JVERSION,'2.5.0','ge'))) echo 'password';
				else echo 'passwd'; 
				?>" value="" class="inputbox" size="20" onkeypress="return submitenter(this,event)"  autocomplete="off" />
				

				
			</div>

	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>

	<div>	<label for="remember_login"><?php echo OPCLang::_('JGLOBAL_REMEMBER_ME'); ?></label></div>
	<div>
	<input type="checkbox" name="remember" id="remember_login" value="yes" checked="checked" />
	</div>
	
	<?php else : ?>
	<input type="hidden" name="remember" value="yes" />
	<?php endif; ?>
	<div style="width: 100%;">
	<span style="float: left;">
	(<a title="<?php echo OPCLang::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD');; ?>" href="<?php echo $lostPwUrl =  JRoute::_( 'index.php?option='.$comUserOption.'&view=reset' ); ?>"><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?></a>)
	</span>
	<input type="button" name="LoginSubmit" class="op_login_button" value="<?php echo OPCLang::_('COM_VIRTUEMART_LOGIN'); ?>" onclick="javascript: return op_login();"/>
	
	<input type="hidden" name="return" value="<?php echo $return_url; ?>" />
	<input type="hidden" name="<?php echo OPCUtility::getToken(); ?>" value="1" />

			</div>
			</div>
		</div>
	</div>
<?php } ?>  
	 
<?php } ?>
<?php if (!empty($registration_html)) {?>
<h2>Регистрация</h2>
<div class="cart_title_info">
Если Вы уже зарегистрированы, Вам необходимо <a class="button" href="#login"><span class="mif-lock"></span> Войти</a>
</div>

<div class="col2">
	<div class="blocks_cart">
		<h4><i class="fa fa-user-plus"></i> Данные для входа</h4>
		<div class="col2_info">
			Укажите данные для входа на сайт. Используя эти данные, Вы сможете в будущем попасть в личный кабинет
		</div>
		<?php echo $registration_html;  ?>
	</div>
</div>
<?php } ?>
<div class="col2">
	<div class="blocks_cart">
	<h4><i class="fa fa-map-marker"></i> Адрес для доставки заказа</h4>
		<div class="col2_info">
			Укажите данные для доставки заказа и связи с Вами. Мы свяжемся с Вами для уточнения подробностей доставки
		</div>	
	<?php echo $op_userfields; ?>
	</div>
</div>
</div>
</div>
<div class="dob2" id="dob2">
<div class="op_inner">


<div class="op_inside" <?php if (!empty($no_shipping) || ($shipping_inside_basket)) echo 'style="display: none;"'; ?>>
<div class="col2">
	<div class="blocks_dostavka">
		<h4><i class="fa fa-rouble"></i> Выберите способ оплаты</h4>
		<div class="col2_info">
			Выберите, наиболее удобный для Вас, способ оплаты заказа.
		</div>			
			<?php $op_payment = str_replace('<br />', '', $op_payment); 
			echo $op_payment; ?>
	</div>	
</div>	
<div class="col2">
	<div class="blocks_dostavka">	   
		<?php if ((empty($no_shipping)) && (empty($shipping_inside_basket))) { 
		$iter++;?>
		<h4><i class="fa fa-truck"></i> Выберите способ доставки</h4>
		<div class="col2_info">
			Выберите, наиболее удобный для Вас, способ доставки товара.
		</div>			
		<?php } ?>	
	
		<div id="ajaxshipping">
			<?php echo $shipping_method_html;?>
		</div>
	</div>
</div>

<?php if (!empty($delivery_date)) { 
$iter++; ?> 
<h4></h4>
<?php echo $delivery_date;  ?>
<?php } ?>	

</div>



<!-- end payment method -->
</div>
<div class="dob3" id="dob3">

<div class="op_inner">
<h2>Подтверждение заказа</h2>
<div class="col2">
	<div class="blocks_dostavka">
	<h4><i class="fa fa-rouble"></i> Сумма заказа</h4>
		<div class="itogo">
		<div id="totalam">
		<div id="tt_order_subtotal_div"><span id="tt_order_subtotal_txt" class="bottom_totals_txt"></span><span id="tt_order_subtotal" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_order_payment_discount_before_div"><span id="tt_order_payment_discount_before_txt" class="bottom_totals_txt"></span><span class="bottom_totals" id="tt_order_payment_discount_before"></span><br class="op_clear"/></div>
		<div id="tt_order_discount_before_div"><span id="tt_order_discount_before_txt" class="bottom_totals_txt"></span><span id="tt_order_discount_before" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_shipping_rate_div"><span id="tt_shipping_rate_txt" class="bottom_totals_txt"></span><span id="tt_shipping_rate" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_shipping_tax_div"><span id="tt_shipping_tax_txt" class="bottom_totals_txt"></span><span id="tt_shipping_tax" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_tax_total_0_div"><span id="tt_tax_total_0_txt" class="bottom_totals_txt"></span><span id="tt_tax_total_0" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_tax_total_1_div"><span id="tt_tax_total_1_txt" class="bottom_totals_txt"></span><span id="tt_tax_total_1" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_tax_total_2_div"><span id="tt_tax_total_2_txt" class="bottom_totals_txt"></span><span id="tt_tax_total_2" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_tax_total_3_div"><span id="tt_tax_total_3_txt" class="bottom_totals_txt"></span><span id="tt_tax_total_3" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_tax_total_4_div"><span id="tt_tax_total_4_txt" class="bottom_totals_txt"></span><span id="tt_tax_total_4" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_order_payment_discount_after_div"><span id="tt_order_payment_discount_after_txt" class="bottom_totals_txt"></span><span id="tt_order_payment_discount_after" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_order_discount_after_div"><span id="tt_order_discount_after_txt" class="bottom_totals_txt"></span><span id="tt_order_discount_after" class="bottom_totals"></span><br class="op_clear"/></div>
		<div id="tt_genericwrapper_bottom" class="dynamic_lines_bottom" style="display: none;"><span class="bottom_totals_txt dynamic_col1_bottom">{dynamic_name}</span><span class="bottom_totals dynamic_col2_bottom">{dynamic_value}</span><br class="op_clear"/></div>
		<div id="tt_total_div"><span id="tt_total_txt" class="bottom_totals_txt"></span><span id="tt_total" class="bottom_totals"></span><br class="op_clear"/></div>
		</div>
		<div class="op_hr" >&nbsp;</div>
		</div>
	</div>
</div>
<div class="col2">
	<div class="blocks_dostavka">
	<h4><i class="fa fa-comments-o"></i> Комментарий к заказу</h4>
	<div class="col2_info">
		
	</div>
		<span id="customer_note_input" class="">
			<textarea rows="3" cols="30" name="customer_comment" id="customer_note_field" placeholder="Введите текст комментария к заказу (если это необходимо)"></textarea>
		</span>
	</div>
</div>

<div id="rbsubmit" style="width: 100%;">
<div id="onepage_info_above_button">
<div id="onepage_total_inc_sh">

</div>
 
<?php
	if(OPCLang::_('COM_VIRTUEMART_AGREEMENT_TOS')){
		$agreement_txt = OPCLang::_('COM_VIRTUEMART_AGREEMENT_TOS');
	}

if ($show_full_tos) { ?>
<!-- show full TOS -->
	
<?php echo $tos_con; ?>
<!-- end of full tos -->
<?php } 
	
if ($tos_required)
{

{

?>
	<div id="agreed_div" class="formLabel fullwidth" style="display:block; text-align: left;">
	<div class="left_checkbox">
	<input value="1" type="checkbox" id="agreed_field"  name="tosAccepted" <?php if (!empty($agree_checked)) echo ' checked="checked" '; ?> class="terms-of-service" <?php if (VmConfig::get('agree_to_tos_onorder', 1)) echo ' required="required" '; ?> autocomplete="off" />
    </div>
	<div class="right_label">
					<label for="agreed_field"><?php echo OPCLang::_('COM_VIRTUEMART_I_AGREE_TO_TOS'); 
					if (!empty($tos_link))
					{
					JHTMLOPC::_('behavior.modal', 'a.opcmodal'); 
					?><a target="_blank" rel="{handler: 'iframe', size: {x: 500, y: 400}}" class="opcmodal" href="<?php echo $tos_link; ?>" onclick="javascript: return op_openlink(this); " ><br />
					<?php 
					$text = OPCLang::_('COM_VIRTUEMART_CART_TOS'); 
					$text = trim($text); 
					if (!empty($text))
					{
					?>
					(<?php echo OPCLang::_('COM_VIRTUEMART_CART_TOS'); ?>)
					<?php 
					}
					?>
					</a><?php } ?></label>
		</div>		
		
	</div>
	<div class="formField" id="agreed_input">
	<?php echo $italian_checkbox; ?>
</div>


<?php
}

}
?>

</div>
</div>
</div>
<div class="bottom_button">
 <div id="payment_info"></div>
	<button id="confirmbtn_button" type="submit" <?php echo $op_onclick ?>  ><h4 id="confirmbtn"><i class="fa fa-check-square-o"></i> <?php echo OPCLang::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU') ?></h4></button>
 </div>
</div>
<?php echo $captcha;?> 

</form>
</div>
<div id="tracking_div"></div>

<script type="text/javascript">
addOpcTriggerer('callAfterRender', 'resetHeight()'); 
</script>
</div>
