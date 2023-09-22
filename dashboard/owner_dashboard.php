<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header('location: ../owner_login.php');
    exit();
}

include('../dbcon.php');

$ownerID = $_SESSION['id'];
$query = "SELECT apartmentID FROM owners WHERE ownerID = ?";
$stmt = $con->prepare($query);
$stmt->bind_param('s', $ownerID);
$stmt->execute();
$stmt->bind_result($apartmentID);

if ($stmt->fetch()) {
    $_SESSION['apartmentID'] = $apartmentID; 
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



    </style>
    <header>
            <div class="nav container">
                <a href="../index.php" class="logo"><i class='bx bx-home'></i>Tenants Management System</a>
                <ul class="navbar">
                    <li><a href="#dashboard">Dashboard</a></li>
                    <li><a href="../dashboard/payments.php">Payments</a></li>
                    <li><a href="../view_maintenance_request.php">Maintenance</a></li>
                    <li><a href="../dashboard/tenants.php">Tenants</a></li>
                   <!-- <li><a href="../owner_chat.php">Chat</a></li> -->
                    <li><a href="../logout.php">Logout</a></li>
                </ul>
            </div>
    </header>

    <section class="tenants container">
        <h1>Tenants</h1>
        <a href="add_tenant.php" class="btn">Add Tenant</a> 
    </section>

    <section class="dashboard container" id="dashboard">
    <h1>Dashboard</h1>
    <div class="property-info">
        <!-- Property information goes here -->
    </div>

    <!-- Add this section to display the total payments -->
    <section class="total-payments container">
        <h2>Total Payments Made</h2>
        <?php
        // Calculate the total payments made by tenants
        $query = "SELECT SUM(amount) AS totalPayments FROM payments WHERE tenantID IN (SELECT tenantID FROM tenants WHERE apartmentID = ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $_SESSION['apartmentID']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $totalPayments = $row['totalPayments'];
        ?>
        <p>Total payments made by tenants: $<?php echo number_format($totalPayments, 2); ?></p>
    </section>
</section>


    <section class="maintenance container">
        <h1>Maintenance</h1>
    </section>


<?php include ('../includes/footer.php');?>
</body>
</html>
