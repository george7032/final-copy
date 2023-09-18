<?php
session_start();
if (!isset($_SESSION["login"]) || $_SESSION["login"] !== true) {
    header("location: ../owner_login.php"); 
    exit();
}

include("../dbcon.php"); 


$ownerID = $_SESSION["id"];
$query = "SELECT * FROM owners WHERE id = ?";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $ownerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $ownerData = $result->fetch_assoc();
} else {
    header("location: ../owner_login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
</head>
<body>
    <header>
        <div class="nav container">
            <a href="#" class="logo"><i class='bx bx-home'></i>Tenant Management System</a>
            <a href="dashboard/owner_dashboard.php">Dashboard</a>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </header>

    <section class="container">
        <h2>Maintenance</h2>
        <div class="chat-container">
        </div>
        <form id="chat-form">
            <input type="text" id="message" placeholder="Type your message..." required>
            <button type="submit">Send</button>
        </form>
    </section>

</body>
</html>
