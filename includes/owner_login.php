<?php

include ("dbcon.php");

if(isset($_POST["ownerSubmit"])){
    $ownerEmail = $_POST ["ownerEmail"];
    $ownerPassword = $_POST ["ownerPassword"]; 
    $result = mysqli_query($con, "SELECT * FROM owners WHERE ownerEmail = '$ownerEmail' or ownerPassword = '$ownerPassword'");
    $row =(mysqli_fetch_assoc($result));
    if(mysqli_num_rows($result) > 0){
        if($ownerPassword == $row["ownerPassword"]){
            $_SESSION["login"] = true;
            $_SESSION["id"] = $row["id"];
            header("location: dashboard/owner_dashboard.php");
        }
        else
        {
            echo
            "<script> alert('Wrong password'); </script>";
        }
    }
    else{
        echo
            "<script>alert ('User Not Registered');</script>";  
    }

}
if ($row['username'] == $username && $row['password'] == $password) {
    $_SESSION['apartmentID'] = $row['apartmentID'];
    $_SESSION['login'] = true;
    header("location: owner_dashboard.php");
    exit();
} else {
    echo "<script>alert('Login failed. Please check your username and password.');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Property Owner Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="nav container">
            <a href="index.php" class="logo"><i class='bx bx-home'></i>Tenants Management System </a>
           
            <a href="index.php" class="btn">Home</a>
        </div>

    </header>
    <div class="login container">
        <div class="login-container">
            <h2>Welcome Back</h2>
            <form action="" method="post">
                <span>Email Address</span>
                <input type="text" name="ownerEmail" id="" placeholder="owneremail@gmail.com" required>                
                <span>Enter your password</span>
                <input type="password" name="ownerPassword" id="" placeholder="password" required>
                <button type="submit" name="ownerSubmit">Log In </button>                   
                <p>Don't Have An Account!</p>
            </form>
            <a href="startmembership.php" class="btn">Sign Up</a>
        </div>
    </div>
    
<?php include('includes/footer.php'); ?>