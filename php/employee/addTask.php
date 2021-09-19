<?php
  
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";
  include "../../includes/employee_menu.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $point = mysqli_real_escape_string($conn, $_POST['point']);
    $deadline = mysqli_real_escape_string($conn, $_POST['deadline']);
    $loggedIn_user_id = $_SESSION["user_id"];

    $sqlQuery = createTaskByOthersQuery($title, $description, $deadline, $point, $loggedIn_user_id);
    
    if (mysqli_query($conn, $sqlQuery)) {
      header("location: tasks.php");
    } else {
      echo "Error: " . $sqlQuery . "<br>" . mysqli_error($conn);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | Add Task</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <?php echo employeeMenuItems(); ?>

  <div>
    <h3>Fill up form carefully!</h3>

    <form method="post">
      <input type="text" name="title" id="title" placeholder="Title..."> <br>
      <textarea id="description" name="description" rows="5" cols="33" placeholder="Description..."></textarea> <br>
      <input type="number" name="point" id="point" placeholder="Project Point"> <br>
      <input type="datetime-local" name="deadline" id="deadline" placeholder="Deadline"> <br>
      <button type="submit" name="addTask" id="addTask">Add</button> <br>
    </form>
  </div>
</body>
</html>