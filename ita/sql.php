<?php
  ob_start();
  session_start();
  if (isset($_POST["csrf_token"]) && $_POST["csrf_token"] === $_SESSION['csrf_token']) {
    require '../vendor/autoload.php';//env
    $dotenv = Dotenv\Dotenv::createImmutable('../');
    $dotenv->load();
    $datum = [];
    foreach(['name', 'seed', 'text'] as $s) {
      $datum[$s] = (string)@$_POST[$s];
    }
    if ( ('' === $datum['name'])||('' === $datum['text']) ){
      var_dump($datum);
      $h="./?id={$_GET['id']}&name={$_GET['name']}&sort={$_GET['sort']}";
      header('Location: '.$h);
      exit;
    }
    try {
      $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4",$_ENV["TEST_NAME"],$_ENV["TEST_PASS"],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
      $stmt=$dbh->prepare('insert into keizi values (:name,:seed,:text,:times,:id,:no,:login)');
      $count= $dbh->prepare('SELECT * FROM keizi where id=:id order by times desc ');
      $count->bindValue(':id', $_GET['id'],PDO::PARAM_STR);
      $count->execute();
      $stmt->bindValue(':name', $datum['name'],PDO::PARAM_STR);
	    $stmt->bindValue(':seed', $datum['seed'],PDO::PARAM_STR);
      $stmt->bindValue(':text', $datum['text'],PDO::PARAM_STR);
      $date = new DateTime();
      $date = $date->format('Y-m-d H:i:s');
      $stmt->bindValue(':times', $date,PDO::PARAM_STR);
      $stmt->bindValue(':id', $_GET["id"],PDO::PARAM_STR);
      $stmt->bindValue(':no', $count->rowCount()+1,PDO::PARAM_STR);
      if(isset($_SESSION['auth'])){
        $stmt->bindValue(':login',1,PDO::PARAM_STR);
      }else{
        $stmt->bindValue(':login',0,PDO::PARAM_STR);
      }
      $stmt->execute();
      $h="./?id=" . rawurlencode($_GET['id']) . "&name=" . rawurlencode($_GET['name']) . "&sort=" . rawurlencode($_GET['sort']);
      header('Location: '.$h);
      exit;
    }catch(PDOException $e){
      print("エラー:" . $e->getMessage() . "\n<br>");
      die();
    }
  }else{
    echo "不正なリクエストです";
  }
?>

