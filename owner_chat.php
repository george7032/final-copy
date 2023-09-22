<?php
// Include the database connection and session management
include('dbcon.php');
session_start();

// Check if the owner is logged in
if (!isset($_SESSION['ownerID'])) {
    header('location: owner_login.php');
    exit();
}

// Handle sending a message
if (isset($_POST['send_message'])) {
    $message = $_POST['message'];
    $receiverID = $_POST['receiver_id']; // Tenant's ID

    // Insert the message into the database
    $query = "INSERT INTO chat_messages (sender_id, receiver_id, message) VALUES (?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('iis', $_SESSION['ownerID'], $receiverID, $message);
    $stmt->execute();
    $stmt->close();
}

// Retrieve chat history with the tenant
$tenantID = 1; // Replace with the actual tenant's ID
$query = "SELECT * FROM chat_messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC";
$stmt = $con->prepare($query);
$stmt->bind_param('iiii', $_SESSION['ownerID'], $tenantID, $tenantID, $_SESSION['ownerID']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add the following code to the <head> section of your HTML -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Function to load and display messages
            function loadMessages() {
                $.ajax({
                    url: 'load_messages.php', // Create this file to load messages
                    method: 'POST',
                    data: { receiver_id: <?php echo $ownerID; ?> },
                    success: function (response) {
                        $('#chat-container').html(response);
                    }
                });
            }

            // Load messages when the page loads
            loadMessages();

            // Submit a new message
            $('#message-form').submit(function (e) {
                e.preventDefault();
                var message = $('#message').val();

                $.ajax({
                    url: 'send_message.php', // Create this file to send messages
                    method: 'POST',
                    data: { receiver_id: <?php echo $ownerID; ?>, message: message },
                    success: function () {
                        loadMessages();
                        $('#message').val('');
                    }
                });
            });
        });
    </script>
    <style>
        /* Small container styles */
        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }

        /* Chat container styles */
        #chat-container {
            max-height: 400px;
            overflow-y: scroll;
        }

        /* Message input form styles */
        #message-form {
            margin-top: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #message {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-bottom: 10px;
        }

        button[name="send_message"] {
            background-color: #00563F;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 50%;
        }

        button[name="send_message"]:hover {
            background-color: #00cc99;
        }

        /* Scrollbar styles for chat container */
        #chat-container::-webkit-scrollbar {
            width: 8px;
        }

        #chat-container::-webkit-scrollbar-thumb {
            background-color: #00563F;
            border-radius: 10px;
        }

        #chat-container::-webkit-scrollbar-thumb:hover {
            background-color: #00cc99;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Owner Chat</h1>
        <div id="chat-container">
            <!-- Messages will be loaded here -->
        </div>
        <form id="message-form" method="post">
            <input type="text" id="message" name="message" placeholder="Type your message">
            <button type="submit" name="send_message">Send</button>
        </form>
    </div>
</body>
</html>
