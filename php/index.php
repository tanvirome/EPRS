<?php

include "../includes/db_connect.inc.php";
include "../includes/db_queries.inc.php";

session_start();

if (isset($_SESSION["user_email"])) {
	$type = $_SESSION["user_type"];
	if ($type == "admin") {
		header("Location: admin_homepage.php");
	} else if ($type == "employee") {
		header("Location: employee_homepage.php");
	}
}

$user_email = $user_password = "";

$errmsg1 = $errmsg2 = $errmsg3 = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if (isset($_POST['login_button'])) {
		if (!empty($_POST['email'])) {
			$user_email = mysqli_real_escape_string($conn, $_POST['email']);
		} else {
			$errmsg1 = "This field can't be empty";
		}


		if (!empty($_POST['user_password'])) {
			$user_password = mysqli_real_escape_string($conn, $_POST['user_password']);
		} else {
			$errmsg2 = "This field can't be empty";
		}

		if ($errmsg1 == "" && $errmsg2 == "") {
      $sqlQuery = getUserByEmailQuery($user_email);
      $result = mysqli_query($conn, $sqlQuery);
			$rowCount = mysqli_num_rows($result);

			if ($rowCount < 1) {
				$errmsg3 = "User does not exist!";
			} else {
				while ($row = mysqli_fetch_assoc($result)) {
					$user_passwordInDB = $row['password'];
					$user_id = $row['id'];
					$user_type = $row['type'];

					if (password_verify($user_password, $user_passwordInDB)) {
						$_SESSION['user_email'] = $user_email;
						$_SESSION['user_id'] = $user_id;
						$_SESSION['user_type'] = $user_type;

            if ($user_type == "admin") {
              header("Location: admin_homepage.php");
            } else if ($user_type == "employee") {
              header("Location: employee_homepage.php");
            }
					} else {
						$errmsg3 = "Wrong Password!";
					}
				}
			}
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Employees Performance Review System | Log In</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
  <div class="login_form">
    <form action="index.php" method="POST" class="login_info">
      <div>
        <!-- <label for="user_email">Email Address</label> <br /> -->
        <!-- <input class="user_info" type="text" name="username" id="username" placeholder="Username" value="<?php echo $username ?>" required /> -->
        <input type="email" name="email" id="email" placeholder="email">
        <br />
        <span style="color:red;"><?php echo $errmsg1; ?></span>
      </div>
      <div>
        <!-- <label for="user_password">Password</label> <br /> -->
        <!-- <input type="password" name="user_password" id="user_password" placeholder="Password" required class="user_info" /> -->
        <input type="password" name="user_password" id="user_password" placeholder="Password">
        <br />
        <span style="color:red;"><?php echo $errmsg2; ?></span>
      </div>
      <div>
        <button type="submit" name="login_button" id="login_button">Log In</button>
      </div>
      <span style="color:red;"><?php echo $errmsg3; ?></span>
    </form>
  </div>

  <a href="register.php">Register</a>
</body>
</html>