<?php define( '_JEXEC', 1 );
if ( file_exists( __DIR__ . '/defines.php' ) ) {
    include_once __DIR__ . '/defines.php';
}
if ( !defined( '_JDEFINES' ) ) {
    define( 'JPATH_BASE', __DIR__ );
    require_once JPATH_BASE . '/includes/defines.php';
}
require_once JPATH_BASE . '/includes/framework.php';

?>
<?php
$test = '0'; //Тестирование системы: 0 - выключено, 1 - включено

$notification_secret = "4R7Hhae1B+WR7YeKdaNat5JG"; //СЮДА ВСТАВИТЬ Секретный код выданый ВАМ ЯД

$notification_type = $_POST["notification_type"]; 
$operation_id = $_POST["operation_id"];
$amount = $_POST["amount"];
$currency = $_POST["currency"];
$datetime = $_POST["datetime"];
$sender = $_POST["sender"];
$codepro = $_POST["codepro"];
$label = $_POST["label"];
$sha1_hash = $_POST["sha1_hash"];
$test_notification = $_POST["test_notification"];

$hash = $notification_type . '&' . $operation_id . '&' . $amount . '&' . $currency . '&' . $datetime . '&' . $sender . '&' . $codepro . '&' . $notification_secret . '&' . $label; //формируем хеш

$sha1 = hash("sha1", $hash); //кодируем в SHA1

//Ниже - проверка на валидность
if ( $sha1 == $sha1_hash ) {
	$db = JFactory::getDbo();
	$label = $_POST['label'];
	$lab = '{'. $label .'}';
	$js = json_decode($lab);
	$user_id = $js->user_id;
	$summa = $js->summa;
	$p_id = $operation_id;
	//$s = $js->s;
	//$u_id = $js->u;
	//$h = $js->h;
	//$v = $js->v;
	//$s = $js->s;
	
	$date = $datetime; 
    $dd = new DateTime($date);
    $data_end = $dd->format("Y-m-d G:i:s");
	
	$db->setQuery("SELECT `balans` FROM #__users WHERE `id` = '$user_id'");
	$sum_old = $db->loadResult();
	$summa_new	= $sum_old + $summa;
	
	$db->setQuery("UPDATE `#__users` SET `balans`='$summa_new' WHERE `id`= '$user_id'");
	$db->query();		
	
	$db->setQuery("INSERT INTO #__history_pay (pay_id, pay_data, pay_name, pay_summa, user_id) VALUES ('$p_id','$data_end','Пополнение баланса','+$summa','$user_id')");
	$db->query();
	
} else {
echo 'error';
}
// Ниже - отладка - запись в файл testlog.txt переданых данных с ЯД.
if ($test=='1') {
$test_wr = fopen ('testlog.txt', 'a+');
fwrite ($test_wr, "$notification_type - тип нотификации\r\n$operation_id - ид операции\r\n$amount - сумма\r\n$currency -Код валюты\r\n$datetime - дата+время\r\n$sender -отправитель\r\n$codepro - наличие кода протекции\r\n$label - метка платежа\r\n$sha1_hash - переданый проверочный хеш\r\n$sha1 - расчитаный хэш\r\n$test_notification - тестовая нотификация\r\n");
fclose ($test_wr);
}
 ?>  