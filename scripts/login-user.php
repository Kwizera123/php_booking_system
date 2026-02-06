<?php

session_start();

require_once 'database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  if (
    empty($_POST['email']) ||
    empty($_POST['password'])
  ) {
    $_SESSION['error'] = 'Empty Input(s)';
    header('Location: ../login.php');
    exit();
  }

  $email = $_POST['email'];
  $password = $_POST['password'];

  //Input validation
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid Email';
    header('Location: ../login.php');
    exit();
  }


  if(strlen($password) < 8){
    $_SESSION['error'] = 'Password must be at least 8 characters long';
    header('Location: ../login.php');
    exit();
  }


  //Post data to database
  $result = $db->fetchUserByemail($email);
  if($result === false){
    $_SESSION['error'] = 'User does not exist.';
    header('Location: ../login.php');
    exit();
  }

  //Passwords match
  if (!password_verify($password, $result['password'])) {
    $_SESSION['error'] = 'Incorrect password.';
    header('Location: ../login.php');
    exit();
  }
  //Registration successful
  $_SESSION['success'] = 'Logged in successfully!';
  $_SESSION['user-logged-in'] = true;
  $_SESSION['user-email'] = $email;
  $_SESSION['user-id'] = $result['id'];
  $_SESSION['user-admin'] = $result['isadmin']; //1 is true, 0 is false
  header('Location: ../index.php');
  exit();
}
header('Location: ../login.php');

