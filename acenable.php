<?
    $dbh=new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4","OGA","OGA",[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,PDO::ATTR_EMULATE_PREPARES=>true,]);
    $stmt=$dbh->prepare('select count(id) as cnt from login where seed=:seed ');
    $stmt->bindValue(':seed', $_GET['seed'],PDO::PARAM_STR);
    $stmt->execute();
    $data = $stmt->fetch();
    if($data['cnt']==1){
        $stmt=$dbh->prepare('select * from login where seed=:seed');
        $stmt->bindValue(':seed', $_GET['seed'],PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetchAll();
        echo $data[0]['name']."様";
        echo "アカウントの有効化が完了しました。";
        $stmt=$dbh->prepare('update login set enable=1 ,time=:time where seed=:id' );
        $stmt->bindValue(':id', $_GET['seed'],PDO::PARAM_STR);
        $date = new DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $stmt->bindValue(':time', $date,PDO::PARAM_STR);
        $stmt->execute();
        echo session_id();
}else{
    echo "エラーが発生しました。";
}
?>