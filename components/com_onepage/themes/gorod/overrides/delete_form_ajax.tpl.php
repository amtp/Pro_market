<?php
if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' ); 
?>
<a class="deletebtn" title="<?php echo OPCLang::_('COM_VIRTUEMART_CART_DELETE'); 
?>" href="#" rel="<?php echo $product->cart_item_id;
?>"><i class="fa fa-trash-o"></i></a>