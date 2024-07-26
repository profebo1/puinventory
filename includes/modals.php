    <!-- Add New Item Modal -->
    <div class="modal fade" id="addNewModal" tabindex="-1" role="dialog" aria-labelledby="addNewModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewModalLabel">Add New Item</h5>
                    <a type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="addItemForm">
                        <div class="form-group">
                            <label for="itemName">Item Code</label>
                            <input type="text" class="form-control" id="itemCode" name="itemCode" value="<?php echo 'PUSTKS-' . rand(10000, 99999) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="itemName">Item Name</label>
                            <input type="text" class="form-control" id="itemName" name="itemName" placeholder="Enter item name" required>
                        </div>
                        <div class="form-group">
                            <label for="itemDescription">Item Description</label>
                            <textarea class="form-control" id="itemDescription" rows="3" name="itemDescription" placeholder="Enter item description"></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Add quantity to item -->
    <div id="addtoitemsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" id="addUpToItemsForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Add to Quantity</h5>
                        <a class="close btn btn-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body">
                        <p style="color: red;">Required *</p>
                        <p>Item Code: <input class="replaced-spans" type="text" id="itemCode-addup" name="itemCode-addup" readonly></p>
                        <p>Item Name: <input class="replaced-spans" type="text" id="itemName-addup" name="itemName-addup" readonly></p>
                        <p>Current Stock: <input class="replaced-spans" type="text" id="currentStock-addup" name="currentStock-addup" readonly></p>

                        <div class="form-group">
                            <label>Nature of Items:</label>
                            <div class="row align-items-center justify-content-center">

                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="packs" name="itemNature" value="packs" onchange="handleItemNatureChange();addNewValues()">
                                        <label class="form-check-label" for="packs"> Packs </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="singles" name="itemNature" value="singles" onchange="handleItemNatureChange();addNewValues()" checked>
                                        <label class="form-check-label" for="singles"> Singles </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cost-addup">Total Cost Component<span style="color: red;">*</span></label>
                            <div class="row">
                                <div class="col-4">
                                    <label for="">Cost: </label>
                                    <input type="number" min="1" id="ActualCost-addup" name="cost-addup" onchange="findUnitCost()" class="form-control" required>
                                </div>
                                <div class="col-4">
                                    <label for="">Total Packs/Singles: </label>
                                    <input type="number" min="1" id="Units-addup" name="Units-addup" onchange="trigger();" class="form-control" value="1" required>
                                </div>
                                <div class="col-4">
                                    <label for="updated-addup">Unit Cost: <span id="unitCost"></span></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="newStock-addup">How Many Packs/Singles:<span style="color: red;">*</span></label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="number" min="1" id="newStock-addup" name="newStock-addup" onchange="addNewValues()" class="form-control" value="1" required>
                                </div>
                                <div class="col-4">
                                    <label for="updated-addup">Stock On Save: <span id="updated-addup"></span></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="proc-id">Procurement ID (If any): </label>
                            <div class="row">
                                <div class="col-8">
                                    <input type="text" id="proc-id" name="proc-id" class="form-control">
                                </div>
                                <div class="col-4">
                                    <button class="form-control btn btn-info">Check</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" id="btnAddNewStockQty" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- add new supplier modal -->
    <div class="modal fade" id="addSupplierModal" tabindex="-1" role="dialog" aria-labelledby="addSupplierModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSupplierModalLabel">Add New Supplier</h5>
                    <a class="btn btn-danger" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <form id="addSupplierForm">
                        <div class="form-group">
                            <label for="supplierId">Supplier ID</label>
                            <input type="text" class="form-control" id="supplierId" name="supplierId" value="<?php echo 'SUP-' . rand(1000, 9999) ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="supplierName">Supplier Name</label>
                            <input type="text" class="form-control" id="supplierName" name="supplierName" placeholder="Enter supplier name" required>
                        </div>
                        <div class="form-group">
                            <label for="contactPerson">Contact Person</label>
                            <input type="text" class="form-control" id="contactPerson" name="contactPerson" placeholder="Enter contact person name" required>
                        </div>
                        <div class="form-group">
                            <label for="contactNumber">Contact Number</label>
                            <input type="text" class="form-control" id="contactNumber" name="contactNumber" placeholder="Enter contact person number" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="supaddress" rows="3" name="supaddress" placeholder="Enter address" required></textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ITEM TRACKING MODAL -->
    <div id="trackItemsModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trackItemsModalTitle">Track Items</h5>
                    <a type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Item ID</th>
                                <th scope="col">Batch ID</th>
                                <th scope="col">Cost</th>
                                <th scope="col">Date Added</th>
                            </tr>
                        </thead>
                        <tbody id="trackItemsTableBody">
                            <!-- Rows will be added here by JavaScript -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>