<?php
//
$datum = [];
foreach(['name', 'seed', 'text'] as $s) {
  $datum[$s] = (string)@$_POST[$s];
}

// validate
if ( ('' === $datum['name'])||('' === $datum['text']) ){
  $h="index.php?id={$_GET['id']}&name={$_GET['name']}&sort={$_GET['sort']}";
  header('Location: '.$h);
  exit;
}
// else

  $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4","OGA","OGA",[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
	$stmt=$dbh->prepare('insert into keizi values (:name,:seed,:text,:times,:id)');
  $stmt->bindValue(':name', $datum['name'],PDO::PARAM_STR);
	$stmt->bindValue(':seed', $datum['seed'],PDO::PARAM_STR);
  $stmt->bindValue(':text', $datum['text'],PDO::PARAM_STR);
  $date = new DateTime();
  $date = $date->format('Y-m-d H:i:s');
  $stmt->bindValue(':times', $date,PDO::PARAM_STR);
  $stmt->bindValue(':id', $_GET["id"],PDO::PARAM_STR);
  $stmt->execute();
  $h="index.php?id=" . rawurlencode($_GET['id']) . "&name=" . rawurlencode($_GET['name']) . "&sort=" . rawurlencode($_GET['sort']);
//var_dump($h); exit;

  header('Location: '.$h);
  exit;
// index.php
//Cookieからシードを読んでみる o
//データベースに接続 o
//データベースから名前とシードとテキストを読み込む o
//sql.phpにデータを投げてデータベースに名前、seedm,テキストを書き込む now
//----------------------
// // write.php
//indexから名前とシードと内容の取得 ?
//名前が空欄の場合名前を名無しとする ?
//データベースに名前とシードと内容と発言時刻とIPの保存 ?
?>

