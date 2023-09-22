<?php
include ('dbcon.php');
$query = "SELECT m.*, t.tenantName, t.apartmentNumber 
          FROM maintenance_requests m
          INNER JOIN tenants t ON m.tenantID = t.tenantID";
$result = $con->query($query);

if (!$result) {
    die("Database query failed: " . $con->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Requests</title>
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

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .maintenance-request {
        background-color: #fff;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        border-radius: 5px;
    }

    .maintenance-request h1 {
        color: #00563F;
        font-size: 24px;
        margin-bottom: 10px;
    }

    .maintenance-request p {
        font-size: 16px;
        color: #333;
        line-height: 1.5;
    }

</style>
</head>
<body>
<?php include('../project/dashboard/header1.php')?>>

    <div class="container">
        <?php
        // Loop through the results and display each maintenance request in a container
        while ($row = $result->fetch_assoc()) {
            echo "<div class='maintenance-request'>";
            echo "<h1>Maintenance Request</h1>";
            echo "<p>Tenant Name: " . $row["tenantName"] . "</p>";
            echo "<p>Apartment Number: " . $row["apartmentNumber"] . "</p>";
            echo "<p>Complaint: " . $row["complaint"] . "</p>";
            echo "<p>Request Date: " . $row["requestDate"] . "</p>";
            // You can add more details from the maintenance_requests table as needed
            echo "</div>";
        }

        // Close the database connection
        $con->close();
        ?>
    </div>
</body>
</html>
