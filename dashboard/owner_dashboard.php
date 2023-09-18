<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: ../owner_login.php');
    exit();
}

include('../dbcon.php');

// Authenticate owner and retrieve apartmentID
$ownerID = $_SESSION['id'];
$query = "SELECT apartmentID FROM owners WHERE ownerID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('s', $ownerID);
$stmt->execute();
$stmt->bind_result($apartmentID);

if ($stmt->fetch()) {
    $_SESSION['apartmentID'] = $apartmentID; // Set apartmentID in the session
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <style>
        /* CSS for owner_dashboard.php */

body {
    font-family: Arial, sans-serif;
    background-color: #f0f0f0;
    margin: 0;
    padding: 0;
}

header {
    background-color: #00563F;
    color: white;
    padding: 20px 0;
}

.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.logo {
    text-decoration: none;
    color: white;
    font-size: 24px;
}

.navbar {
    list-style-type: none;
    padding: 0;
    display: flex;
}

.navbar li {
    margin-right: 20px;
}

.navbar a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    transition: color 0.3s;
}

.navbar a:hover {
    color: #00cc99;
}

.dashboard,
.payments,
.maintenance,
.tenants {
    padding: 50px 0;
    background-color: white;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 20px;
}

.dashboard h1,
.payments h1,
.maintenance h1,
.tenants h1 {
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
}

.dashboard h2,
.payments h2,
.maintenance h2 {
    font-size: 24px;
    margin-bottom: 20px;
}

.btn {
    display: inline-block;
    background-color: #00563F;
    color: white;
    text-decoration: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
    transition: background-color 0.3s;
    margin-top: 10px;
}

.btn:hover {
    background-color: #00cc99;
}

/* Add more CSS rules here to style your dashboard sections as needed */


    </style>
    <header>
        <div class="nav container">
            <a href="../index.php" class="logo"><i class='bx bx-home'></i>Tenants Management System</a>
            <ul class="navbar">
                <li><a href="#dashboard">Dashboard</a></li>
                <li><a href="../dashboard/payments.php">Payments</a></li>
                <li><a href="../dashboard/maintenance.php">Maintenance</a></li>
                <li><a href="../dashboard/tenants.php">Tenants</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <section class="dashboard container" id="dashboard">
        <h1>Dashboard</h1>
        <!-- Add content for the dashboard, e.g., property info, rent summary by month, etc. -->
        <!-- Example: -->
        <div class="property-info">
            <h2>Property Information</h2>
            <!-- Display property information here -->
        </div>
        <div class="rent-summary">
            <h2>Rent Summary</h2>
            <!-- Display rent summary by month here -->
        </div>
    </section>

    <section class="payments container">
        <!-- Add content for the Payments section -->
        <h1>Payments</h1>
        <!-- Example: List of payment invoices -->
    </section>

    <section class="maintenance container">
        <!-- Add content for the Maintenance section -->
        <h1>Maintenance</h1>
        <!-- Example: Chat space for maintenance requests -->
    </section>

    <section class="tenants container">
        <h1>Tenants</h1>
        <!-- Display a list of tenants with links to their profiles -->
        <a href="add_tenant.php" class="btn">Add Tenant</a> <!-- Link to the Add Tenant page -->
        <!-- Example: -->
        <ul>
            <li><a href="tenant_profile.php?id=1">Tenant 1</a></li>
            <li><a href="tenant_profile.php?id=2">Tenant 2</a></li>
            <!-- Add more tenant entries here -->
        </ul>
    </section>
<?php include ('../includes/footer.php');?>
</body>
</html>
