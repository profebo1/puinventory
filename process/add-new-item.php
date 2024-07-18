<?php
include_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['curuser']) && !empty($_GET['curuser'])) {
        global $mysqli;

        $itemCode = $_POST['itemCode'];
        $itemName = $_POST['itemName'];
        $itemDesc = $_POST['itemDescription'];

        $sql = "INSERT INTO stocks (itemid, itemName, itemDesc) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sss', $itemCode, $itemName, $itemDesc);
            if ($stmt->execute()) {
                $stmt->close();
                $sql = "INSERT INTO stock_entries (itemid) VALUES (?)";
                if ($stmt_levels = $mysqli->prepare($sql)) {
                    $stmt_levels->bind_param('s', $itemCode);
                    if ($stmt_levels->execute()) {
                        echo json_encode(['success' => 'New Item added to Stocks successfully']);
                    } else {
                        echo json_encode(['error' => 'Error adding item to stocks: ' . $stmt->error]);
                    }
                }
                $stmt_levels->close();
            } else {
                echo json_encode(['error' => 'Error preparing statement: ' . $mysqli->error]);
            }
        }
    } else {
        echo json_encode(['error' => 'User not specified or empty']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}
$mysqli->close();
