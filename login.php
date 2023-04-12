<?PHP
    session_start();

    // Verify if user already logged in
    if (isset($_SESSION['username'])) {
        header("Location: welcome.php");
        exit();
    }
    
    // If the login form is submitted, process the login
    if (isset($_POST['submit'])) {

        // Connect to the database
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "exemplebtc";
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Check connection to database
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Query the database for the user's credentials
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the user's password
            if (password_verify($password, $row['password'])) {

                // Set the session variables
                $_SESSION['username'] = $row['username'];
                $_SESSION['password'] = $row['password'];

                // Redirect to the welcome page
                header("Location: welcome.php");
                exit();
            } else {
                $error = "Invalid username or password.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    
        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">

            <label for="password">Password:</label>
            <input type="password" name="password" id="password">

            <input type="submit" name="submit" value="Login">
        </form>

        <?php if (isset($error)) { ?>
            <p class="error"><?php echo $error; ?></p>
        <?php } ?>
    </div>
</body>
</html>