<?php

session_start();

if (isset($_SESSION['user-admin']) && $_SESSION['user-admin'] != 1){
  header('Location: ../index.php');
  exit();
}

if (isset($_GET['id'])) {
  $id = $_GET['id'];
  require_once 'database.php';
  $db = new Database();
  $result = $db->changeBookingStatus($id);
    if ($result === false) {
      $_SESSION['error'] = "Invalid booking id";
    }
}
header('Location: ../admin.php');