<?php
session_start();
include('dbcon.php');

// Check if the tenant is logged in
if (!isset($_SESSION['tenantID'])) {
    header("Location: tenant_login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenantID = $_SESSION['tenantID'];
    $complaint = $_POST['complaint'];
    $requestDate = date('Y-m-d'); // Current date

    // Insert the maintenance request into the database
    $query = "INSERT INTO maintenance_requests (tenantID, complaint, requestDate) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("iss", $tenantID, $complaint, $requestDate);

    if ($stmt->execute()) {
        header("Location: tenant_dashboard.php");
        exit();
    } else {
        // Error occurred
        echo "<script>alert('An error occurred while submitting the request. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance Request</title>
    <style>
        .dashboard-content h1 {
            color: #00563F;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        button[type="submit"] {
            background-color: #00563F;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button[type="submit"]:hover {
            background-color: #00cc99;
        }
    </style>
</head>
<body>
<?php include('../project/dashboard/header1.php')?>


    <section class="dashboard-content">
        <h1>Maintenance Request Form</h1>
        <form action="" method="post">
            <label for="complaint">Describe Your Maintenance Request:</label>
            <textarea name="complaint" id="complaint" rows="5" required></textarea>
            <button type="submit" name="submit_request">Submit Request</button>
        </form>
    </section>


</body>
</html>
