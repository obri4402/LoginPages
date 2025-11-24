<?php
session_start();
// Change from $_SESSION['email'] to $_SESSION['username']
// Also remove the admin role check for user page
if(!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color: #fff;">
    
  <div class="box">
    <h1>Welcome, <span><?php echo $_SESSION['name']; ?></span></h1>
    <p>This is a <span>User</span> Page</p><?php echo $_SESSION['role']; ?></p>
    <button onclick="window.location.href='logout.php'">Logout</button>
  </div>
</body>
</html>