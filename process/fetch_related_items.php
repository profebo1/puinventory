<?php
session_start();
include 'connect.php';

if (isset($_POST['itemid'])) {
    $itemid = $_POST['itemid'];
    $sql = "SELECT batch_id, item_id, cost, entryDate FROM stock_batches WHERE item_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param('s', $itemid);
    $stmt->execute();
    $result = $stmt->get_result();

    $items = [];
    while ($row = $result->fetch_assoc()) {
        $items[] = $row;
    }

    echo json_encode($items);
} else {
    echo json_encode(['error' => 'Item ID is missing']);
}
