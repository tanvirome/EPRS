<?php
  
  include "../../includes/db_connect.inc.php";
  include "../../includes/db_queries.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: ../index.php");
  }

  $loggedIn_user_id = $_SESSION["user_id"];

  $sqlQuery = getMyComplainsQuery($loggedIn_user_id);
  $result = mysqli_query($conn, $sqlQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | My Submitted Complains</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <div class="m-5">
    <a href="../blog/">Home</a>
  </div>

  <div class="m-5">
    <h2>My Submitted Complains</h2>

    <table class="table">
      <thead>
      <tr>
        <th scope="col">id</th>
        <th scope="col">Title</th>
        <th scope="col">Content</th>
        <th scope="col">FeedBack</th>
        <th scope="col">Delete</th>
      </tr>
      </thead>
      <?php
      while ($row = mysqli_fetch_assoc($result)) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['description']; ?></td>
        <td><?php if ($row['admin_feedback']) {
          echo $row['admin_feedback'];
        } else {
          echo "Pending";
        } ?></td>
        <td>
          <a href="deleteComplain.php?complainId=<?php echo $row['id']; ?>">Delete</a>
        </td>
      </tr>
      <?php }
      ?>
    </table>
  </div>
</body>
</html>