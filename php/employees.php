<?php
  
  include "../includes/db_connect.inc.php";
  include "../includes/db_queries.inc.php";
  include "../includes/admin_menu.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
  }

  $sqlQuery = getAllEmployeesQuery();
  $result = mysqli_query($conn, $sqlQuery);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists('searchEmployee', $_POST)) {
      if (!empty($_POST['searchTerm'])) {
        $searchTerm = mysqli_real_escape_string($conn, $_POST['searchTerm']);
        $sqlQuery = getEmployeesBySearchQuery($searchTerm);
        $result = mysqli_query($conn, $sqlQuery);
      }
      else {
        $sqlQuery = getAllEmployeesQuery();
        $result = mysqli_query($conn, $sqlQuery);
      }
      unset($_POST['searchEmployee']);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | Employees</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <?php echo adminMenuItems(); ?>

  <div class="mt-5">
    <div class="mb-3">
      <form method="post">
        <input type="text" name="searchTerm" id="searchTerm" placeholder="search by name...">
        <input type="submit" name="searchEmployee" id="searchEmployee" value="Search 🔍">
      </form>
    </div>
    <div>
      <table class="table">
        <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Type</th>
          <th scope="col">Phone</th>
          <th scope="col">Points</th>
          <th scope="col">Update</th>
          <th scope="col">Delete</th>
        </tr>
        </thead>
        <?php
        while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['name']; ?></td>
          <td><?php echo $row['type']; ?></td>
          <td><?php echo $row['phone']; ?></td>
          <td><?php echo $row['points']; ?></td>
          <td>
            <a href="updateEmployee.php?empId=<?php echo $row['id']; ?>">Update</a>
          </td>
          <td>
            <a href="deleteEmployee.php?empId=<?php echo $row['id']; ?>">Delete</a>
          </td>
        </tr>
        <?php }
        ?>
      </table>
    </div>
  </div>
</body>
</html>