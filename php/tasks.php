<?php
  
  include "../includes/db_connect.inc.php";
  include "../includes/db_queries.inc.php";
  include "../includes/admin_menu.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
  }

  $sqlQuery = getAllTasksQuery();
  $result = mysqli_query($conn, $sqlQuery);
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
  <?php echo adminMenuItems(); ?>

  <div class="mt-5">
    <table class="table">
      <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">Title & Description</th>
        <th scope="col">Time</th>
        <th scope="col">Deadline</th>
        <th scope="col">Submission Time</th>
        <th scope="col">Project Point</th>
        <th scope="col">Assigned to</th>
      </tr>
      </thead>
      <?php
      while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['tid']; ?></td>
        <td>
          <h4>
            <?php echo $row['title']; ?>
          </h4>
          <p>
            <?php echo $row['description']; ?>
          </p>
        </td>
        <td><?php echo date_format(date_create($row['time']),"D M d Y h:i"); ?></td>
        <td><?php echo date_format(date_create($row['deadline']),"D M d Y h:i"); ?></td>
        <td>
          <p>
            <?php echo $row['submission_time']; ?>
          </p>
          <p>
            <?php echo date_format(date_create($row['submission_time']),"D M d Y h:i"); ?>
          </p>
        </td>
        <td><?php echo $row['project_point']; ?></td>
        <td>
          <p>
            Name: <?php echo $row['name']; ?>
          </p>
          <p>
            e_id: <?php echo $row['id']; ?>
          </p>
        </td>
      </tr>
      <?php }
      ?>
    </table>
  </div>
</body>
</html>