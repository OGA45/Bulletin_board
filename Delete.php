<?
require_once('./common.php');
?>
<html>
    <body background="img\bac.png">
        <a href="index.php?id=<?php echo  h($_GET["id"]);?>&name=<?echo h($_GET["name"])?>&sort=0"><h1>板の削除</h1></a>
        <p><?echo h($_GET["name"]) ?>を削除します。よろしければパスワードを入力し、続行を押してください。</p>
        <form action="Deletesql.php?id=<?php echo h($_GET["id"]);?>&name=<?echo h($_GET["name"])?>" method="post">
        <input type="password" name="pass" size="15" maxlength="15">
        <input type="submit" value="続行";>
    </body>
</html>

