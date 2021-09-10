<?php
    session_start();
    $toke_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($toke_byte);
    $_SESSION['csrf_token'] = $csrf_token;
?>
<html lang="ja">
    <head>
        <meta charset="utf8ub4"/>
        <link rel="stylesheet" type="text/css" href ="../seat.css">
        <title>新規作成</title>
    </head>
    <div id=top align="center">
        <div class=title>
            <body background="../img\525.gif">
                <a href="../"><h1>新規作成</h1></a>
            </body>
            <form action="createtable.php" method="post">
            タイトル:<input type="name" name="name" size="40" maxlength="15"><br>
            説明:<input type="name" name="desc" size="40" maxlength="10">
            <input type="hidden" name="csrf_token" value="<?=$csrf_token?>">
            <br><input type="submit" value="送信"><input type="reset" value="リセット">
            <p>必ずタイトルと説明を入力してください。未入力の場合TOPに戻ります。</p>
            <p>同じタイトルを登録することはできません</p>
        </div>
    </div>
