<?php
include 'db/config.php';

$email = $password = '';
$emailError = $passwordError = $warning = '';

session_start();
if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = $_POST['password'];
  
  if (empty($email)) {
    $emailError = 'Email is required';
  } else {
    $emailError = '';
  }

  if (empty($password)) {
    $passwordError = 'Password is required';
  } else {
    $passwordError = '';
  }

  if (empty($emailError) && empty($passwordError)) {
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_name'] = $user['name'];
      $_SESSION['user_email'] = $user['email'];

      header("Location: ./home.php");
    } else {
      $warning = 'Invalid Email or Password';
    }
  }

}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>Login Form</title>
</head>

<body>
  <div class="form-container">
    <form action="" method="post">
    <div class="form-title">Sign In</div>

    <input type="email" id="email" placeholder="Email" name="email" value="<?php echo $email; ?>" onfocus="clearError('emailError')"/>
    <span class="error" id="emailError"><?php echo $emailError; ?></span>

    <input type="password" id="password" placeholder="Password" name="password" value="<?php echo $password; ?>" onfocus="clearError('passwordError')"/>
    <span class="error" id="passwordError"><?php echo $passwordError; ?></span>

    <span class="error" id="warning"> <?php echo $warning; ?></span>
    <button class="btn" type="submit" name="submit">Sign In</button>
    <p class="sign-in-text">
      Don't have an account? <a href="./signup.php" class="link">Sign Up</a>
    </p>
    </form>
  </div>

  <script>
    function clearError(errorId) {
      document.getElementById(errorId).textContent = '';
      document.getElementById('warning').textContent = '';
    }
  </script>
</body>

</html>
