<?php
$mailto = "support@thegoodquote.app";

$subject = "[TheGoodQuote] ";

include '/home/fixaxeki/www/api.po3tic.info/crud.php';
$dbx = new Database();
$dbx->connect();

$sql_mail = "SELECT * FROM messages WHERE DATE(created_at) = DATE(NOW()) AND send = 0";

$dbx->sql($sql_mail);
$result = $dbx->getResult();

foreach ($result as $key => $val) {
	$mailfrom = $val['email'];
	$mailsubject = $subject . $val['category'];
	$mailmessage = $val['message'];
	$mailheaders = "FROM:" . $mailfrom . "\r\n" . "Reply-To:" . $mailfrom . "\r\n";
	
	if (mail($mailto, $mailsubject, $mailmessage, $mailheaders)) {

		$data = [
			'send' => "1",
		];

		$whereId = 'id="' . $val['id'] . '"';
		$resUpdate = $dbx->update('messages', $data, $whereId);
	} else {
		print_r(error_get_last());
	}
}
