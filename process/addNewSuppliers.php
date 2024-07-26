<?php
session_start();
include_once('connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['uname']) && !empty($_GET['uname'])) {
        global $mysqli;

        $supplierId = $_POST['supplierId'];
        $supplierName = $_POST['supplierName'];
        $contactPerson = $_POST['contactPerson'];
        $contactNumber = $_POST['contactNumber'];
        $supaddress = $_POST['supaddress'];

        $sql = "INSERT INTO suppliers (supplierId, supplierName, supaddress, contactPerson, contactNumber) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $mysqli->prepare($sql)) {
            $stmt->bind_param('sssss', $supplierId, $supplierName, $supaddress, $contactPerson, $contactNumber);
            echo json_encode(['success' => 'New Item added to Stocks successfully']);

            $stmt->close();
        } else {
            echo json_encode(['error' => 'Error preparing statement: ' . $mysqli->error]);
        }
    }
} else {
    echo json_encode(['error' => 'User not specified or empty']);
}

$mysqli->close();
