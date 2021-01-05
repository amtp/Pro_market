<?php if( !defined( '_VALID_MOS' ) && !defined( '_JEXEC' ) ) die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
mm_showMyFileName(__FILE__); 
$html = '';

foreach ($shipping_methods_array as $ship)
{
$html .= "<input type=\"radio\" id=\"".$ship['idth']."\"  name=\"shipping_rate_id\" value=\"" . urlencode($ship['value']) . "\" onclick=\"javascript:changeTextOnePage3(op_textinclship, op_currency, op_ordertotal);\"" ;
	if ($ship['idth'] == $selected_idth)
	$html .= "checked=\"checked\"" ;
	$html .= " />";
	$html .= "<label for=\"".$ship['idth']. "\">" . $ship['name'] . "</label>" ;
				//$html .= "<td>" . $ship['price'] . "</td></tr>\n" ;
			
		
}


echo $html;
?>