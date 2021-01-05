<?php
$parser = file_get_contents('http://www.nbrb.by/API/ExRates/Rates?Periodicity=0');
$kurs_rb = json_decode($parser);
?>