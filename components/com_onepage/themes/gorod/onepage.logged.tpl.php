<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
$iter = 0;
?>
<div class="dob0 log">
<form action="<?php $action_url; ?>" method="post" name="adminForm" novalidate="novalidate">

<h2>Ваш заказ</h2>	
	<?php
	echo $intro_article; 
echo $op_basket; 
echo $op_coupon; 
//
echo $html_in_between; // from configuration file.. if you don't want it, just comment it or put any html here to explain how should a customer use your cart, update quantity and so on
if (!empty($checkoutAdvertises)) { ?>
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
<?php if (!empty($google_checkout_button)) { ?>
<div id="op_google_checkout" style="float: right; clear: both; width: 100%; padding-top: 10px;">
 <?php echo $google_checkout_button; 
 ?>
</div>
<?php } ?>
    <h2>Ваши данные</h2>
        <div class="cupon_section">	
			<?php echo $op_userfields; ?>
		</div>
        <?php if (NO_SHIPTO != '1') { ?>
        <?php } ?>
     
    <div class="dob2" id="dob2">
	
	<h2>Оплата и доставка</h2>
	<?php if ((empty($no_shipping)) && (empty($shipping_inside_basket))) {	?>
	<div class="col2">
		<div class="blocks_cart">
		<h4>Вы берите способ доставки</h4>
		<div class="col2_info">
			Выберите наиболее удобный для Вас способ доставки товара. Весь товар отправляется с полностью объявленной стоимостью.
		</div>			
	<?php } ?>
			<div id="ajaxshipping">
				<?php echo $shipping_method_html; // this prints all your shipping methods from checkout/list_shipping_methods.tpl.php ?>
			</div>
		</div>
	</div>

        <?php if (!empty($op_payment)) { ?>
<div class="col2">
	<div class="blocks_cart">
	<h4>Вы берите способ оплаты</h4>
		<div class="col2_info">
			Выберите наиболее удобный для Вас способ оплаты товара. Товар по России отправляется только по 100% предоплате
		</div>	
			<?php echo $op_payment; ?>		
	</div>
</div>	

<?php } ?>
</div>
   
<h2>Подтверждение заказа</h2>
<div class="col2">
	<div class="blocks_dostavka">
	<h4>Сумма заказа</h4>
<div id="onepage_total_inc_sh">
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
	<h4>Комментарий к заказу</h4>
	<div class="col2_info">
		Если к заказу необходимо указать какую-то важную деталь, пожалуйста, заполните это поле
	</div>
		<span id="customer_note_input" class="">
			<textarea rows="3" cols="30" name="customer_comment" id="customer_note_field" placeholder="Введите текст комментария к заказу (если это необходимо)"></textarea>
		</span>
	</div>
</div>
     
<div id="rbsubmit" style="width: 100%; float: right;">
    <div id="onepage_info_above_button">
<?php
if ($show_full_tos) {
 ?>

<?php echo $tos_con; ?>
<!-- end of full tos -->
<?php } 
if ($tos_required)
{

{

?>
	<div id="agreed_div" class="formLabel " style="display: block; text-align: left;">
	<input value="1" type="checkbox" id="agreed_field"  name="tosAccepted" <?php if (!empty($agree_checked)) echo ' checked="checked" '; ?> class="terms-of-service" <?php if (VmConfig::get('agree_to_tos_onorder', 1)) echo ' required="required" '; ?> autocomplete="off" />

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
	<div class="formField" id="agreed_input">
</div>


<?php
}

}
?>
 <div>
 <div id="payment_info"></div>
	<center><button id="confirmbtn_button" type="submit" <?php echo $op_onclick; ?> ><h4 id="confirmbtn"><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_CONFIRM_MNU') ?></h4></button></center>
 </div>
<br style="clear: both;"/>
</div>
	</div>   
  </div>

<?php
echo $captcha; 
?>
      
</form>
<div id="tracking_div"></div>
<script type="text/javascript">
addOpcTriggerer('callAfterRender', 'resetHeight()'); 
</script>

