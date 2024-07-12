<?php
include_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['curuser']) && !empty($_GET['curuser'])) {
        global $mysqli;

        $supplierId = $_POST['supplierId'];
        $supplierName = $_POST['supplierName'];
        $contactPerson = $_POST['contactPerson'];
        $contactNumber = $_POST['contactNumber'];
        $address = $_POST['address'];

        $sql = "INSERT INTO suppliers (itemid, itemName, itemDesc) VALUES (?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {

            echo json_encode(['success' => 'New Item added to Stocks successfully']);

            $stmt_levels->close();
        } else {
            echo json_encode(['error' => 'Error preparing statement: ' . $mysqli->error]);
        }
    }
} else {
    echo json_encode(['error' => 'User not specified or empty']);
}

$mysqli->close();
