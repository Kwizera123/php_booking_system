<?php

session_start();

require_once 'database.php';
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
  if (
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    empty($_POST['verify-password'])
  ) {
    $_SESSION['error'] = 'Empty Input(s)';
    header('Location: ../sign-up.php');
    exit();
  }

  $email = $_POST['email'];
  $password = $_POST['password'];
  $verifyPassword = $_POST['verify-password'];

  //Input validation
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid Email';
    header('Location: ../sign-up.php');
    exit();
  }

  $result = $db->fetchUserByemail($email);
  if($result !== false){
    $_SESSION['error'] = 'Email already registered';
    header('Location: ../sign-up.php');
    exit();
  }

  if(strlen($password) < 8){
    $_SESSION['error'] = 'Password must be at least 8 characters long';
    header('Location: ../sign-up.php');
    exit();
  }
  if ($password !== $verifyPassword) {
    $_SESSION['error'] = 'Passwords do not match';
    header('Location: ../sign-up.php');
    exit();
  }

  //Hash password
  $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

  //Post data to database
  require_once 'database.php';
  $db = new Database();
  $result = $db->createUser($email, $hashedPassword);

  if($result === false){
    $_SESSION['error'] = 'Registration failed. Please try again.';
    header('Location: ../sign-up.php');
    exit();
  }
  //Registration successful
  $result = $db->fetchUserByemail($email);
  $_SESSION['success'] = 'Registration successful! You can now log in.';
  $_SESSION['user-logged-in'] = true;
  $_SESSION['user-email'] = $email;
  $_SESSION['user-id'] = $result['id'];
  $_SESSION['user-admin'] = $result['isadmin']; //1 is true, 0 is false
  header('Location: ../index.php');
  exit();
}
header('Location: ../sign-up.php');

