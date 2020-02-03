<?php
    ob_start();
    session_start();
?>
    <html>
    <head>
        <link rel="stylesheet" type="text/css" href ="seat.css">
    </head>
    <body background="img\525.gif">        
        <div id=top align="center">
            <img src="img/title.png" alt="center">
            
            <a href="create.html"><h3>新規作成</h3></a>
        </div>    
    </body>
</html>
<?php
    require_once 'template.php';
    $dbh = new PDO("mysql:host=localhost;dbname=OGA;charset=utf8mb4", "OGA", "OGA", [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => true,]);
    $stmt=$dbh->prepare('select * from title order by name asc');
    $stmt->execute();
    foreach ($stmt as $row) {
        echo template1('top.html',$row["id"],$row["name"],$row["description"] );
    }
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href ="seat.css">
    </head>
    <body background="img\bac.png">
        <div class=title>
            <h2>更新履歴</h2>
            <p>
            2020/01/28 ログイン機能実装。ログインすると名前とseedが完全に固定され、IDの最後に☆が追加される。<br>
            2020/01/24 アカウント作成ページのバグを修正。既にメールアドレスが登録されている場合警告するように。<br>
            2020/01/21 ログイン、アカウント作成のページを実装　作成は可能、ログイン機能は未実装。<br>
            2019/11/19 >>1のような物にリンクが付くようにした。投稿の仕様変更等のため投稿内容を初期化。<br>
            2019/10/3  URLにリンクがつくようにした。<br>
            2019/8/27  昇順・降順が逆だったのを修正。降順にした際にNoも並び替えられるように更新。XSS対策のため仕様一部を変更。<br>
            2019/7/19  板の新規作成の際にタイトル、説明を入力しないと作成できないように修正。(未入力のまま作成すると"無"が作成されるため)<br>
            2019/7/18  空気だった昇順 降順を機能するようにした。<br>
            2019/7/17  更新履歴を追加してみた。板を削除できるようにした。いろいろ修正した。
            </p>
        </div>
        <div id=top align="center">
        <?php
        if(isset($_SESSION['auth'])){
            echo $_SESSION['auth']['name']."でログイン中";
            echo '<a href="logout.php"><h3>ログアウト</h3></a>';
        }else{
           echo '<a href="login.php?e=0"><h3>ログイン</h3></a>';
        }?>
        </div>
    </body>

</html>
<!--
    勝手に中身覗いちゃ駄目だゾ
-->

    