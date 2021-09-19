<?php
  
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
  }

  $loggedIn_user_id = $_SESSION["user_id"];

  if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    $sqlQuery = getPostByIdQuery($postId);
    $result = mysqli_query($conn, $sqlQuery);
    $sqlQuery1 = getCommentsByPostId($postId);
    $result1 = mysqli_query($conn, $sqlQuery1);
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    $sqlQuery = getCreateCommentQuery($comment, $loggedIn_user_id, $postId);
    
    if (mysqli_query($conn, $sqlQuery)) {
      header("location: showPost.php?postId=$postId");
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

  <div class="m-3">
    <h3>Comment</h3>
    <form method="post">
      <textarea name="comment" id="comment" placeholder="Write comment..."></textarea>
      <br>
      <br>
      <button id="addComment" name="addComment" type="submit">Comment</button>
    </form>
  </div>

  <div class="comment-container m-5">
    <?php while ($row = mysqli_fetch_assoc($result1)) { ?>
      <div class="post-container">
        <h3><?php echo $row['employeesName']; ?></h3>
        <p><?php echo date_format(date_create($row['commentTime']),"D M d Y h:i"); ?></p>
        <p class="post-content"><?php echo $row['commentContent']; ?></p>
      </div>
    <?php } ?>
  </div>
</body>
</html>