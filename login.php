<?php
    // Display errors for debugging
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    // Database connection
    include 'connection.php';
    include './components/alerts.php';

    $warning_msg = []; // Initialize the warning message array

    if (isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $pass = trim($_POST['password']);

        if (!empty($email) && !empty($pass)) {
            // Check if the user is an admin
            $verify_admin = $connAccounts->prepare("SELECT * FROM `admin_account` WHERE email = ? LIMIT 1");
            $verify_admin->execute([$email]);

            if ($verify_admin->rowCount() > 0) {
                // Admin found
                $fetch = $verify_admin->fetch(PDO::FETCH_ASSOC);
                
                // Verify admin password
                if (password_verify($pass, $fetch['password'])) {
                    $action_type = 'Login';

                    // Log admin login activity
                    $log_stmt = $connLogs->prepare("INSERT INTO admin_logs (email, activity_type, user_type) VALUES (?, ?, 'admin')");
                    $log_stmt->execute([$email, $action_type]);

                    // Set cookie and redirect to admin dashboard
                    setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
                    header('Location: admin/admin-dashboard.php');
                    exit();
                } else {
                    $warning_msg[] = 'Incorrect admin password!';
                }
            } else {
                // Check if the user is a client (in the client table)
                $verify_client = $connAccounts->prepare("SELECT * FROM `user_accounts` WHERE email = ? LIMIT 1");
                $verify_client->execute([$email]);

                if ($verify_client->rowCount() > 0) {
                    // Client found
                    $fetch = $verify_client->fetch(PDO::FETCH_ASSOC);
                    
                    // Verify client password
                    if (password_verify($pass, $fetch['password'])) {
                        $action_type = 'Login';

                        // Log client login activity
                        $log_stmt = $connLogs->prepare("INSERT INTO user_logs (email, activity_type, user_type) VALUES (?, ?, 'user')");
                        $log_stmt->execute([$email, $action_type]);

                        // Set cookie and redirect to client dashboard
                        setcookie('user_id', $fetch['id'], time() + 60 * 60 * 24 * 30, '/');
                        header('Location: user/candidates.php');
                        exit();
                    } else {
                        $warning_msg[] = 'Incorrect user password!';
                    }
                } else {
                    $warning_msg[] = 'No account found with this email!';
                }
            }
        } else {
            $warning_msg[] = 'Please fill in all fields!';
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