<html>
    <head>
        <link rel="stylesheet" type="text/css" href ="seat.css">
    </head>
    <body background="img\bac.png">        
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
        <div class=A>
            <h2>更新履歴</h2>
            <p>
            2019/10/3 URLにリンクがつくようにした<br>
            2019/8/27 昇順・降順が逆だったのを修正。降順にした際にNoも並び替えられるように更新。XSS対策のため仕様一部を変更。<br>
            2019/7/19 板の新規作成の際にタイトル、説明を入力しないと作成できないように修正。(未入力のまま作成すると"無"が作成されるため)<br>
            2019/7/18 空気だった昇順 降順を機能するようにした。<br>
            2019/7/17 更新履歴を追加してみた。板を削除できるようにした。いろいろ修正した。
            </p>
        </div>
    </body>

</html>
<!--
    勝手に中身覗いちゃ駄目だゾ
-->

    