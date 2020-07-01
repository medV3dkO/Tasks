<?php
require_once "db.php";
$id = $_POST['id'];
$namen = $_POST["Name"];
$email = $_POST["Email"];
$taskn = $_POST["Task"];
$task = htmlspecialchars($taskn);
$name = htmlspecialchars($namen);
$edit = 1;
$sql = mysqli_query($link, "UPDATE tasks SET Name = '$name', Email = '$email', Task = '$task', Edited = '$edit' WHERE ID=$id");
if ($sql) {
    echo "<div class='alert alert-success' role='alert'>
    <strong>Done!</strong> Redirect in 2 seconds...
</div>";
    header("refresh: 2; url=http://medvedko.zzz.com.ua/");
} else {
    echo '<p>Error: ' . mysqli_error($link1) . '</p>';
}
?>
