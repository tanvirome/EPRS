<?php
  
  include "../includes/db_connect.inc.php";
  include "../includes/db_queries.inc.php";
  include "../includes/admin_menu.inc.php";

  session_start();

  if (!isset($_SESSION["user_email"])) {
    header("Location: index.php");
  }

  $sqlQuery = getAllReportsQuery();
  $result = mysqli_query($conn, $sqlQuery);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (array_key_exists('giveFeedback', $_POST)) {
      if (!empty($_POST['feedback'])) {
        $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
        $reportId = mysqli_real_escape_string($conn, $_POST['reportId']);
        $sqlQuery = postAdminFeedbackOnReportQuery($feedback, $reportId);
        mysqli_query($conn, $sqlQuery);

        $sqlQuery = getAllReportsQuery();
        $result = mysqli_query($conn, $sqlQuery);
      }
      unset($_POST['giveFeedback']);
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | Reports</title>
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
        <th scope="col">Complained By</th>
        <th scope="col">Complainee</th>
        <th scope="col">Time</th>
        <th scope="col">Feedback From Complainee</th>
        <th scope="col">Give feedback to complainer</th>
      </tr>
      </thead>
      <?php
      while ($row = mysqli_fetch_assoc($result)) { ?>
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
        <td><?php echo $row['name']; ?></td>
        <td><?php echo $row['name2']; ?></td>
        <td><?php echo date_format(date_create($row['time']),"D M d Y h:i"); ?></td>
        <td>
          <?php if ($row['feedback_from_reported']) {
            echo $row['feedback_from_reported'];
          }else {
            echo "No feedback given.";
          }; ?>
        </td>
        <td>
          <?php if ($row['admin_feedback']) {
            echo $row['admin_feedback'];
          }else { ?>
            <form method="post">
              <textarea name="feedback" id="feedback" cols="30" rows="3" placeholder="give your feedback..."></textarea>
              <input type="hidden" name="reportId" value="<?php echo $row['id']; ?>" />
              <button type="submit" name="giveFeedback" id="giveFeedback">Go!</button>
            </form>
          <?php }; ?>
        </td>
      </tr>
      <?php }
      ?>
    </table>
  </div>
</body>
</html>