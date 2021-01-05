<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
?>

<div id="basket_container">
<div class="inside">
<div class="black-basket">
    <div class="col-module_fix" >                                      
    <div class="col-module_content" style="width: 100%;">
                         
<div class="top_cart">
  <div class="op_basket_header op_basket_row">
    <div class="op_col1">&nbsp;</div>
	<div class="op_col2"><?php echo OPCLang::_('COM_VIRTUEMART_CART_NAME') ?></div>
    <!--<div class="op_col4"><?php //echo OPCLang::_('COM_VIRTUEMART_CART_SKU') ?></div>-->
    <div class="op_col6">Количество</div>
	<div class="op_col5"><?php echo OPCLang::_('COM_VIRTUEMART_CART_PRICE') ?></div>
    <div class="op_col7">Итого</div>
  </div>
	<?php $max = count($product_rows); 
	$curr = 0; 
foreach( $product_rows as $product ) { 

 $curr++;
?>
  <div class="op_basket_row <?php 
    if (($max) != $curr)
	 {
	   echo ' special_color'; 
	   
	 }
  ?>">
	<div class="op_col1">
		<?php echo $this->op_show_image($product['product_full_image'], '', 100, 100, 'product'); ?>
	</div> 
    <div class="op_col2_2"><?php echo $product['product_name'] . $product['product_attributes'] ?></div>
    <!--<div class="op_col4"><?php echo $product['product_sku'] ?></div>-->
    <div class="op_col6"><?php echo $product['update_form'] ?>
		<?php echo $product['delete_form'] ?></div>
    <div class="op_col5"><?php echo $product['product_price'] ?> </div>
    <div class="op_col7"><?php echo $product['subtotal'] ?> </div>
  </div>
<?php } ?>
</div>
<!--Begin of SubTotal, Tax, Shipping, Coupon Discount and Total listing -->
<?php if (!empty($shipping_inside_basket))
{
?>
<div class="col2">
  <div class="op_basket_row" style="padding-bottom: 4px;">
    <div class="op_title">Выберите один из способов доставки</div>
    <div class="op_col2_3">
		<div id='shipping_inside_basket'><?php if (!empty($shipping_select)) echo $shipping_select; ?></div>
	</div>
	<div class="total_shiping">Стоимость доставки</div>
    <div class="op_col5_3" id="shipping_inside_basket_cost">&nbsp;</div>
  </div>
</div>
<?php
}
if (!empty($payment_inside_basket))
{
?>
<div class="col2">
  <div class="op_basket_row">
    <div class="op_title">Выберите один из способов оплаты</div>
    <div class="op_col2_3"><?php echo $payment_select; ?></div>
    <div class="op_col5_3">&nbsp;<span id='payment_inside_basket_cost'></span></div>
  </div>
</div>
 
<?php
}
?>
<?php 
if (false)
{
// this will show product subtotal with tax, remove if(false)
?>
<div class="op_basket_row totals" id="tt_static_total_div_basket" >
    <div class="op_col1_4"   id="tt_total_basket_static2"><?php echo OPCLang::_('COM_VIRTUEMART_CART_SUBTOTAL') ?>:</div>
	<div class="op_col5_3" id="tt_order_subtotal_basket2">
	<?php 
	$product_subtotal = $totals_array['order_subtotal']+$totals_array['order_tax']; 
	echo $GLOBALS['CURRENCY_DISPLAY']->getFullValue($product_subtotal); ?>
	</div>
</div>
<?php
}
?>

<div style="display: none;">
  <div class="op_basket_row totals" id="tt_order_subtotal_div_basket" >
    <div class="op_col1_4" id="tt_order_subtotal_txt_basket"><?php echo OPCLang::_('COM_VIRTUEMART_CART_SUBTOTAL') ?>:</div>
	<div class="op_col5_3" id="tt_order_subtotal_basket"><?php echo $subtotal_display ?></div>
  </div>


  <div class="op_basket_row totals" style="display: none;" id="tt_order_payment_discount_before_div_basket">
    <div class="op_col1_4" id="tt_order_payment_discount_before_txt_basket">:
    </div> 
    <div class="op_col5_3" id="tt_order_payment_discount_before_basket"></div>
  </div>

  
  <div class="op_basket_row totals" style="display: none;" id="tt_order_payment_discount_after_div_basket">
    <div class="op_col1_4" id="tt_order_payment_discount_after_txt_basket">:
    </div> 
    <div class="op_col5_3"   id="tt_order_payment_discount_after_basket"></div>
  </div>
  
  <div class="op_basket_row totals" <?php if (empty($coupon_display_before)) echo ' style="display: none;" '; ?> id="tt_order_discount_before_div_basket">
    <div class="op_col1_4"  ><?php echo OPCLang::_('COM_ONEPAGE_OTHER_DISCOUNT') ?>:
    </div> 
    <div class="op_col5_3"   id="tt_order_discount_before_basket"><?php echo $coupon_display_before; ?></div>
  </div>
  <div class="op_basket_row totals" id="tt_shipping_rate_div_basket" <?php if (($no_shipping == '1') || (!empty($shipping_inside_basket)) || (empty($order_shipping))) echo ' style="display:none;" '; ?>>
	<div class="op_col1_4"  ><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING') ?>: </div> 
	<div class="op_col5_3"   id="tt_shipping_rate_basket"><?php echo $order_shipping; ?></div>
  </div>
  <div class="op_basket_row totals" <?php if (empty($discount_after)) echo ' style="display:none;" '; ?> id="tt_order_discount_after_div_basket">
    <div class="op_col1_4"  ><?php echo OPCLang::_('COM_VIRTUEMART_COUPON_DISCOUNT') ?>:
    </div> 
    <div class="op_col5_3"   id="tt_order_discount_after_basket"><?php echo $coupon_display ?></div>
  </div>
  <div class="op_basket_row totals"  id="tt_tax_total_0_div_basket" style="display:none;" >
        <div class="op_col1_4"   id="tt_tax_total_0_txt_basket"><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL_TAX') ?>: </div> 
        <div class="op_col5_3"   id="tt_tax_total_0_basket"><?php echo $tax_display ?></div>
  </div>
  <div class="op_basket_row totals" id="tt_tax_total_1_div_basket" style="display:none;" >
        <div class="op_col1_4"   id="tt_tax_total_1_txt_basket"><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL_TAX') ?>: </div> 
        <div class="op_col5_3"   id="tt_tax_total_1_basket"><?php echo $tax_display ?></div>
  </div>
  <div class="op_basket_row totals"  id="tt_tax_total_2_div_basket" style="display:none;" >
        <div class="op_col1_4"   id="tt_tax_total_2_txt_basket"><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL_TAX') ?>: </div> 
        <div class="op_col5_3"   id="tt_tax_total_2_basket"><?php echo $tax_display ?></div>
  </div>
  <div class="op_basket_row totals" id="tt_tax_total_3_div_basket" style="display:none;" >
        <div class="op_col1_4"   id="tt_tax_total_3_txt_basket"><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL_TAX') ?>: </div>
        <div class="op_col5_3"   id="tt_tax_total_3_basket"><?php echo $tax_display ?></div>
  </div>
  <div class="op_basket_row totals" id="tt_tax_total_4_div_basket" style="display:none;" >
        <div class="op_col1_4"   id="tt_tax_total_4_txt_basket"><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL_TAX') ?>: </div>
        <div class="op_col5_3"   id="tt_tax_total_4_basket"><?php echo $tax_display ?></div>
  </div>
  
  <div class="op_basket_row totals dynamic_lines"  id="tt_genericwrapper_basket" style="display: none;">
        <div class="op_col1_4 dynamic_col1"   >{dynamic_name}: </div>
        <div class="op_col5_3 dynamic_col2"   >{dynamic_value}</div>
  </div>
  
  <?php if (!empty($opc_show_weight_display)) { ?>
   <div class="op_basket_row totals"  id="tt_weight_div_basket" >
        <div class="op_col1_4"   ><?php echo OPCLang::_('COM_ONEPAGE_TOTAL_WEIGHT') ?>: </div>
        <div class="op_col5_3"   ><?php echo $opc_show_weight_display ?></div>
  </div>
  <?php } ?>
  <div class="opc_basket_sep">&nbsp;</div>
  <div class="op_basket_row totals" id="tt_total_basket_div_basket">
    <div class="op_col1_4"  ><?php echo OPCLang::_('COM_VIRTUEMART_ORDER_PRINT_TOTAL') ?>: </div>
    <div class="op_col5_3"   id="tt_total_basket"><strong><?php echo $order_total_display ?></strong></div>
  </div>
  <?php 
  if (!empty($continue_link)) { ?>
  <div class="op_basket_row totals">
    <div style="width: 100%; clear: both;">
  		 <a href="<?php echo $continue_link ?>" class="continue_link" ><span>
		 	<?php echo OPCLang::_('COM_VIRTUEMART_CONTINUE_SHOPPING'); ?></span>
		 </a>
	&nbsp;</div>
  </div>
  <?php } ?>

</div>
                         </div>
           </div>

</div>
</div>
</div>