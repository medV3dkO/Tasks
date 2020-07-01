<?php

include_once('db.php');

$sql = "SELECT * FROM admin_user WHERE Login=:login AND Password=:pass";
$res = $pdo->prepare($sql);
$res->bindvalue(':login', $_POST['Login']);	
$res->bindvalue(':pass', md5($_POST['Password']));	
$res->execute( );							
$res = $res->fetchAll();					

if (count($res)>0) {
    echo '<div class=\'alert alert-success\' role=\'alert\'>
    <strong>Done!</strong> Redirect in 2 seconds...
</div>';
    session_start();
    $_SESSION["user"] = true;
    header("refresh: 2; url=http://medvedko.zzz.com.ua/");
}else{
    echo 'Wrong information <a href="http://medvedko.zzz.com.ua/">Again?</a>';
}
?>