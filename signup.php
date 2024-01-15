<?php
include './db/config.php';

$nameError = $emailError = $phoneError = $passwordError = $confirmPasswordError = $warning = '';

$name = $email = $phone = $password = $confirmPassword = '';

if (isset($_POST['submit'])) {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  if (empty($name)) {
    $nameError = 'Name is required';
  } else {
    $nameError = '';
  }

  if (empty($email)) {
    $emailError = 'Email is required';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $emailError = 'Invalid email format';
  } else {
    $emailError = '';
  }

  if (empty($phone)) {
    $phoneError = 'Phone number is required';
  } elseif (!preg_match('/^\d{10}$/', $phone)) {
    $phoneError = 'Phone number must 10 digits';
  } else {
    $phoneError = '';
  }

  if (empty($password)) {
    $passwordError = 'Password is required';
  } elseif (strlen($password) < 6 || !preg_match('/[0-9]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
    $passwordError = 'Password must be at least 6 characters long and contain at least one special character and one number';
  } else {
    $passwordError = '';
  }

  if (empty($confirmPassword)) {
    $confirmPasswordError = 'Confirm Password is required';
  } elseif ($password != $confirmPassword) {
    $confirmPasswordError = 'Passwords do not match';
  } else {
    $confirmPasswordError = '';
  }

  if (empty($nameError) && empty($emailError) && empty($phoneError) && empty($passwordError) && $password == $confirmPassword) {
   try {
    $isUserAllreadyExist = $conn->query("SELECT * FROM user WHERE email = '$email'");

    if ($isUserAllreadyExist->num_rows == 0) {
      $sql = "INSERT INTO user(name, email, phone, password) values ('$name', '$email', '$phone', '$password')";
      $result = $conn->query($sql);
      
      if ($result) {
        $warning = 'Registered successfully';
        echo "<script>
        setInterval(() =>  window.location.href = './index.php', 1000);
        </script>";
      }
    } else {
      $emailError = 'Email already exist';
    }
    
   } catch (\Throwable $th) {
    $warning = 'Failed to connect database';
   }
  }
}
?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/style.css">
  <title>signup Form</title>
</head>

<body>
  <div class="form-container">
    <form method="post" action="">
      <div class="form-title">Sign Up</div>
      
      <input type="text" id="name" placeholder="Name" name="name" value="<?php echo htmlspecialchars($name); ?>" onfocus="clearError('nameError')" />
      <span class="error" id="nameError"><?php echo $nameError; ?></span>

      <input type="email" id="email" placeholder="Email" name="email" value="<?php echo htmlspecialchars($email); ?>" onfocus="clearError('emailError')" />
      <span class="error" id="emailError"><?php echo $emailError; ?></span>

      <input type="number" id="phone" placeholder="Phone no." name="phone" value="<?php echo htmlspecialchars($phone); ?>" onfocus="clearError('phoneError')" />
      <span class="error" id="phoneError"><?php echo $phoneError; ?></span>

      <input type="password" id="password" placeholder="Password" name="password" value="<?php echo htmlspecialchars($password); ?>" onfocus="clearError('passwordError')" />
      <span class="error" id="passwordError"><?php echo $passwordError; ?></span>

      <input type="password" id="confirmpassword" placeholder="Confirm Password" name="confirm_password" value="<?php echo htmlspecialchars($confirmPassword); ?>" onfocus="clearError('confirmPasswordError')" />
      <span class="error" id="confirmPasswordError"><?php echo $confirmPasswordError; ?></span>

      <button class="btn" name="submit" type="submit">Create Account</button>
    </form>
    <span class="error" id="warning">
            <?php echo $warning; ?>
        </span>
    <p class="sign-in-text">
      Have an account? <a href="./index.php" class="link">Sign In</a>
    </p>
  </div>

  <script>
    function clearError(errorId) {
      document.getElementById(errorId).textContent = '';
      document.getElementById('warning').textContent = ''
    }
  </script>
</body>

</html>+