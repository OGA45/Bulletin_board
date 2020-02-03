<?php
session_start();
if($_GET['test']==1){
    $_SESSION['test']=1;
}elseif($_GET['test']==2){
    $_SESSION['test']=2;
}
echo $_SESSION['test'];
?>