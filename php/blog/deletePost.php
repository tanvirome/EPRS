<?php

  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    mysqli_query($conn, getDeleteCommentsOfPostQuery($postId));
    mysqli_query($conn, getDeletePostQuery($postId));
  }

  header("Location: myPosts.php");
?>