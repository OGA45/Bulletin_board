<?
ob_start();
session_start();
unset($_SESSION['auth']);
header('Location: top.php');
?>