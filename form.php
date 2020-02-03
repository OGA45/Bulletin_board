<html lang="ja">

<head>
    <meta charset="utf8ub4" />
</head>

<body background="img/bac.png">
    <a href="top.php">
        <h1>掲示板:
            <? echo h($_GET["name"])?>
        </h1>
    </a>
</body>
<form action="sql.php?id=<?php echo h($_GET["id"]);?>&name=<?echo h($_GET["name"])?>&sort=<?echo h($_GET["sort"])?>" method="post">
    名前:
    <input type="text" name="name" size="40" maxlength="15"> 識別番号生成のためのシード:
    <input type="text" name="seed" size="8" value=<?php echo h($seed) ?> maxlength="8">
    <Br> 内容:
    <textarea name="text" rows="4" cols="40" maxlength="2147483647"></textarea>
    <br>
    <input type="submit" value="送信" ;>
    <input type="reset" value="リセット">
</form>
<form action="index.php" method="get">
    <input type="radio" name="sort" value="0" <?if($_GET[ "sort"]==0){echo 'checked="checked"';}?>>昇順
    <input type="radio" name="sort" value="1" <?if ($_GET[ "sort"]==1 ){echo 'checked="checked"';} ?>>降順
    <input type="hidden" name="id" value=<?echo h($_GET[ "id"]);?>>
    <input type="hidden" name="name" value=<?echo h($_GET[ "name"])?>>
    <input type="submit" value="更新">
</form>

</html>