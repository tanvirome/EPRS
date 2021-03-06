<?php
  
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";
  include "../../includes/employee_menu.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
  }

  $loggedIn_user_id = $_SESSION["user_id"];
  $sqlQuery = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $taskId = mysqli_real_escape_string($conn, $_POST['taskId']);
    $taskPoint = mysqli_real_escape_string($conn, $_POST['taskPoint']);

    if (array_key_exists('taskByAdminSubmit', $_POST)) {
      $sqlQuery = getSubmitTaskByAdminQuery($taskId, $loggedIn_user_id);
      unset($_POST['taskByAdminSubmit']);
    }

    if (array_key_exists('taskByOthersSubmit', $_POST)) {
      $sqlQuery = getSubmitTaskByOthersQuery($taskId, $loggedIn_user_id);
      unset($_POST['taskByOthersSubmit']);
    }

    mysqli_query($conn, $sqlQuery);
    $sqlQuery = getEmployeePointsQuery($loggedIn_user_id);
    $result = mysqli_query($conn, $sqlQuery);
    $points = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $points = $row['points'];
    }
    $points = $points + $taskPoint;
    $sqlQuery = getUpdateEmployeePointsQuery($points, $loggedIn_user_id);
    mysqli_query($conn, $sqlQuery);
  }

  $sqlQuery1 = getAllTasksByAdminOfUserQuery($loggedIn_user_id);
  $sqlQuery2 = getAllTasksByOthersOfUserQuery($loggedIn_user_id);
  $result1 = mysqli_query($conn, $sqlQuery1);
  $result2 = mysqli_query($conn, $sqlQuery2);
  $rowCount1 = mysqli_num_rows($result1);
  $rowCount2 = mysqli_num_rows($result2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | Tasks</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <?php echo employeeMenuItems(); ?>

  <div class="mt-5">
    <?php
      if (!$rowCount1 > 0 && !$rowCount2 > 0) { ?>
        <p>No task pending.</p>
    <?php } else { ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Tasks</th>
              <th scope="col">Point</th>
              <th scope="col">Assign time</th>
              <th scope="col">Deadline</th>
              <th scope="col">Action</th>
              <th scope="col">Assigned By</th>
            </tr>
          </thead>
          <?php
          while ($row = mysqli_fetch_assoc($result1)) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
              <h4>
                <?php echo $row['title']; ?>
              </h4>
              <p>
                <?php echo $row['description']; ?>
              </p>
            </td>
            <td><?php echo $row['project_point']; ?></td>
            <td><?php echo date_format(date_create($row['time']),"D M d Y h:i"); ?></td>
            <td><?php echo date_format(date_create($row['deadline']),"D M d Y h:i"); ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="taskId" value="<?php echo $row['id']; ?>" />
                <input type="hidden" name="taskPoint" value="<?php echo $row['project_point']; ?>" />
                <button type="submit" name="taskByAdminSubmit" id="taskByAdminSubmit">Submit ???</button>
              </form>
            </td>
            <td> ADMIN </td>
          </tr>
          <?php } ?>

          <?php
          while ($row = mysqli_fetch_assoc($result2)) { ?>
          <tr>
            <td><?php echo $row['id']; ?></td>
            <td>
              <h4>
                <?php echo $row['title']; ?>
              </h4>
              <p>
                <?php echo $row['description']; ?>
              </p>
            </td>
            <td><?php echo $row['points']; ?></td>
            <td><?php echo date_format(date_create($row['time']),"D M d Y h:i"); ?></td>
            <td><?php echo date_format(date_create($row['deadline']),"D M d Y h:i"); ?></td>
            <td>
              <form method="post">
                <input type="hidden" name="taskId" value="<?php echo $row['id']; ?>" />
                <input type="hidden" name="taskPoint" value="<?php echo $row['points']; ?>" />
                <button type="submit" name="taskByOthersSubmit" id="taskByOthersSubmit">Submit ???</button>
              </form>
            </td>
            <td>
              <p>
                Name: <?php echo $row['name']; ?>
              </p>
              <p>
                e_id: <?php echo $row['employeesid']; ?>
              </p>
            </td>
          </tr>
          <?php } ?>
        </table>
    <?php }?>
  </div>
</body>
</html>