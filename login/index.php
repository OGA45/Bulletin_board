<html>
    <head>
        <link rel="stylesheet" type="text/css" href ="../seat.css">
        <title>ログイン</title>
    </head>
    <body background="../img\525.gif">
        <div id=top align="center">
            <div class=title>
                <a href="../"><h1>ログイン</h1></a>
                <?
                if($_GET['e']==1){
                echo "メールアドレス、又はパスが違います";
                }elseif($_GET['e']==2){
                    echo "アカウントが有効化されていません";
                }
                ?>
                <form action="aclogin.php" method="post">
                    メールアドレス:<input type="mail" name="mail" size="40" maxlength="30"><Br>
                    パスワード:<input type="password" name="pass" size="40" maxlength="20"><br>
                    <input type="submit" value="ログイン" ;><input type="reset" value="リセット">
                </from>
                <a href="../create_ac?e=0"><h3>アカウント作成</h3></a>
            </div>
        </div>
    </body>
</html>