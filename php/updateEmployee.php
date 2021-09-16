<?php
  include "../includes/db_connect.inc.php";
  include "../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
  }

  $user_name = $user_email = $user_country = $user_phone = $user_type = $user_points = $empId = "";

  if (isset($_GET['empId'])) {
    $empId = $_GET['empId'];
    $result = mysqli_query($conn, getUserByIdQuery($empId));
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $user_name = $row['name'];
        $user_email = $row['email'];
        $user_country = $row['country'];
        $user_phone = $row['phone'];
        $user_type = $row['type'];
        $user_points = $row['points'];
      }
    } else {
      header("Location: index.php");
    }
  } else {
    header("Location: index.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = mysqli_real_escape_string($conn, $_POST['name']);
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_country = mysqli_real_escape_string($conn, $_POST['country']);
    $user_phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $user_type = mysqli_real_escape_string($conn, $_POST['type']);
    $user_points = mysqli_real_escape_string($conn, $_POST['points']);

    $sqlQuery = updateUserQuery($user_name, $user_email, $user_country, $user_phone, $user_type, $user_points, $empId);
    
    if (mysqli_query($conn, $sqlQuery)) {
      header("location: employees.php");
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
    <form method="post">
        <input type="text" name="name" id="name" placeholder="name" value="<?php echo $user_name ?>"> <br>
        <input type="email" name="email" id="email" placeholder="email" value="<?php echo $user_email ?>"> <br>
        <input type="text" name="country" id="country" placeholder="country" value="<?php echo $user_country ?>"> <br>
        <input type="text" name="phone" id="phone" placeholder="phone" value="<?php echo $user_phone ?>"> <br>
        <input type="text" name="points" id="points" placeholder="points" value="<?php echo $user_points ?>"> <br>
        
        <select name="type" id="type" value="<?php echo $user_type ?>">
          <option value="employee">Employee</option>
          <option value="admin">Admin</option>
        </select> <br>
        
        <button type="submit" name="registration_button" id="registration_button">
          Save
        </button>
    </form>

    <a href="index.php">Home</a>
</body>
</html>