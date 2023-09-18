<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("location: ../owner_login.php"); // Redirect to the login page if not logged in
    exit();
}

include("../dbcon.php"); // Adjust the path as needed

// Fetch apartmentID from the session (assuming it's stored in the session)
$apartmentID = $_SESSION["apartmentID"];

// Query the database to retrieve payment information including tenant name
$query = "SELECT p.*, t.tenantName 
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
<style>
    /* Existing styles remain the same */

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

/* Add styles for the Tenant Name column */
td.tenant-name {
    font-weight: bold;
    color: #007bff; /* Blue color for tenant names */
}

/* Existing Logout Button styles remain the same */

/* Adjust your other styles as needed */

</style>
</head>
<body>
    <?php include('../dashboard/header1.php')?>
    <section class="container">
        <h2>Payment Invoices</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Tenant Name</th> <!-- Added Tenant Name column -->
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
                    echo "<td>" . $row["tenantName"] . "</td>";
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
