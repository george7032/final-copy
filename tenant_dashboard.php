<?php
include("../gpt1/dbcon.php");
session_start();
$tenantID = $_SESSION["tenantID"];
$query = "SELECT * FROM tenants WHERE tenantID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $tenantID);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
if (!empty($row)) {
    $rentalAmount = $row["amountToBePaid"];
    $query = "SELECT SUM(amount) AS totalPaid FROM payments WHERE tenantID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $tenantID);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $totalPaid = $row["totalPaid"];

    $balance = $rentalAmount - $totalPaid;
} else 
{
    $balance = "N/A";
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body, h1, h2, p {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        header {
            background-color: #00563F;
            color: white;
            padding: 20px 0;
        }

        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            color: white;
            text-decoration: none;
        }

        .navbar {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .navbar li {
            display: inline;
            margin-right: 20px;
        }

        .navbar a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #00563F;
        }

        .dashboard-content {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .dashboard-content h1 {
            color: #00563F;
            margin-bottom: 20px;
        }

        .dashboard-content p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        .payments.container {
            background-color: #f7f7f7;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .payments h2 {
            color: #00563F;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .payments input[type="submit"] {
            background-color: #00563F;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .payments input[type="submit"]:hover {
            background-color: #00cc99;
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

        #maintenance {
            margin-top: 20px;
        }

        #maintenance h1 {
            color: #00563F;
        }

        #maintenance p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

    </style>
</head>
<body>
    <header>
        <div class="nav container">
            <a href="#" class="logo"><i class='bx bx-home'></i>Tenant Management System</a>
            <ul class="navbar">
                <li><a href="#dashboard">Dashboard</a></li>
                <li><a href="../dashboard/payment">Payments</a></li>
                <li><a href="#maintenance">Maintenance</a></li>
                <li><a href="../gpt1/logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <section class="dashboard-content" id="dashboard">
    </section>
    <h2>Balance: $<?php echo $balance; ?></h2>

    <section class="dashboard-content" id="payments">
        <h1>Payments</h1>
        <section class="payments container">
            <h2>Make a Payment</h2>
            <form action="process_payment.php" method="post">
                <input type="submit" name="submit_payment" value="Make Payment">
            </form>
        </section>
        <h2>Payment History</h2>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Amount Paid</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $tenantID = $_SESSION["tenantID"];
                $query = "SELECT p.*, t.tenantName 
                          FROM payments p
                          INNER JOIN tenants t ON p.tenantID = t.tenantID
                          WHERE p.tenantID = ?";
                $stmt = $con->prepare($query);
                $stmt->bind_param("i", $tenantID);
                $stmt->execute();
                $result = $stmt->get_result();

                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["paymentDate"] . "</td>";
                    echo "<td>" . $row["tenantName"] . "</td>";
                    echo "<td>$" . $row["amount"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <section class="dashboard-content" id="maintenance">
        <h1>Maintenance</h1>
        <p>Submit maintenance requests and view updates on ongoing maintenance.</p>
    </section>


</body>
</html> 