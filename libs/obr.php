<?php
try {
    include("db.php");
$namen = $_POST["Name"];
$email = $_POST["Email"];
$taskn = $_POST["Task"];
$task = htmlspecialchars($taskn);
$name = htmlspecialchars($namen);
$status = 0;
$stmt = $pdo->prepare('INSERT INTO tasks (Name,Email,Task,Status) VALUES (?,?,?,?)');
$stmt->execute(array($name,$email,$task,$status));
echo "Succesful";
header("Location: http://medvedko.zzz.com.ua/");
}
catch(PDOException $e)
{
    echo "Error: " . $e->getMessage();
}

if (isset($_GET['id'])) {
    $sql = mysqli_query($link, "UPDATE `tasks` SET `Status` = '1' WHERE `ID`={$_GET['id']}");
    header("Location: http://medvedko.zzz.com.ua/");
}
?>