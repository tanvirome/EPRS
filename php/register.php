<?php
  include "../includes/db_connect.inc.php";
  include "../includes/db_queries.inc.php";

  session_start();

  // if (isset($_SESSION["user_email"])) {
  //   $type = $_SESSION["user_type"];
  //   if ($type == "admin") {
  //     header("Location: admin_homepage.php");
  //   } else if ($type == "employee") {
  //     header("Location: employee_homepage.php");
  //   }
  // }

  $user_name = $user_email = $user_password = $user_country = $user_phone = $user_type = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = mysqli_real_escape_string($conn, $_POST['name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);
    $user_country = mysqli_real_escape_string($conn, $_POST['country']);
    $user_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $user_type = mysqli_real_escape_string($conn, $_POST['type']);
    $user_hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    $sqlQuery = registerNewUserQuery($user_name, $user_email, $user_hashed_password, $user_country, $user_phone, $user_type);
    
    if (mysqli_query($conn, $sqlQuery)) {
      header("location: index.php");
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
  <title>Employees Performance Review System | Employee Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <h3>Fill up form carefully!</h3>
    <form class="" action="register.php" method="post">
        <input type="text" name="name" id="name" placeholder="name"> <br>
        <input type="email" name="email" id="email" placeholder="email"> <br>
        <input type="password" name="password" id="password" placeholder="password"> <br>
        <input type="text" name="country" id="country" placeholder="country"> <br>
        <input type="text" name="phone" id="phone" placeholder="phone"> <br>
        
        <select name="type" id="type">
          <option value="employee">Employee</option>
          <option value="admin">Admin</option>
        </select> <br>
        
        <button type="submit" name="registration_button" id="registration_button">
          Register
        </button>
    </form>

    <a href="index.php">Log In</a> <br>
    <a href="index.php">Home</a>
</body>
</html>