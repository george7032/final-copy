<?php
session_start();
include('dbcon.php'); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_payment'])) {
    if (isset($_POST['amount']) && isset($_POST['description'])) {
        $amount = $_POST['amount'];
        $description = $_POST['description'];
        $tenantID = $_SESSION['tenantID'];
        $query = "INSERT INTO payments (tenantID, paymentDate, amount, description) VALUES (?, NOW(), ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ids", $tenantID, $amount, $description);

        if ($stmt->execute()) {
            echo "<script>alert('Payment successful.');</script>";
            header("location: tenant_dashboard.php");
            exit();
        } else {
            echo "<script>alert('Payment failed.');</script>";
        }
    } else {
        echo "<script>alert('Amount and description are required.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
    border-radius: 5px;
}

h2 {
    color: #00563F;
}

form {
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    color: #333;
}

input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #00563F;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 18px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #00cc99;
}

    </style>
    <header>
    </header>

    <section class="payments container">
        <h2>Make a Payment</h2>
        <form action="process_payment.php" method="post">
            <label for="amount">Amount:</label>
            <input type="text" name="amount" id="amount" required>
            
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" required>

            <input type="submit" name="submit_payment" value="Make Payment">
        </form>
    </section>
</body>
</html>
