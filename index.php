<?php
//to display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

//database connection
include("connection.php");

$warning_msg = []; // Initialize the warning message array

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $pass = $_POST['password'];

  // Prepare SQL statement to fetch user by email
  $verify_user = $connAccounts->prepare("SELECT * FROM `user_accounts` WHERE email = ? LIMIT 1");
  $verify_user->execute([$email]);

  if ($verify_user->rowCount() > 0) {
    $fetch = $verify_user->fetch(PDO::FETCH_ASSOC);
    $user_type = $fetch['user_type'];
    $action_type = 'Login';

    // Log the attempt
    if ($user_type === 'admin') {
      $log_stmt = $connLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, ?, ?)");
      $log_stmt->execute([$email, $action_type, $user_type]);
      setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
      if ($verify_user) {
        header('Location: admin/admin-dashboard.php');
        exit();
      }
    } else if ($user_type === 'user') {
      $log_stmt = $connLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, ?, ?)");
      $log_stmt->execute([$email, $action_type, $user_type]);
      if ($verify_user) {
        setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
        header('Location: user/candidates.php');
        exit();
      }
    } else {
    }
  } else {
    $warning_msg[] = 'Incorrect email!';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./css/style.css">
  <script type="text/javascript" src="./js/validation.js" defer></script>
</head>

<body>
  <div class="wrapper">
    <h1>Login</h1>
    <p id="error-message"></p>
    <form id="form" action="" method="post" enctype="multipart/form-data">
      <div>
        <label for="email-input">
          <span>@</span>
        </label>
        <input type="email" name="email" id="email-input" placeholder="Email">
      </div>
      <div>
        <label for="password-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
          </svg>
        </label>
        <input type="password" name="password" id="password-input" placeholder="Password">
      </div>
      <button type="submit" name="submit">Login</button>
    </form>
    <p>New here? <a href="signup.php">Create an Account</a></p>
  </div>
</body>

</html>