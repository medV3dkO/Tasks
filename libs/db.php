<?php
$host = 'localhost';
$db   = 'medvedko';
$user = 'medvedko';
$pass = 'pass';
$charset = 'utf8';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $opt);
?>
<?php
$host = 'localhost';
$user = 'medvedko';
$pass = 'pass';
$db_name = 'medvedko';
$link = mysqli_connect($host, $user, $pass, $db_name);

if (!$link) {
    echo 'Error. Code: ' . mysqli_connect_errno() . ':' . mysqli_connect_error();
    exit;
}
?>
