<?php
  
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
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
  <div>
    <a href="addPost.php">Make a post</a>
    <br>
    <a href="posts.php">All posts</a>
    <br>
    <a href="complain.php">Complain</a>
    <br>
    <a href="myPosts.php">My Posts</a>
    <br>
    <a href="myComplains.php">My Submitted Complains</a>
    <br>
    <a href="../index.php">Home</a>
  </div>
</body>
</html>