<style>
    header {
        background-color: #00563F;
        color: white;
        padding: 20px 0;
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

</style>
<header>
        <div class="nav container">
            <a href="../index.php" class="logo"><i class='bx bx-home'></i>Tenants Management System</a>
            <ul class="navbar">
                <li><a href="../dashboard/owner_dashboard.php">Dashboard</a></li>
                <li><a href="../dashboard/payments.php">Payments</a></li>
                <li><a href="../dashboard/maintenance.php">Maintenance</a></li>
                <li><a href="../dashboard/tenants.php">Tenants</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>
        </div>
</header>
