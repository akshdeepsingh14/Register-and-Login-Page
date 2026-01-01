<?php
session_start();
include 'connect.php';
$message = '';

if(isset($_POST['recover'])){
    $email = $_POST['email'];
    $recovery_code = $_POST['recovery_code'];
    $recovery_code_hashed = md5($recovery_code);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=? AND recovery_code=?");
    $stmt->bind_param("ss", $email, $recovery_code_hashed);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $_SESSION['reset_email'] = $email;
        header("Location: reset_password.php");
        exit();
    } else {
        $message = "Invalid email or recovery code.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recover Password</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container recover-container recover-page">

    <h1 class="form-title">Recover Password</h1>

    <form method="POST" autocomplete="off">

        <!-- Email -->
        <div class="input-group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" placeholder=" " required>
            <label>Email</label>
        </div>

        <!-- Recovery Code -->
        <div class="input-group">
            <i class="fas fa-key"></i>
            <input type="password" name="recovery_code" placeholder=" " required>
            <label>Recovery Code</label>
        </div>

        <!-- Submit -->
        <input type="submit" class="btn" name="recover" value="Recover Password">

    </form>

    <!-- Message -->
    <?php if($message): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Back to Login -->
    <div class="back-link">
        <a href="index.php">← Back to Login</a>
    </div>

</div>

</body>
</html>

