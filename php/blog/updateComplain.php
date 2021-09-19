<?php
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
  }

  $title = $category = $content = "";

  if (isset($_GET['complainId'])) {
    $complainId = $_GET['complainId'];
    $result = mysqli_query($conn, getComplainByIdQuery($complainId));
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $empId = $row['employeesid'];
        $title = $row['title'];
        $description = $row['description'];
      }
    } else {
      header("Location: ../index.php");
    }
  } else {
    header("Location: ../index.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $empId = mysqli_real_escape_string($conn, $_POST['empId']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $sqlQuery = getUpdateComplainQuery($empId, $title, $description, $complainId);
    
    if (mysqli_query($conn, $sqlQuery)) {
      header("location: myComplains.php");
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
  <title>Employees Performance Review System | Update Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <div class="m-5">
    <a href="../blog/">Home</a>
  </div>

  <div class="m-5">
    <h2>Update A Complain</h2>

    <form method="post">
      <form method="POST">
      <input class="form-input" type="text" name="empId" id="empId" placeholder="ID" value="<?php echo $empId ?>">
      <br>
      <br>
      <input class="form-input" type="text" name="title" id="title" placeholder="title" value="<?php echo $title ?>">
      <br>
      <br>
      <textarea class="textarea" name="description" id="description"  placeholder="Description..."><?php echo $description ?></textarea>
      <br>
      <br>
      <button type="submit" name="submitComplain" id="submitComplain">SUBMIT</button>
    </form>
    </form>
  </div>
</body>
</html>