<?php 
session_start();

// Authorisation
if (isset($_SESSION['user-admin']) && $_SESSION['user-admin'] != 1) {
  header('Location: index.php');
  exit();
}



  require_once 'scripts/database.php';
  $db = new Database();
  $result = $db->fetchAllBookings();


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-base-200 flex flex-col">
  <nav class="navbar bg-base-100">
    <div class="navbar-start">
      <a href="index.php" class="btn btn-ghost text-xl">Home</a>
    </div>
    <div class="navbar-end space-x-2">
      <?php if (isset($_SESSION['user-logged-in'])): ?>
        <?php if (isset($_SESSION['user-admin']) && $_SESSION['user-admin'] == 1): ?>
          <a href="admin.php" class="btn btn-ghost">Admin Panel</a>
          <?php endif; ?>
        <a href="scripts/logout.php" class="btn btn-neutral">Logout</a>
      <?php else: ?>
        <a href="login.php" class="btn btn-ghost">Login</a>
        <a href="sign-up.php" class="btn btn-neutral">Sign Up</a>
        <?php endif; ?>
    </div>
  </nav>
  <main class="flex flex-1 flex-col items-center mt-4">


   <div class="w-full bg-base-100 rounded-xl shadow-xl py-2 px-2">
        <h1 class="text-2xl font-semibold text-center mt-4 mb-4">All  MOTs</h1>
        <div class="overflow-x-auto">
          <?php if ($result): ?>
          <table class="table table-zebra">
            <thead>
              <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Email</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($result as $row): ?>
              <tr>
                <td><?=  $row['datetime'] ?></td>
                <td><?=  $row['fullname'] ?></td>
                <td><?=  $row['email'] ?></td>
                <td class="text-orange-600"><?=  $row['status'] ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <?php else: ?>
            <p class="text-sm text-neutral-400 text-center text text-error">No Booking Yet!</p>
          <?php endif; ?>

        </div>
      </div>

  </main>

  </body>
</html>