<?php
    session_start();
    $toke_byte = openssl_random_pseudo_bytes(16);
    $csrf_token = bin2hex($toke_byte);
    $_SESSION['csrf_token'] = $csrf_token;
?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href ="../seat.css">
        <title>掲示板:ログイン</title>
    </head>
    <body background="../img\525.gif">
        <div id=top align="center">
            <div class=title>
                <a href="../"><h1>アカウント作成</h1></a>
                <?
                if($_GET['e']==1){
                    echo "このメールアドレスは登録されています。";
                }elseif($_GET['e']==2){
                    echo "項目を埋めてください。";
                }
                ?>
                <form action="acsql.php" method="post">
                    ユーザー名:<input type="name" name="name" size="15" maxlength="15"><Br>
                    識別番号生成のためのシード:<input type="seed" name="seed" size="40" maxlength="8"><Br>
                    メールアドレス:<input type="mail" name="mail" size="40" maxlength="30"><Br>
                    パスワード:<input type="password" name="pass" size="40" maxlength="20"><br>
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token?>">
                    <input type="submit" value="作成" ;><input type="reset" value="リセット">
                </from>
                <a href="../login?e=0"><h3>ログイン</h3></a>
            </div>
        </div>
    </body>
</html>