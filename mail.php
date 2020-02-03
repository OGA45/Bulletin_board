<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");
$to = "matui2000.1124@gmail.com";
$subject = "テスト";
$message = "おはよう！\r\nテストです！";
$headers = "From:OGA@dev2.m-fr.net";
 
mb_send_mail($to,$subject,$message,$headers);
?>