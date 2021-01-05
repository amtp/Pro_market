<?php
	$date = date("d/m/Y"); // Текущая дата
	$content = simplexml_load_file("https://www.cbr.ru/scripts/XML_daily.asp?date_req=".$date);
	
	foreach($content->Valute as $cur) { 
		if($cur->NumCode == 840) { $usd = str_replace(",", ".", $cur->Value); } // Доллар США
		if($cur->NumCode == 978) { $euro = str_replace(",", ".", $cur->Value); } // Евро
		if($cur->NumCode == 156) { $CNY = str_replace(",", ".", $cur->Value); } // Юань

	} 
	$tommorow = date('d/m/Y', time() - 86400);
	
	$content1 = simplexml_load_file("https://www.cbr.ru/scripts/XML_daily.asp?date_req=".$tommorow);
	
	foreach($content1->Valute as $cur1) { 
		if($cur1->NumCode == 840) { $usd_old = str_replace(",", ".", $cur1->Value); } // Доллар США
		if($cur1->NumCode == 978) { $euro_old = str_replace(",", ".", $cur1->Value); } // Евро
		if($cur1->NumCode == 156) { $CNY_old = str_replace(",", ".", $cur1->Value); } // Юань

	} 
?>
