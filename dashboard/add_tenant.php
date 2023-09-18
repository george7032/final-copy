<?php
session_start();
include('../dbcon.php');

if (!isset($_SESSION['login'])) {
    header("location: ../owner_login.php");
    exit();
}



if (isset($_POST['addTenantSubmit'])) {
    $apartmentID = $_SESSION['apartmentID'];
    $tenantName = $_POST['tenantName'];
    $tenantID = $_POST['tenantID'];
    $apartmentNumber = $_POST['apartmentNumber'];
    $amountToBePaid = $_POST['amountToBePaid'];
    $tenantEmail = $_POST['tenantEmail'];
    $tenantPassword = $_POST['tenantPassword'];

    $checkQuery = "SELECT * FROM tenants WHERE apartmentNumber = '$apartmentNumber' AND apartmentID = '$apartmentID'";
    $checkResult = mysqli_query($con, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Apartment number already exists for this owner.');</script>";
    } else {
        $query = "INSERT INTO tenants (apartmentID, tenantName, tenantID, apartmentNumber, amountToBePaid, tenantEmail, tenantPassword)
                  VALUES ('$apartmentID', '$tenantName', '$tenantID', '$apartmentNumber', '$amountToBePaid', '$tenantEmail', '$tenantPassword')";

        if (mysqli_query($con, $query)) {
            echo "<script>alert('Tenant added successfully');</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Tenant - Owner Dashboard</title>
    <link rel="stylesheet" href="css/add_tenant.css">
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

.add-tenant {
    padding: 50px 0;
}

.tenant-form {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.tenant-form h1 {
    font-size: 28px;
    margin-bottom: 20px;
    text-align: center;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;
}

button[type="submit"] {
    background-color: #00563F;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
    cursor: pointer;
    transition: background-color 0.3s;
}

button[type="submit"]:hover {
    background-color: #00cc99;
}


    </style>
    <header>
        <div class="nav container">
            <a href="index.php" class="logo"><i class='bx bx-home'></i>Tenants Management System</a>
            <ul class="navbar">
                <li><a href="owner_dashboard.php">Dashboard</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="maintenance.php">Maintenance</a></li>
                <li><a href="tenants.php">Tenants</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <section class="add-tenant container">
        <div class="tenant-form">
            <h1>Add Tenant</h1>
            <form action="" method="post">
                <label for="tenantName">Tenant's Name:</label>
                <input type="text" name="tenantName" required>

                <label for="tenantID">Tenant's ID:</label>
                <input type="text" name="tenantID" required>

                <label for="apartmentNumber">Apartment Number:</label>
                <input type="text" name="apartmentNumber" required>

                <label for="amountToBePaid">Amount to Be Paid:</label>
                <input type="text" name="amountToBePaid" required>

                <label for="tenantEmail">Tenant's Email:</label>
                <input type="email" name="tenantEmail" required>

                <label for="tenantPassword">Create Password:</label>
                <input type="password" name="tenantPassword" required>

                <button type="submit" name="addTenantSubmit">Add Tenant</button>
            </form>
        </div>
    </section>

</body>
</html>
