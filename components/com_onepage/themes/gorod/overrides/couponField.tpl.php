<?php 
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
?>

<div class="coupon_section">
<?php

// If you have a coupon code, please enter it here:
echo $this->coupon_text . '<br />';
?>  
	    !!!<form action="<?php echo JRoute::_('index.php'); ?>" method="post" onsubmit="return checkCouponField(this);" id="userForm">
			<div class="coupon_input_section">
			 <div class="before_input"></div><div class="middle_input">
			 <input type="text" name="coupon_code" autocomplete="off" id="coupon_code" class="inputbox" />
			 <div class="after_input">&nbsp;</div></div>
			</div>
			<input type="hidden" name="Itemid" value="<?php echo @intval($_REQUEST['Itemid'])?>" />
			 <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="view" value="cart" />
    <input type="hidden" name="task" value="setcoupon" />
    <input type="hidden" name="controller" value="cart" />
			<input type="submit" value="<?php echo OPCLang::_('COM_VIRTUEMART_SAVE'); ?>" class="coupon_button" />
		</form>		
<script type="text/javascript">
function checkCouponField(form) {
	if(form.coupon_code.value == '') {
		new Effect.Highlight('coupon_code');
		return false;
	}
	return true;
}
</script>
</div>
<br style="clear: both;" />