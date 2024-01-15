<?php
session_start();

if (isset($_POST['logout'])) {
    $_SESSION = array();
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <?php if (isset($_SESSION['user_name'])) : ?>
        <div style="text-align: center; color: #203e8b;">
            <div style="font-size: 50px; font-weight: 500;">
                Hello <span><?php echo $_SESSION['user_name']; ?></span>
            </div>

            <div class="">
                Welcome to home page.
            </div>

            <form action="" method="post">
                <button type="submit" class="btn" name="logout">Logout</button>
            </form>
        </div>

    <?php else : ?>
        <p>Please log in to access this page. Redirecting...</p>
        <?php
        header("refresh:3;url=index.php");
        exit();
        ?>
    <?php endif; ?>
</body>

</html>