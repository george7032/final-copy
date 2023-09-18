<?php
// Include the database connection
include('../dbcon.php');

// Check if the owner is logged in, otherwise redirect to the login page
if (!isset($_SESSION['login'])) {
    header("location: ../owner_login.php");
    exit();
}

// Fetch tenant data from the database
$apartmentID = $_SESSION['id'];
$query = "SELECT * FROM tenants WHERE apartmentID = '$apartmentID'";
$result = mysqli_query($con, $query);

// Handle password reset form submission
if (isset($_POST['resetPasswordSubmit'])) {
    $tenantID = $_POST['tenantID'];
    $newPassword = $_POST['newPassword'];

    // Update the tenant's password in the database
    $updateQuery = "UPDATE tenants SET tenantPassword = '$newPassword' WHERE tenantID = '$tenantID'";

    if (mysqli_query($con, $updateQuery)) {
        echo "<script>
                Swal.fire({
                    title: 'Password Reset',
                    text: 'Tenant password has been reset successfully!',
                    icon: 'success',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.reload();
                    }
                });
              </script>";
    } else {
        echo "<script>
                Swal.fire({
                    title: 'Password Reset Failed',
                    text: 'Error: " . mysqli_error($con) . "',
                    icon: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
              </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant List</title>
    <link rel="stylesheet" href="style.css">
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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

.owner-dashboard h1 {
    font-size: 28px;
    margin-bottom: 20px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f2f2f2;
}

/* Reset Password Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.7);
}

.modal-content {
    background-color: #fff;
    margin: 10% auto;
    padding: 20px;
    width: 70%;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
}

.close {
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: #00cc99;
}

#resetPasswordForm {
    margin-top: 20px;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

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
    <header>`
        <div class="nav container">
            <a href="#" class="logo"><i class='bx bx-home'></i>Tenants Management System</a>
            <ul class="navbar">
                <li><a href="owner_dashboard.php">Dashboard</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="maintenance.php">Maintenance</a></li>
                <li><a href="tenants.php">Tenants</a></li>
                <li><a href="logout.php">Logout</a q></li>
            </ul>
        </div>
    </header>

    <section class="owner-dashboard container">
        <h1>Tenant List</h1>
        <table>
            <tr>
                <th>Name</th>
                <th>ID</th>
                <th>Apartment Number</th>
                <th>Amount to be Paid</th>
                <th>Email Address</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo $row['tenantName']; ?></td>
                    <td><?php echo $row['tenantID']; ?></td>
                    <td><?php echo $row['apartmentNumber']; ?></td>
                    <td><?php echo $row['amountToBePaid']; ?></td>
                    <td><?php echo $row['tenantEmail']; ?></td>
                    <td>
                        <button onclick="resetPassword('<?php echo $row['tenantID']; ?>')">Reset Password</button>
                    </td>
                </tr>
            <?php endwhile; ?>
        </table>
    </section>

    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Reset Tenant Password</h2>
            <form id="resetPasswordForm" method="post" action="">
                <input type="hidden" id="tenantID" name="tenantID" value="">
                <label for="newPassword">New Password:</label>
                <input type="password" id="newPassword" name="newPassword" required>
                <button type="submit" name="resetPasswordSubmit">Reset Password</button>
            </form>
        </div>
    </div>

    <!-- Include SweetAlert2 Script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function resetPassword(tenantID) {
            // Set the tenantID in the hidden input field
            document.getElementById('tenantID').value = tenantID;

            // Show the reset password modal
            var modal = document.getElementById('resetPasswordModal');
            modal.style.display = 'block';
        }

        function closeModal() {
            // Close the reset password modal
            var modal = document.getElementById('resetPasswordModal');
            modal.style.display = 'none';
        }
    </script>
</body>
</html>
