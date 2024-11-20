<?php
  //to display errors
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  //database connection
  include("connection.php");

  include ('./components/alerts.php');

  $warning_msg = [];
  $success_msg = [];

  if (isset($_POST['submit'])) {

      $image = $_POST['profile'];
      $name = $_POST['name'];
      $gender = $_POST['gender'];
      $email = $_POST['email'];
      $dob = $_POST['dob'];
      $address = $_POST['address'];
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $confirm_password = password_verify($_POST['repeat-password'], $password);

      $verify_email = $connAccounts->prepare("SELECT * FROM `user_accounts` WHERE email = ?");
      $verify_email->execute([$email]);

      if ($verify_email->rowCount() > 0) {
          $warning_msg[] = 'Email already taken!';
      } else {
          if ($confirm_password == 1) {
              $insert_user = $connAccounts->prepare("INSERT INTO `user_accounts`(image, name, gender, email, date_of_birth, address, password, user_type) VALUES(?,?,?,?,?,?,?,'user')");
              $insert_user->execute([$image, $name, $gender, $email, $dob, $address, $password]);
              $success_msg[] = 'Registered successfully!';
              // Redirect after the alert is shown
              echo '<script>setTimeout(function() { window.location.href = "index.php"; }, 2000);</script>';
          } else {
              $warning_msg[] = 'Confirm password not matched!';
          }
      }
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup</title>
  <link rel="stylesheet" href="./css/style.css">
  <script type="text/javascript" src="./js/validation.js" defer></script>
</head>

<body>
  <div class="wrapper">
    <h1>Signup</h1>
    <p id="error-message"></p>
    <form id="form" action="" method="post">

      <!-- profile image input -->
      <div>
        <label for="profile-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5f6368">
            <path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm40-160h480L570-480 450-320l-90-120-120 160Z" />
          </svg> </label>
        <input type="file" name="profile" id="profile-input">
      </div>

      <!-- name input -->
      <div>
        <label for="name-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z" />
          </svg>
        </label>
        <input type="text" name="name" id="name-input" placeholder="Full Name">
      </div>

      <!-- gender input -->
      <div>
        <label for="gender-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z" />
          </svg>
        </label>
        <input type="text" name="gender" id="gender-input" placeholder="Gender">
      </div>

      <!-- address input -->
      <div>
        <label for="address-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z" />
          </svg>
        </label>
        <input type="text" name="address" id="address-input" placeholder="Address">
      </div>

      <!-- email input -->
      <div>
        <label for="email-input">
          <span>@</span>
        </label>
        <input type="email" name="email" id="email-input" placeholder="Email">
      </div>

      <!-- date of birth input -->
      <div>
        <label for="dob-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Z" />
          </svg>
        </label>
        <input type="date" name="dob" id="dob-input" placeholder="Date of Birth">
      </div>

      <!-- password input -->
      <div>
        <label for="password-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
          </svg>
        </label>
        <input type="password" name="password" id="password-input" placeholder="Password">
      </div>

      <!-- repeat password input -->
      <div>
        <label for="repeat-password-input">
          <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24">
            <path d="M240-80q-33 0-56.5-23.5T160-160v-400q0-33 23.5-56.5T240-640h40v-80q0-83 58.5-141.5T480-920q83 0 141.5 58.5T680-720v80h40q33 0 56.5 23.5T800-560v400q0 33-23.5 56.5T720-80H240Zm240-200q33 0 56.5-23.5T560-360q0-33-23.5-56.5T480-440q-33 0-56.5 23.5T400-360q0 33 23.5 56.5T480-280ZM360-640h240v-80q0-50-35-85t-85-35q-50 0-85 35t-35 85v80Z" />
          </svg>
        </label>
        <input type="password" name="repeat-password" id="repeat-password-input" placeholder="Repeat Password">
      </div>



      <button type="submit" name="submit">Signup</button>
    </form>
    <p>Already have an Account? <a href="login.php">login</a> </p>
  </div>
</body>

</html>