<?php 
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );

?>
<div class="cupon_section">
<div style="width: 100%;" id="userForm">
	<div class="coupon_input_section">
		<input type="text" name="coupon_code" id="coupon_code" size="20" class="coupon" alt="<?php echo $this->coupon_text ?>" placeholder="Если у Вас есть купон на скидку, Вы можете ввести его в это поле..."  />
	</div>
    <div class="details-button">
		<input type="submit" value="Применить купон" class="coupon_button" onclick="return Onepage.setCouponAjax(this);" />
    </div>
	<div class="cupon_info">
		Если Вы применили действующий купон, скидка будет применена во время оформления заказа
    </div>
</div>
</div>		

