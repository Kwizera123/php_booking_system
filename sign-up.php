<?php
session_start();  
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up</title>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="min-h-screen bg-base-200 flex flex-col">
  <main class="flex flex-1 items-center justify-center px-4">
    <div class="card w-full max-w-sm bg-base-100 shadow-xl">
      <div class="card-body">
        <h2 class="card-title justify-center text-2xl">Get Started!</h2>
        <p class="text-center text-sm text-base-content/60">
          Register your new account!
        </p>
        <?php

        if (isset($_SESSION['error'])): ?>
        <span class="text-sm text-error text-center"><?= $_SESSION['error'] ?></span>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <form method="post" action="scripts/register-user.php" class="mt-4">
          <div class="form-control mt-4">
            <label for="email" class="label">
              <span class="label-text">email</span>
            </label>
            <input type="email" name="email" placeholder="account@example.com" class="input input-bordered" required>
          </div>

           <div class="form-control mt-4">
            <label for="password" class="label">
              <span class="label-text">Password</span>
            </label>
            <input type="password" name="password" placeholder="********" minlength="8" class="input input-bordered" required>
          </div>

           <div class="form-control mt-4">
            <label for="verify-password" class="label">
              <span class="label-text">Verify Password</span>
            </label>
            <input type="password" name="verify-password" placeholder="********" minlength="8" class="input input-bordered" required>
          </div>
          <button type="submit" class="btn btn-neutral mt-6 w-full">Sign Up</button>
          <p class="text-center text-sm mt-4">
            Already have an account? 
            <a href="login.php" class="link link-primary">Sign In</a>
          </p>
        </form>
      </div> 
    </div>
  </main>
</body>
</html>