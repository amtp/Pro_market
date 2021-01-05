<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
?>
				<a class="updatebtn" title="<?php echo OPCLang::_('COM_VIRTUEMART_CART_UPDATE'); 
?>" href="#" rel="<?php echo $product->cart_item_id.'|'.md5($product->cart_item_id); ;
?>"><i class="fa fa-refresh"></i></a>
				<input type="text" title="<?php echo OPCLang::_('COM_VIRTUEMART_CART_UPDATE'); ?>" class="inputbox opcquantity" size="3" name="quantity" id="quantity_for_<?php echo md5($product->cart_item_id); ?>" value="<?php echo $product->quantity; ?>" />
				
				
				
				
				
				
				
				
			 