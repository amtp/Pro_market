<?php
/* 
*
* @copyright Copyright (C) 2007 - 2012 RuposTel - All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* One Page checkout is free software released under GNU/GPL and uses code from VirtueMart
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* 
* This loads before first ajax call is done, this file is called per each shipping html generated
*/
defined('_JEXEC') or die('Restricted access');

// local variables are defined in \components\com_onepage\helpers\transform.php
// $vm_id, $html (is the original output)

$dispatcher = JDispatcher::getInstance();

$result = ''; 
$method = new stdClass(); 

$returnValues = $dispatcher->trigger('getPluginHtmlOPC', array(&$result, &$method, 'shipment', $vm_id, $cart));

$def_html = $result; 


$zas = VmModel::getModel('zasilkovnaopc'); 
if (!empty($zas))
{
$json = $zas->getBranchesJson($method); 
}


$address = (($cart->ST == 0) ? $cart->BT : $cart->ST);

$country_id = $address['virtuemart_country_id']; 



$country = $method->country; 
if (is_array($country)) $country = reset($country); 
		$isSk = true; 
		
		$db = JFactory::getDBO(); 
		$q = 'select virtuemart_country_id from #__virtuemart_countries where country_3_code = "CZE" limit 1'; 
		$db->setQuery($q); 
		$cz_id = $db->loadResult(); 
		$q = 'select virtuemart_country_id from #__virtuemart_countries where country_3_code = "SVK" limit 1'; 
		$db->setQuery($q); 
		$sk_id = $db->loadResult(); 
		
	    if (empty($country_id)) $isSk = true; 
		if (empty($sk_id) && (!empty($country_id))) $isSk = false; 
		if (empty($sk_id) && (empty($country_id))) $isSk = true; 
		if (empty($country_id) || ($country_id == $sk_id)) $isSk = true; 
		else $isSk = false; 
	
	    $isCz = true; 
	    if (empty($country_id)) $isCz = true; 
	   
		if (empty($cz_id) && (!empty($country_id))) $isCz = false; 
		if (empty($cz_id) && (empty($country_id))) $isCz = true;  
		if (empty($country_id) || ($country_id == $cz_id)) $isCz = true;  
		else $isCz = false; 
		
		
//if (($isSk && ($country == 'sk')) || ($isCz && ($country == 'cz'))) 	
if ((($isSk && (in_array('sk', $method->country))) || ($isCz && (in_array('cz', $method->country)))))
{ 


if (!empty($json))
{
$extra = '';
$sel = ''; 
//$sel .= var_export($isSk, true).var_export($isCz, true); 
$sel .= '<select class="zasielka_select" name="branch" onchange="opc_zas_change'.$vm_id.'(this, '.$vm_id.');" id="branchselect_'.$vm_id.'">';
if ($isCz) 
$sel .= '<option data-branch-id="" value="">–– vyberte si místo osobního odběru ––</option>';
else
$sel .= '<option data-branch-id="" value="">–– vyberte si miesto osobného odberu ––</option>';




if (!empty($json->data))
foreach ($json->data as $branch)
{
if (!isset($branch->id)) continue; 
  // if ($branch->country == 'cz') $country = 'ČR'; 
  $cc = $branch->country; 
  if (!empty($method->country))
  if (!in_array($cc, $method->country)) 
  {
    continue; 
  }
  $country = $json->countries->$cc; 
  
   
  
  
  if (($cc == 'cz') && (!$isCz)) continue; 
  if (($cc == 'sk') && (!$isSk)) continue; 
  
  $sel .= '<option data-branch-id="'.htmlentities($branch->id, ENT_COMPAT, 'utf-8').'" value="'.htmlentities($branch->id, ENT_COMPAT, 'utf-8').'">'.htmlentities($country.', '.$branch->nameStreet, ENT_COMPAT, 'utf-8').'</option>'; 

  
  
//extra:

$extra .= '
<div class="zasielka_div1" style="padding-top: 8px; clear:both;display: none;" id="zas_branch_'.$branch->id.'">
 <div class="zas_image" style="float: left; max-width: 50%; margin:0; padding:0;">
  <a class="opcmodal" rel="{handler: \'iframe\', size: {x: 500, y: 400}}" href="'.$branch->photos[0]->normal.'">
  <img style="border:1px solid black; margin-right: 8px; float: left; " src="'.str_replace('http:', '', $branch->photos[0]->thumbnail).'" width="160" height="120" alt="" />
  </a>
 </div>
<div class="zasielka_div2"  style="float: left; clear:right; max-width: 50%;margin:0; padding:0;">
  <strong>'.htmlentities($branch->place, ENT_COMPAT, 'utf-8').'</strong><br/>'; 
  $extra .= htmlentities($branch->street, ENT_COMPAT, 'utf-8').'<br/>'; 
  $extra .= htmlentities($branch->zip, ENT_COMPAT, 'utf-8').' '; 
  $extra .= htmlentities($branch->city, ENT_COMPAT, 'utf-8').'<br />'; 
  if (!empty($branch->openingHours) && (is_string($branch->openingHours->compactLong)))
  {
  $extra .= '<div style="margin-top: 8px;">
              <div style="float: left; clear:both;">
			    <em style="clear: both;">Otevírací doba:</em>
			  </div>
			  <br style="clear:both;"/>'; 
  $extra .= $branch->openingHours->compactLong.'</div>'; 
  }
  else 
  {

  }
  $extra .= '</div>'; 
 
 $extra .= '</div> '; 
 
 /*
 $extra .= '<input type="hidden" name="branch_id'.$branch->id.'" id="branch_id'.$branch->id.'" value="'.htmlentities($branch->id).'" />'; 
 $extra .= ' <input type="hidden" name="branch_currency'.$branch->id.'" id="branch_currency'.$branch->id.'" value="'.htmlentities($branch->currency) .'" />'; 
 $extra .= ' <input type="hidden" name="branch_name_street'.$branch->id.'" id="branch_name_street'.$branch->id.'" value="'.htmlentities($branch->nameStreet).'"/>';
  */
  
  $na = array(); 
  $na['branch_id'] = $branch->id; 
  $na['branch_name_street'] = $branch->nameStreet; 
  $na['branch_currency'] = $branch->currency; 
  $data = json_encode($na); 
  
  
  $newjson = '<input type="hidden" name="zasilkovna_shipment_id_'.$vm_id.'_'.$branch->id.'_extrainfo" value="'.base64_encode($data).'" />'; 
  
  $md5 = md5($newjson); 
  OPCloader::$inform_html[$md5] = $newjson; 
  
  // end json foreach 
}

$sel .= '</select>'; 
$sel .= $extra;


$post = ''; 
if (!defined('ZAS_ONCE'))
{
$post = '<input type="hidden" name="branch_id" id="branch_id" value="" />
        <input type="hidden" name="branch_currency" id="branch_currency" value="" />
        <input type="hidden" name="branch_name_street" id="branch_name_street" value="" />'; 

define('ZAS_ONCE', 1); 
}


/*
if (strpos($def_html, 'id="shipment_id_'.$vm_id.'"')===false)
{
$def_html = str_replace('name="virtuemart_shipmentmethod_id"', ' name="virtuemart_shipmentmethod_id" id="shipment_id_'.$vm_id.'" ', $def_html); 



}
$def_html = str_replace('value="'.$vm_id.'"', 'value="'.htmlentities($vm_id.'|choose_shipping"'), $def_html); 
*/


include(JPATH_ROOT.DIRECTORY_SEPARATOR.'components'.DIRECTORY_SEPARATOR.'com_onepage'.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'onepage.cfg.php'); 

//if (empty($shipping_inside_choose))
//$def_html = str_replace('value="'.$vm_id.'"', 'value="'.htmlentities($vm_id.'|choose_shipping"'), $def_html); 
$ex = ''; 



//$html = $def_html.'<input type="radio" name="virtuemart_shipmentmethod_id" id="zas_vm_'.$vm_id.'" value="'.$vm_id.'"><div id="opc_zas_place">&nbsp;</div>'.$sel.$ex.$post; 
$html = '
   <div class="zasilkovina_output">
    <div style="clear: both;">'.$def_html.'
	   <div id="opc_zas_place" style="clear: both;">&nbsp;
	   </div>
	      <div for="shipment_id_'.$vm_id.'">'.$sel.'
	      </div>'.$ex.$post.'
	</div>
   </div>'; 


}


}
else
{
 
}

