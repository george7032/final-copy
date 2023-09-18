<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
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
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .logo {
            font-size: 24px;
            color: white;
            text-decoration: none;
        }

        .navbar {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .navbar li {
            display: inline;
            margin-right: 20px;
        }

        .navbar a {
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            transition: color 0.3s;
        }

        .navbar a:hover {
            color: #00563F;
        }

        /* Dashboard Content */
        .dashboard-content {
            max-width: 1200px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .dashboard-content h1 {
            color: #00563F;
            margin-bottom: 20px;
        }

        .dashboard-content p {
            font-size: 16px;
            color: #333;
            line-height: 1.5;
        }

        /* Payments Section */
        .payments.container {
            background-color: #f7f7f7;
            padding: 20px;
            margin-top: 20px;
            border-radius: 5px;
        }

        .payments h2 {
            color: #00563F;
            margin-bottom: 10px;
            font-size: 20px;
        }

        .payments input[type="submit"] {
            background-color: #00563F;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .payments input[type="submit"]:hover {
            background-color: #00cc99;
        }
    </style>
    <header>
        <div class="nav container">
            <a href="#" class="logo"><i class='bx bx-home'></i>Tenant Management System</a>
            <ul class="navbar">
                <li><a href="#dashboard">Dashboard</a></li>
                <li><a href="#payments">Payments</a></li>
                <li><a href="#maintenance">Maintenance</a></li>
                <li><a href="../gpt1/logout.php">Logout</a></li>
            </ul>
        </div>
    </header>

    <section class="dashboard-content" id="dashboard">
        <h1>Welcome</h1>
        <p>This is your tenant dashboard. You can view your information and perform various actions here.</p>
    </section>

    <section class="dashboard-content" id="payments">
        <h1>Payments</h1>
        <section class="payments container">
        <h2>Make a Payment</h2>
        <form action="process_payment.php" method="post">
            <input type="submit" name="submit_payment" value="Make Payment">
        </form>
    </section>
        <p>View your payment history and make new payments here.</p>
    </section>

    <section class="dashboard-content" id="maintenance">
        <h1>Maintenance</h1>
        <p>Submit maintenance requests and view updates on ongoing maintenance.</p>
    </section>


</body>
</html>