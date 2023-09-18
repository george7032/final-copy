<?php
session_start();
include('dbcon.php');

if(isset($_POST['startmembershipbtn']))
{
    $apartment_name= $_POST['apartment_name'];
    $apartment_location= $_POST['apartment_location'];
    $ownerName= $_POST['ownerName'];
    $ownerID= $_POST['ownerID'];
    $ownerPhoneNumber= $_POST['ownerPhoneNumber'];
    $ownerEmail= $_POST['ownerEmail'];
    $ownerPassword= $_POST['ownerPassword'];
    $ownerPasswordConfirm= $_POST['ownerPasswordConfirm'];
    $apartmentID= $_POST['apartmentID'];
    $duplicate = mysqli_query($con, "SELECT * FROM owners WHERE apartmentID = '$apartmentID' or ownerEmail = '$ownerEmail'");
    if (mysqli_num_rows($duplicate) >0 ){
        echo
        "<script>alert ('Apartment ID or email is already taken');</script>";
    }
    else
    {
        if ($ownerPassword == $ownerPasswordConfirm)
        {
            $query = "INSERT INTO owners (apartmentID, apartment_name, apartment_location, ownerName, ownerID, ownerPhoneNumber, ownerEmail, ownerPassword) VALUES ('$apartmentID', '$apartment_name', '$apartment_location', '$ownerName', '$ownerID', '$ownerPhoneNumber', '$ownerEmail', '$ownerPassword')";
            mysqli_query($con, $query);
            echo
            "<script>alert ('Registration Successful');</script>";             
        }
        else
        {
            echo
            "<script>alert ('Passwords Do Not Match');</script>";  
        };
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Membership</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <header>
        <div class="nav container">
            <a href="index.php" class="logo"><i class='bx bx-home'></i>Tenant Management System</a>
            <a href="owner_login.php" class="btn">Owner Login</a>
        </div>
    </header>
        <section class="startmembership container">
            <div class="apartmentDetails">
                <form action="" method="post">
                    <h4>Welcome</h4>
                    <br><br><br><br><br>
                        <h2>Apartment Details</h2>
                        <label for="apartment_name">Name of the Apartment: </label>
                        <input type="text" name="apartment_name" required><br>
                        <label for="location" required>Location: </label>
                        <input type="text" name="apartment_location">
                        <h2>Owner Details</h2>
                        <label for="ownerName">Name: </label>
                        <input type="text" id="ownerName" name="ownerName" required><br>
                    
                        <label for="ownerID">Identity Number: </label>
                        <input type="text" id="ownerID" name="ownerID" required><br>
                        
                        <label for="ownerPhoneNumber">Phone Number: </label>
                        <input type="text" id="ownerPhoneNumber" name="ownerPhoneNumber" required><br>
                    
                        <label for="ownerEmail">Email: </label>
                        <input type="email" id="ownerEmail" name="ownerEmail" required><br>
                    
                        <label for="ownerPassword">Create Password: </label>
                        <input type="password" id="ownerPassword" name="ownerPassword" required><br>
                    
                        <label for="ownerPasswordConfirm">Re-Write Password: </label>
                        <input type="password" id="ownerPasswordConfirm" name="ownerPasswordConfirm" required><br>

                        <label for="apartmentID">Select Apartment ID</label>
                        <select name="apartmentID" id="apartmentID" required>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>
                            <option value="31">31</option>
                            <option value="32">32</option>
                            <option value="33">33</option>
                            <option value="34">34</option>
                            <option value="35">35</option>
                            <option value="36">36</option>
                            <option value="37">37</option>
                            <option value="38">38</option>
                            <option value="39">39</option>
                            <option value="40">40</option>
                            <option value="41">41</option>
                            <option value="42">42</option>
                            <option value="43">43</option>
                            <option value="44">44</option>
                            <option value="45">45</option>
                            <option value="46">46</option>
                            <option value="47">47</option>
                            <option value="48">48</option>
                            <option value="49">49</option>
                            <option value="50">50</option>
                        </select>
                    <button type="submit" name="startmembershipbtn">Submit</button>                   
                </form>
            </div>
        </section>
</body> 
<?php include('includes/footer.php') ?>