<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once "config.php";

if(isset($_POST['register'])) {
  $name = $_POST['name']; // New name field
  $username = $_POST['username'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role = $_POST['role'];

  $checkEmail = $conn->query("SELECT email FROM users WHERE email='$username'");
  if ($checkEmail->num_rows > 0) {
    $_SESSION['register_error'] = "Username already exists.";
    $_SESSION['active_form'] = "register";
  }
  else {
    // Fix: Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $username, $password, $role);
    $stmt->execute();
    
    if($stmt->affected_rows > 0) {
      $_SESSION['register_success'] = "Registration successful! Please login.";
    }
  }
  header("Location: index.php");
  exit();
}

if(isset($_POST['login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $result = $conn->query("SELECT * FROM users WHERE email='$username'");
  
  // Debug: Check if query worked
  if ($result === false) {
      die("Query failed: " . $conn->error);
  }
  
  if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();
    
    // Debug: Check what data we're getting
    echo "<pre>User data: ";
    print_r($user);
    echo "</pre>";
    
    if (password_verify($password, $user['password'])) {
      $_SESSION['name'] = $user['name'];
      $_SESSION['username'] = $user['email'];
      $_SESSION['role'] = $user['role'];
      
      // Debug: Check session values
      echo "<pre>Session set: ";
      print_r($_SESSION);
      echo "</pre>";
      
      if ($user['role'] == 'admin') {
        echo "Redirecting to admin page...";
        header("Location: admin_page.php");
      } else {
        echo "Redirecting to user page...";
        header("Location: user_page.php");
      }
      exit();
      
    } else {
      $_SESSION['login_error'] = "Invalid password.";
    }
  } else {
    $_SESSION['login_error'] = "No user found with that username.";
  }
  $_SESSION['active_form'] = "login";
  header("Location: index.php");
  exit();
}

?>