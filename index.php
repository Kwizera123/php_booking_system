<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index Page</title>
</head>
<body>
  <?php if(isset($_SESSION['user-logged-in'])) {
    echo 'User is logged in';
  } else {
    echo 'User is not logged in';
  }; ?>

</body>
</html>