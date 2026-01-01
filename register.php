<?php
include 'connect.php';
session_start();

if(isset($_POST['signUp'])){
    $firstName = $_POST['fName'];
    $lastName  = $_POST['lName'];
    $email     = $_POST['email'];
    $password  = $_POST['password'];
    $recoveryCode = $_POST['recovery_code']; // new recovery code field

    // Hash password and recovery code
    $password = md5($password);
    $recoveryCode = md5($recoveryCode);

    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if($result->num_rows > 0){
        echo "Email Address Already Exists!";
    } else {
        // Insert new user with recovery code
        $insertQuery = "INSERT INTO users(firstName, lastName, email, password, recovery_code)
                        VALUES ('$firstName', '$lastName', '$email', '$password', '$recoveryCode')";
        if($conn->query($insertQuery) === TRUE){
            header("Location: index.php");
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Login logic remains the same
if(isset($_POST['signIn'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $_SESSION['email'] = $row['email'];
        header("Location: homepage.php");
        exit();
    } else {
        echo "Incorrect Email or Password";
    }
}
?>
