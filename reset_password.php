<?php
session_start();
include 'connect.php';
$message = '';

if(!isset($_SESSION['reset_email'])){
    header("Location: recover.php");
    exit();
}

$email = $_SESSION['reset_email'];

if(isset($_POST['reset'])){
    $password = md5($_POST['password']);

    $stmt = $conn->prepare("UPDATE users SET password=? WHERE email=?");
    $stmt->bind_param("ss", $password, $email);
    $stmt->execute();

    session_destroy();
    $message = "Password has been reset successfully.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container recover-container recover-page">

    <h1 class="form-title">Reset Password</h1>

    <form method="POST" autocomplete="off">

        <!-- New Password -->
         
        <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" placeholder=" " required minlength="6">
            <label>New Password</label>
        </div>

        <!-- Submit -->
        <input type="submit" class="btn" name="reset" value="Reset Password">

    </form>

    <!-- Success / Error Message -->
    <?php if($message): ?>
        <div class="message">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <!-- Back to Login -->
    <div class="back-link">
        <a href="index.php">← Back to Login</a>
    </div>

</div>

</body>
</html>

