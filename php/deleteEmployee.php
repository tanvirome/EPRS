<?php

  include "../includes/db_connect.inc.php";
  include "../includes/db_queries.inc.php";

  if (isset($_GET['empId'])) {
    $empId = $_GET['empId'];
    mysqli_query($conn, deleteAllDailyWorksOfEmployee($empId));
    mysqli_query($conn, deleteAllCommentsOfEmployee($empId));
    mysqli_query($conn, deleteAllPostsOfEmployee($empId));
    mysqli_query($conn, deleteAllReportedReportsOfEmployee($empId));
    mysqli_query($conn, deleteAllReportsOfEmployee($empId));
    mysqli_query($conn, deleteAllTaskByOtherOfEmployee($empId));
    mysqli_query($conn, deleteAllTaskByOtherOfEmployeeGivenTo($empId));
    mysqli_query($conn, deleteEmployeeQuery($empId));
  }

  header("Location: employees.php");
?>