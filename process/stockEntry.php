<?php

session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once('connect.php');

// Ensure the response is JSON
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['itemCode-addup']) && !empty($_POST['itemCode-addup']) &&
        isset($_POST['Units-addup']) && !empty($_POST['Units-addup'])
    ) {

        $itemid = $_POST['itemCode-addup'];
        $newStock = (int)$_POST['newStock-addup'];
        $oldQty = (int)$_POST['currentStock-addup'];
        $units = (int)$_POST['Units-addup'];

        if ($units <= 0) {
            echo json_encode(['error' => 'Units must be greater than zero']);
            exit();
        }

        $newQty = $newStock * $units;
        $newTotal = $newQty + $oldQty;
        $enteredBy = $_SESSION['uname'];
        $cost = (float)$_POST['cost-addup'];

        if ($newQty == 0) {
            echo json_encode(['error' => 'New quantity must be greater than zero']);
            exit();
        }

        $unitCost = $cost / $newQty;

        $mysqli->begin_transaction();
        $batchRand = "BCHN-" . rand(100000000, 999999999);

        try {
            $sql = "INSERT INTO stock_entries (itemid, batch_id, new_qty, old_qty, total_qty, entered_by) VALUES (?, ?, ?, ?, ?, ?)";
            if ($stmt = $mysqli->prepare($sql)) {
                $stmt->bind_param('ssiiis', $itemid, $batchRand, $newQty, $oldQty, $newTotal, $enteredBy);
                if (!$stmt->execute()) {
                    throw new Exception('Error saving stock entries record');
                }
                $stmt->close();
            } else {
                throw new Exception('Error preparing SQL statement for stock entries');
            }

            for ($i = 1; $i <= $newQty; $i++) {
                $batchID = $batchRand . '-' . $i;
                $sqlBatch = "INSERT INTO stock_batches (batch_id, item_id, cost) VALUES (?, ?, ?)";
                if ($stmtBatch = $mysqli->prepare($sqlBatch)) {
                    $stmtBatch->bind_param('ssd', $batchID, $itemid, $unitCost);
                    if (!$stmtBatch->execute()) {
                        throw new Exception('Error saving batch record');
                    }
                    $stmtBatch->close();
                } else {
                    throw new Exception('Error preparing SQL statement for batches');
                }
            }

            $mysqli->commit();
            echo json_encode(['success' => "Stocks updated successfully for Item Code $itemid"]);
        } catch (Exception $e) {
            $mysqli->rollback();
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        echo json_encode(['error' => 'Required parameters are missing']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

$mysqli->close();
