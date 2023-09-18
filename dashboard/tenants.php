<?php
include '../dbcon.php';

if (isset($_POST['resetPassword'])) {
    $tenantID = $_POST['tenantID'];
    $newPassword = $_POST['newPassword'];
    $query = "UPDATE tenants SET tenantPassword = ? WHERE tenantID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("si", $newPassword, $tenantID);

    if ($stmt->execute()) {
        echo "<script>alert('Password reset successful.');</script>";
    } else {
        echo "<script>alert('Password reset failed.');</script>";
    }
}

$query = "SELECT * FROM tenants"; 
$result = $con->query($query);

if (!$result) {
    echo "Error: " . $con->error;
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="your-css-file.css">
    <style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    background-color: white;
    color: black;
    font-family: Arial, sans-serif;
}

.tenant-container {
    border: 1px solid #ddd;
    padding: 20px;
    margin: 20px 0;
    background-color: #f9f9f9;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

.tenant h2 {
    margin-top: 0;
}

.tenant p {
    margin: 5px 0;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

form {
    display: inline-block;
    margin-right: 5px;
}

form input[type="password"] {
    width: 150px;
    padding: 5px;
    margin-right: 5px;
}

form button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 5px 10px;
    cursor: pointer;
    border-radius: 3px;
    text-transform: uppercase;
    font-weight: bold;
}

.success-message, .error-message {
    margin-top: 10px;
    padding: 10px;
    border-radius: 5px;
}

.success-message {
    background-color: #28a745;
}

.error-message {
    background-color: #dc3545;
}

header {
    background-color: #2ecc71;
    color: #fff;
    padding: 20px;
    text-align: center;
    transition: background-color 0.3s;
}

.owner-header h1 {
    font-size: 24px;
    margin: 0;
}

.owner-header a {
    color: #fff;
    text-decoration: none;
    margin: 0 10px;
}

.owner-header .btn {
    background-color: #e74c3c;
    padding: 10px 20px;
    border: none;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.owner-header .btn:hover {
    background-color: #c0392b;
}

header:hover {
    background-color: #27ae60;
}

    </style>
</head>
<body>
    <header>
        <div class="owner-header">
            <h1>List of Tenants</h1><br><br>
            <a href="../dashboard/owner_dashboard.php">Dashboard</a>
            <a href="../logout.php" class="">Logout</a>
        </div>
    </header>

    <section class="container">
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<div class='tenant-container'>";
            
            echo "<div class='tenant'>";
            echo "<h2>Tenant Details</h2>";
            echo "<p><strong>Name:</strong> " . $row["tenantName"] . "</p>";
            echo "<p><strong>Unit Number:</strong> " . $row["apartmentNumber"] . "</p>";
            echo "<p><strong>Email:</strong> " . $row["tenantEmail"] . "</p>";
            echo "<p><strong>Rent Amount:</strong> $" . $row["amountToBePaid"] . "</p>";
            echo "</div>";

            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Date</th>";
            echo "<th>Amount</th>";
            echo "<th>Description</th>";
            echo "<th>Actions</th>"; 
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            $tenantID = $row["tenantID"];
            $paymentQuery = "SELECT * FROM payments WHERE tenantID = ?";
            $paymentStmt = $con->prepare($paymentQuery);
            $paymentStmt->bind_param("i", $tenantID);
            $paymentStmt->execute();
            $paymentResult = $paymentStmt->get_result();

            while ($paymentRow = $paymentResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $paymentRow["paymentDate"] . "</td>";
                echo "<td>$" . $paymentRow["amount"] . "</td>";
                echo "<td>" . $paymentRow["description"] . "</td>";
                echo "<td>";
                
                echo "<form action='tenants.php' method='post'>";
                echo "<input type='hidden' name='tenantID' value='" . $tenantID . "'>";
                echo "<input type='password' name='newPassword' placeholder='New Password' required>";
                echo "<button type='submit' name='resetPassword'>Reset Password</button>";
                echo "</form>";
                
                echo "<form action='tenants.php' method='post'>";
                echo "<input type='hidden' name='tenantID' value='" . $tenantID . "'>";
                echo "<button type='submit' name='deleteTenant'>Delete</button>";
                echo "</form>";

                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

            echo "</div>";
        }
        ?>
    </section>
</body>
</html>
