<?php

  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  if (isset($_GET['complainId'])) {
    $complainId = $_GET['complainId'];
    mysqli_query($conn, getDeleteComplainQuery($complainId));
  }

  header("Location: myComplains.php");
?>