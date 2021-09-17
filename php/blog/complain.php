<?php
  
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
  }

  $loggedIn_user_id = $_SESSION["user_id"];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists('submitComplain', $_POST)) {
      $empId = mysqli_real_escape_string($conn, $_POST['empId']);
      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $sqlQuery = getCreateComplainQuery($empId, $title, $description, $loggedIn_user_id);
      
      if (mysqli_query($conn, $sqlQuery)) {
        header("location: ../blog/");
      } else {
        echo "Error: " . $sqlQuery . "<br>" . mysqli_error($conn);
      }

      unset($_POST['submitComplain']);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | Blog</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <div class="m-5">
    <a href="../blog/">Home</a>

    <div>
      <form method="POST">
        <input class="form-input" type="text" name="empId" id="empId" placeholder="ID">
        <br>
        <br>
        <input class="form-input" type="text" name="title" id="title" placeholder="title">
        <br>
        <br>
        <textarea class="textarea" name="description" id="description"  placeholder="Description..."></textarea>
        <br>
        <br>
        <button type="submit" name="submitComplain" id="submitComplain">SUBMIT</button>
      </form>
    </div>
  </div>
</body>
</html>