<?php
session_start();
include("libs/db.php");
if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: http://medvedko.zzz.com.ua/"); /* Redirect browser */
    exit;
}
$id = $_GET['id'];
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('UPDATE tasks SET Status = 1 WHERE ID = ?');
    $stmt->execute($id);
    echo $_GET['id'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Tasks</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/buzina-pagination.min.css">
    <script
        src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
        crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Tasks</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Create new task
                </button>
            </li>
            <li class="nav-item">
            &nbsp
            </li>
            <li class="nav-item">
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle"
                        type="button" id="dropdownMenu1" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                    Sorting
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <a class="dropdown-item" href="?srtup_name">Sort by Name ↑</a>
                    <a class="dropdown-item" href="?srtdwn_name">Sort by Name ↓</a>
                    <a class="dropdown-item" href="?srtup_email">Sort by E-mail ↑</a>
                    <a class="dropdown-item" href="?srtudwn_email">Sort by E-mail ↓</a>
                    <a class="dropdown-item" href="?stsup">Sort by Status ↑</a>
                    <a class="dropdown-item" href="?stsdwn">Sort by Status ↓</a>
                    <a class="dropdown-item" href="http://medvedko.zzz.com.ua/">Reset Sorting</a>
                </div>
            </div>
            </li>
            <li class="nav-item">
                &nbsp
            </li>
           <?php if (isset($_SESSION['user'])){
               echo "<li class='nav-item'>
            <a class='btn btn-outline-danger float-right' href='?logout'>Logout</a>
            </li>";
           } else {
              echo"<li class='nav-item'>
            <button type = 'button' class='btn btn-outline-info float-right' data-toggle = 'modal' data-target = '#exampleModal2' >
                   Login
                </button >
            </li >";
            }
            ?>
    </div>
    </div>
</nav>
<div class="container">
    <div class="d-flex flex-row align-content-center" id="pad">
    <?php
    require_once('libs/db.php');
    $sort = 'SELECT ID,Name,Email,Task,Status,Edited FROM tasks';
    if (isset($_GET['srtup_name'])) {
        $sort = 'SELECT ID,Name,Email,Task,Status,Edited FROM tasks ORDER BY Name';
    }
    if (isset($_GET['srtdwn_name'])) {
        $sort = 'SELECT ID,Name,Email,Task,Status,Edited FROM tasks ORDER BY Name DESC';
    }
    if (isset($_GET['srtup_email'])) {
        $sort = 'SELECT ID,Name,Email,Task,Status,Edited FROM tasks ORDER BY Email';
    }
    if (isset($_GET['srtdwn_email'])) {
        $sort = 'SELECT ID,Name,Email,Task,Status,Edited FROM tasks ORDER BY Email DESC';
    }
    if (isset($_GET['stsup'])) {
        $sort = 'SELECT ID,Name,Email,Task,Status,Edited FROM tasks ORDER BY Status';
    }
    if (isset($_GET['stsdwn'])) {
        $sort = 'SELECT ID,Name,Email,Task,Status,Edited FROM tasks ORDER BY Status DESC';
    }
    $stmt = $pdo->prepare($sort);
    $stmt->execute();
    if($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_BOTH)) {?>
        <div class="p-2">
<div class="card">
  <div class="card-body">
    <?php if($row["Status"] == 1) {
          echo "<h4 class='card-title'>Task <span class='badge badge-success'>Task Complete</span></h4>";
    } else {
          echo "<h4 class='card-title'>Task <span class='badge badge-warning'>Not Complete</span></h4>";
    }; ?>
    <h6 class="card-subtitle mb-2 text-muted"><?php echo " ". $row["Name"]. " (". $row["Email"]. ")"; ?></h6>
    <p class="card-text">
        <?php echo nl2br($row['Task']);?>
    </p>
      <?php
      if (isset( $_SESSION['user'])) {
      echo "<a href='libs/obr.php?id=". $row["ID"]. "' class='card-link'>Completed</a>
    <a href='libs/edit.php?ide=". $row["ID"]. "' class='card-link'>Edit</a>
";
 }
?>
      <?php if($row["Edited"] == 1) {
          echo "<div class='card-footer'>
          Edited by Admin
      </div>";
      } else {
          echo "";
      }; ?>
  </div>
</div></div>
        <?php
        }
    }
    ?>
    </div>
</div>
<footer>
    <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new task</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="libs/obr.php" method="POST">
                        <div class="form-group">
                            <label for="Name">Your name</label>
                            <input type="text" class="form-control" id="Name" name="Name" placeholder="Bob Smith" required>
                        </div>
                        <div class="form-group">
                            <label for="E-mail">E-mail</label>
                            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" id="E-mail" name="Email" placeholder="example@example.com" required>
                        </div>
                        <div class="form-group">
                            <label for="Task">Task Text</label>
                            <textarea style="resize: none;" maxlength="150" class="form-control" id="Task" name="Task" rows="3" required></textarea>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Admin Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="libs/admin.php" method="POST">
                        <div class="form-group">
                            <label for="Login">Login</label>
                            <input type="text" class="form-control" id="Login" name="Login" placeholder="login" required>
                        </div>
                        <div class="form-group">
                            <label for="Password">Password</label>
                            <input type="password" class="form-control" id="Password" name="Password" placeholder="password" required>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</footer>
<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/buzina-pagination.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#pad').buzinaPagination({
                prevnext: false,
                itemsOnPage: 5
            });
        });
    </script>
</body>
</html>