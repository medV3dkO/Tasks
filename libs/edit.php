<?php
session_start();
require_once "db.php";
$title = "Изменение";
if (isset($_SESSION['user'])) {
    $id = $_GET['ide'];
}else{
    echo 'You are not logged';
    header("refresh: 2; url=http://medvedko.zzz.com.ua/");
}

$sql = "SELECT * FROM tasks WHERE id=$id";
$query = mysqli_query($link, $sql) or die();

$dataFromTable = mysqli_fetch_assoc($query);
?>
<body>
<div>
    <input class="inputStandard" type="button" onclick="history.back();" value="Back"/>
</div>

<form action="editact.php" method="POST">
    <fieldset>
        <legend>Edit Task:</legend>
        <div class="field">
            <input type=hidden name=id value="<? echo $id ?>">
            <label>Name:</label>
            <input class=inputForm type=text name=Name value="<? echo $dataFromTable['Name'] ?>">
        </div>
        <div class="field">
            <label>E-mail:</label>
            <input class=inputForm type=text name=Email value="<? echo $dataFromTable['Email'] ?>">
        </div>
        <div class="field">
            <label>Task Text:</label>
            <?php echo "<td><textarea rows=\"3\" cols=\"25\" name='Task'>" .$dataFromTable['Task']. "</textarea></td>"; ?>
        </div>
        <div class="field">
            <input class=inputStandard type=submit name=submit value="Edit">
        </div>
    </fieldset>
</form>
</body>
