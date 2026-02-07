<?php 
session_start();

if (isset($_SESSION['user-id'])){
  require_once 'scripts/database.php';
  $db = new Database();
  $result = $db->fetchBookingsById($_SESSION['user-id']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Index Page</title>
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
  <?php if (isset($_SESSION['user-logged-in'])): ?>
    <h1 class="text-3xl font-bold mb-12">Welcome, <?= $_SESSION['user-email'] ?? ""; ?>!</h1>

    <div class="grid grid-cols-3 gap-24">
      <div class="col-span-2 w-full bg-base-100 rounded-xl shadow-xl py-2 px-2">
        <h1 class="text-2xl font-semibold text-center mt-4 mb-4">Your  MOTs</h1>
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
      <div class="flex items-center justify-center">
        <div class="card w-full max-w-sm bg-base-100 shadow-xl">
          <div class="card-body">

          <h2 class="card-title justify-center text-2xl">Book a MOT!!</h2>
        <p class="text-center text-sm text-base-content/60">
          Book a MOT appointment now!
        </p>
        <?php

        if (isset($_SESSION['error'])): ?>
        <span class="text-sm text-error text-center"><?= $_SESSION['error'] ?></span>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form method="post" action="scripts/book-booking.php" class="mt-4">
          <div class="form-control mt-4">
            <label for="email" class="label">
              <span class="label-text">Email</span>
            </label>
            <input type="email" name="email" placeholder="account@example.com" class="input input-bordered" >
          </div>

           <div class="form-control mt-4">
            <label for="full-name" class="label">
              <span class="label-text">Full Name</span>
            </label>
            <input type="text" name="full-name" placeholder="John Doe" class="input input-bordered" >
          </div>

            <div class="form-control mt-4">
            <label for="date" class="label">
              <span class="label-text">Date</span>
            </label>
            <input type="date" name="date" class="input input-bordered" >
          </div>

            <div class="form-control mt-4">
            <label for="time" class="label">
              <span class="label-text">Time</span>
            </label>
            <input type="time" name="time" class="input input-bordered" >
          </div>
          
          <button type="submit" class="btn btn-neutral mt-6 w-full">Book Now!</button>

        </form>

          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
      <h1 class="text-5xl font-bold text-center">Welcome Stranger!</h1>
      <p class="text-xl font-semibold text-center mt-4">Login or Sign up to get started!</p>
    <?php endif; ?>
  </main>

</body>
</html>