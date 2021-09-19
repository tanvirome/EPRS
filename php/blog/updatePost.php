<?php
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
  }

  $title = $category = $content = "";

  if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    $result = mysqli_query($conn, getPostByIdQuery($postId));
    $rowCount = mysqli_num_rows($result);
    if ($rowCount > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['postTitle'];
        $category = $row['postCategory'];
        $content = $row['postContent'];
      }
    } else {
      header("Location: ../index.php");
    }
  } else {
    header("Location: ../index.php");
  }

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);

    $sqlQuery = updatePostQuery($title, $category, $content, $postId);
    
    if (mysqli_query($conn, $sqlQuery)) {
      header("location: myPosts.php");
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
    <h2>Update A Post</h2>

    <form method="post">
      <input type="text" name="title" id="title" placeholder="Title" value="<?php echo $title ?>">
      <br>
      <br>
      <input id="category" name="category" type="text" placeholder="Category" value="<?php echo $category ?>">
      <br>
      <br>
      <textarea name="content" id="content" placeholder="Post something..."><?php echo $content ?></textarea>
      <br>
      <br>
      <button id="updatePost" name="updatePost" type="submit">SEND</button>
    </form>
  </div>
</body>
</html>