<?php
include_once('connect.php');
include_once('functions.php');
// function getStocks()
// {
global $mysqli;


$sql = "SELECT itemid, itemName, itemDesc FROM stocks";
$result = $mysqli->query($sql);

$stocks = [];
if ($result->num_rows > 0) {
    $stocksHtml = '
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Item Code</th>
                    <th scope="col">Item Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Current Stock</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
    ';

    // Loop through each stock and generate table rows
    while ($row = $result->fetch_assoc()) {
        $stocksHtml .= '
            <tr>
                <td>' . htmlspecialchars($row["itemid"]) . '</td>
                <td>' . htmlspecialchars($row["itemName"]) . '</td>
                <td>' . htmlspecialchars($row["itemDesc"]) . '</td>
                <td>' . currentStockLevel($row["itemid"])  . '</td>
                <td><span style="width:15px; height: 5px; background-color: red"></span></td>
                <td><a href="#" style="color: green"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Up</a></td>
                <td><a href="#"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Details</a></td>
                <td><a href="#" style="color: red"><i class="fa fa-trash" aria-hidden="true"></i> Delete Item</a></td>
            </tr>
        ';
    }

    $stocksHtml .= '
            </tbody>
        </table>
    ';

    // Output the generated HTML
    echo $stocksHtml;
    // return "ok ooo";
    // echo ("ok ooo");
}

    // $mysqli->close();
// }