<?php
include('dbcon.php');

$receiverID = $_POST['receiver_id'];

$query = "SELECT * FROM chat_messages WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY timestamp ASC";
$stmt = $con->prepare($query);
$stmt->bind_param('iiii', $_SESSION['tenantID'], $receiverID, $receiverID, $_SESSION['tenantID']);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo '<div class="message">';
    echo '<strong>' . ($row['sender_id'] == $_SESSION['tenantID'] ? 'You' : 'Owner') . ':</strong>';
    echo $row['message'];
    echo '</div>';
}
?>
