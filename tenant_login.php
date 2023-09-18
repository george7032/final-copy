<?php
session_start();
include('dbcon.php'); // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input data
    $apartmentNumber = $_POST['apartmentNumber'];
    $tenantPassword = $_POST['tenantPassword'];

    // Query the database to check if the credentials are valid
    $query = "SELECT * FROM tenants WHERE apartmentNumber = ? AND tenantPassword = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("ss", $apartmentNumber, $tenantPassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // Tenant authentication successful
        $row = $result->fetch_assoc();

        // Store tenant information in the session
        $_SESSION['tenantID'] = $row['tenantID'];
        $_SESSION['apartmentNumber'] = $row['apartmentNumber'];
        $_SESSION['tenantName'] = $row['tenantName'];

        // Redirect to the tenant dashboard
        header("location: tenant_dashboard.php");
        exit();
    } else {
        // Authentication failed
        echo "<script>alert('Invalid credentials. Please try again.');</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="nav container">
            <a href="index.php" class="logo"><i class='bx bx-home'></i>Tenant Management System</a>
           
            <a href="owner_login.php" class="btn">Owner Login</a>
        </div>
    </header>
    <div class="login container">
        <div class="login-container">
            <h2>Login To Continue</h2>
            <p>Log in with your data that you entered <br>during your registration</p>
            <form action="" method="post">
                <span>Enter Your Unit Number</span>
                <input type="text" name="apartmentNumber" id="apartmentNumber" placeholder="Unit Number">
                <span>Enter Your Password</span>
                <input type="password" name="tenantPassword" id="tenantPassword" placeholder="Password" required>
                <button type="submit" name="tenantLogin">Log In</button>
            </form>
        </div>
    </div>
    
    <?php include('includes/footer.php') ?>
</body>
</html>
