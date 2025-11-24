<?php

session_start();

$errors = [
  'login' => $_SESSION['login_error'] ?? '',
  'register' => $_SESSION['register_error'] ?? ''
];
$active_form = $_SESSION['active_form'] ?? 'login';

// Store form data in session to preserve input values
if(isset($_SESSION['form_data'])) {
  $form_data = $_SESSION['form_data'];
  unset($_SESSION['form_data']);
}

session_unset();

function showError($error) {
  return !empty($error) ? "<div class='error-message'>{$error}</div>" : "";
}
function isActiveForm($formName, $activeForm) {
  return $formName === $activeForm ? 'active' : '';
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Full-Stack Login & Register Form With User & Admin Page</title>
  <link rel="stylesheet" href="style.css">

</head>

<body>

  <div class="container">
    <div class="form-box <?= isActiveForm('login', $active_form); ?> " id="login-form">
      <form action="login_register.php" method="post">
        <h2>Login</h2>
        <?= showError($errors['login']); ?>

        <div class="input-group">
          <label for="login-username">Email</label>
          <input type="text" id="login-username" name="username" required>
        </div>
        <div class="input-group">
          <label for="login-password">Password</label>
          <input type="password" id="login-password" name="password" required>
        </div>
        <button type="submit" name="login" class="btn">Login</button>
        <p class="toggle-link">Don't have an account? <a href="#" onclick="showForm('register-form')"
            id="show-register">Register here</a></p>
      </form>
    </div>


    <div class="form-box <?= isActiveForm('register', $active_form); ?>" id="register-form">
      <form action="login_register.php" method="post">
        <h2>Register</h2>
        <?= showError($errors['register']); ?>

        <!-- New Name Field -->
        <div class="input-group">
          <label for="register-name">Full Name</label>
          <input type="text" id="register-name" name="name" value="<?= $form_data['name'] ?? '' ?>" required>
        </div>

        <div class="input-group">
          <label for="register-username">Email</label>
          <input type="email" id="register-username" name="username" value="<?= $form_data['username'] ?? '' ?>" required>
        </div>
        <div class="input-group">
          <label for="register-password">Password</label>
          <input type="password" id="register-password" name="password" required>
        </div>

        <div class="input-group">
          <label for="register-role">Role</label>
          <select name="role" id="register-role" required>
            <option value="" disabled selected>--Select Role--</option>
            <option value="employee" <?= isset($form_data['role']) && $form_data['role'] == 'employee' ? 'selected' : '' ?>>Employee</option>
            <option value="admin" <?= isset($form_data['role']) && $form_data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>
        </div>

        <button type="submit" name="register" class="btn">Register</button>
        <p class="toggle-link">Already have an account? <a href="#" onclick="showForm('login-form')"
            id="show-login">Login</a></p>
      </form>
    </div>

  </div>
  <script src="script.js"></script>

</body>

</html>