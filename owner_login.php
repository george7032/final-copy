<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection here
    include("dbcon.php");

    $ownerEmail = $_POST["ownerEmail"];
    $ownerPassword = $_POST["ownerPassword"];

    // Perform input validation here if needed

    // Query the database to check owner credentials
    $query = "SELECT * FROM owners WHERE ownerEmail = ? AND ownerPassword = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $ownerEmail, $ownerPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Owner authentication successful
        $row = $result->fetch_assoc();

        // Store owner information in the session
        $_SESSION["login"] = true;
        $_SESSION["ownerID"] = $row["ownerID"];
        $_SESSION["apartmentID"] = $row["apartmentID"];
        $_SESSION["ownerName"] = $row["ownerName"];

        // Redirect to the owner dashboard or any other desired page
        header("location: dashboard/owner_dashboard.php");
        exit();
    } else {
        // Authentication failed
        $error_message = "Invalid credentials. Please try again.";
    }

    // Close the database connection
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Owner Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="nav container">
            <a href="index.php" class="logo"><i class='bx bx-home'></i>Tenants Management System </a>
        </div>
    </header>

    <div class="login container">
        <div class="login-container">
            <h2>Welcome Back</h2>
            <?php
            if (isset($error_message)) {
                echo "<p class='error-message'>$error_message</p>";
            }
            ?>
            <form action="" method="post">
                <span>Email Address</span>
                <input type="text" name="ownerEmail" id="ownerEmail" placeholder="owneremail@gmail.com" required>
                <span>Password</span>
                <input type="password" name="ownerPassword" id="ownerPassword" placeholder="Password" required>
                <button type="submit">Login</button>
            </form>
            <p>Don't Have An Account?</p>
            <a href="startmembership.php" class="btn">Sign Up</a>
        </div>
    </div>

</body>
</html>
