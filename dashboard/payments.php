<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("location: ../owner_login.php"); 
    exit();
}

include("../dbcon.php"); 

$apartmentID = $_SESSION["apartmentID"];

$query = "SELECT p.*, t.tenantName 
          FROM payments p
          INNER JOIN tenants t ON p.tenantID = t.tenantID
          WHERE t.apartmentID = ?";

$stmt = $con->prepare($query);
$stmt->bind_param("i", $apartmentID);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<style>

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

td.tenant-name {
    font-weight: bold;
    color: #007bff; /* Blue color for tenant names */
}

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
                    <th>Tenant Name</th> 
                    <th>Amount</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["paymentDate"] . "</td>";
                    echo "<td>" . $row["tenantName"] . "</td>";
                    echo "<td>" . $row["amount"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

</body>
</html>
