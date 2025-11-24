<?php
session_start();
// Change from $_SESSION['email'] to $_SESSION['username']
if(!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body style="background-color: #fff;">
    
  <div class="box">
    <h1>Welcome, <span><?php echo $_SESSION['name']; ?></span></h1>
    <p>This is an <span>Admin</span> Page</p>
    <button onclick="window.location.href='logout.php'">Logout</button>
  </div>
</body>
</html>