<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulate booking logic
  if (
        empty($_POST['email']) ||
        empty($_POST['full-name']) ||
        empty($_POST['date']) ||
        empty($_POST['time'])
    ) {
        $_SESSION['error'] = 'Empty Input(s).';
        header('Location: ../index.php');
        exit();
    }
    
$email = $_POST['email'];
$fullName = $_POST['full-name'];
$date = $_POST['date'];
$time = $_POST['time'];

// input validation could be added here
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'Invalid email.';
    header('Location: ../index.php');
    exit();
}
  $inputDatetime = new DateTime($date . ' ' . $time);
  $now = new DateTime();
  if ($inputDatetime < $now) {
      $_SESSION['error'] = 'Date and time must be in the future.';
      header('Location: ../index.php');
      exit();
  }

  $bookingTime = $inputDatetime->format('Y-m-d H:i:s');

  require_once 'database.php';
  $db = new Database();
  $result = $db->getBookingByDateTime($bookingTime);
  if ($result) {
    $_SESSION['error'] = "Booking Unavailable";
    header('Location: ../index.php');
    exit();
  }

  $userid = $_SESSION['user-id'];

  $result = $db->createNewBooking($userid, $email, $fullName, $bookingTime); 
    if ($result === false) {
    $_SESSION['error'] = "Database Error";
    header('Location: ../index.php');
    exit();
    }

    $_SESSION['success'] = "Booking Created!";
    header('Location: ../index.php');
    exit();
}

header('Location: ../index.php');