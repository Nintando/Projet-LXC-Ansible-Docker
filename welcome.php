<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {

    // If not, redirect to the login page
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="welcome">
        <h1>Bonjour, monsieur <?php echo $_SESSION['username']; ?>!</h1>
    </div>
</body>
</html>