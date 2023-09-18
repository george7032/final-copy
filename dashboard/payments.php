<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("location: ../owner_login.php"); // Redirect to the login page if not logged in
    exit();
}

include("../dbcon.php"); // Adjust the path as needed

// Fetch apartmentID from the session (assuming it's stored in the session)


$apartmentID = $_SESSION["apartmentID"];

// Query the database to retrieve payment information
$query = "SELECT p.* 
          FROM payments p
          INNER JOIN tenants t ON p.tenantID = t.tenantID
          WHERE t.apartmentID = ?";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $apartmentID);
$stmt->execute();
$result = $stmt->get_result();

// Include any necessary CSS or JavaScript files
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Invoices</title>
    <!-- Include your CSS and JavaScript files here -->
</head>
<body>
<style>
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

/* Navigation */
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

/* Container */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Table Styles */
h2 {
    color: #00563F;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

table, th, td {
    border: 1px solid #ddd;
}

th, td {
    padding: 12px;
    text-align: left;
}

th {
    background-color: #00563F;
    color: white;
}

/* Logout Button */
.btn-logout {
    display: block;
    background-color: #00563F;
    color: white;
    border: none;
    padding: 10px 20px;
    margin-top: 20px;
    border-radius: 5px;
    font-weight: bold;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-logout:hover {
    background-color: #00cc99;
}

/* Adjust your other styles as needed */
</style>

    <header>
        <div class="nav container">
            <a href="#" class="logo"><i class='bx bx-home'></i>Tenant Management System</a>
            <a href="../owner_dashboard.php">Dashboard</a>
            <a href="../owner_logout.php" class="btn">Logout</a>
        </div>
    </header>

    <section class="container">
        <h2>Payment Invoices</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Description</th>
                    <!-- Add additional columns as needed for payment details -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through payment data and display it in the table
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["paymentDate"] . "</td>";
                    echo "<td>" . $row["amount"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    // Add additional table cells for more payment details
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <!-- Include your footer if necessary -->
</body>
</html>
