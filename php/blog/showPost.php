<?php
  
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
  }

  if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    $sqlQuery = getPostByIdQuery($postId);
    $result = mysqli_query($conn, $sqlQuery);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | Post</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <div class="m-5">
    <a href="../blog/">Home</a>
  </div>

  <div class="post-main-container">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div class="post-container">
        <h2><?php echo $row['postTitle']; ?></h2>
        <p><?php echo date_format(date_create($row['postTime']),"D M d Y h:i"); ?></p>
        <p class="post-content"><?php echo $row['postContent']; ?></p>
      </div>
    <?php } ?>
  </div>
</body>
</html>