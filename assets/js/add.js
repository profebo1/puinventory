document.addEventListener("DOMContentLoaded", function () {});
// ADD NEW STOCKS
$("#addItemForm").on("submit", function (event) {
	event.preventDefault();
	const formData = $(this).serialize();

	$.ajax({
		url: 'process/add-new-item.php?curuser="ADMIN"',
		type: "POST",
		data: formData,
		dataType: "json",
		success: function (response) {
			if (response.success) {
				Swal.fire({
					icon: "success",
					title: "Success",
					text: response.success,
				});
				loadStocks();
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: response.error,
				});
			}
			$("#addNewModal").modal("hide");
		},
		error: function () {
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "An error occurred while adding the item.",
			});
		},
	});
});

$("#addSupplierForm").on("submit", function (event) {
	event.preventDefault();
	const formData = $(this).serialize();

	$.ajax({
		url: "process/add-new-item.php",
		type: "POST",
		data: formData,
		dataType: "json",
		success: function (response) {
			if (response.success) {
				Swal.fire({
					icon: "success",
					title: "Success",
					text: response.success,
				});
				loadStocks();
			} else {
				Swal.fire({
					icon: "error",
					title: "Error",
					text: response.error,
				});
			}
			$("#addNewModal").modal("hide");
		},
		error: function () {
			Swal.fire({
				icon: "error",
				title: "Error",
				text: "An error occurred while adding the item.",
			});
		},
	});
});

// Add event listeners to the add-to-item buttons
// const addToItemButtons = document.querySelectorAll(".add-to-item");
// addToItemButtons.forEach((button) => {
// 	button.addEventListener("click", function () {
// 		const itemId = this.getAttribute("data-itemid");
// 		const itemName = this.getAttribute("data-itemname");
// 		// const itemDesc = this.getAttribute("data-itemdesc");
// 		const currentStock = this.getAttribute("data-currentstock");

// 		document.getElementById("itemCode").innerHTML = itemId;
// 		document.getElementById("itemName").value = itemName;
// 		// Not using itemDesc as it isn't in the form
// 		document.getElementById("currentStock").value = currentStock;

// 		// Show the modal programmatically if needed
// 		$("#addtoitemsModal").modal("show");
// 	});
// });

document.addEventListener("DOMContentLoaded", function () {
	const addToItemButtons = document.querySelectorAll(".add-to-item");
	addToItemButtons.forEach((button) => {
		button.addEventListener("click", function () {
			const itemId = this.getAttribute("data-itemid");
			const itemName = this.getAttribute("data-itemname");
			const currentStock = this.getAttribute("data-currentstock");

			document.getElementById("itemCode").value = itemId;
			document.getElementById("itemName").value = itemName;
			document.getElementById("currentStock").value = currentStock;

			// Show the modal programmatically if needed
			$("#addtoitemsModal").modal("show");
		});
	});
});

function addStockQty(
	id,
	applicationDate,
	leaveType,
	requestedStartDate,
	requestedDays,
	reason
) {
	// Populate the form fields with the selected row data
	document.getElementById("applicationId").value = id;
	document.getElementById("selectedData").innerHTML =
		"<div class='form-group'><strong>Applicant ID:</strong> " +
		id +
		"</div>" +
		"<div class='form-group'><strong>Application Date:</strong> " +
		applicationDate +
		"</div>" +
		"<div class='form-group'><strong>Leave Type:</strong> " +
		leaveType +
		"</div>" +
		"<div class='form-group'><strong>Requested Start Date: </strong> <input type='date' name='approved_start_date' id='approved_start_date' value='" +
		requestedStartDate +
		"' class='form-control'></div>" +
		"<div class='form-group'><strong>Reason:</strong> " +
		reason +
		"</div>" +
		"<div class='form-group'><strong>Approval Notes:  </strong><textarea row='15' col='3' class='form-control approval-note-control' name='approval_notes' id='approval_notes' required></textarea></div>" +
		"<div class='form-group'><strong>Reliever: </strong> <input type='text'  name='reliever' id='reliever' class='form-control'></div>" +
		"<div class='form-group'><strong>Requested Days:  </strong><input type='text' name='approved_days' id='approved_days' value='" +
		requestedDays +
		"' class='form-control'></div>";

	// Show the modal
	$("#approvalModal").modal("show");
}
function showAddToItemModal(itemId, itemName, currentStock) {
	document.getElementById("itemCode-addup").value = itemId;
	document.getElementById("itemName-addup").value = itemName;
	document.getElementById("currentStock-addup").value = currentStock;

	// Show the modal programmatically
	$("#addtoitemsModal").modal("show");
}

// function addNewValues() {
// 	var oldValues = parseInt(
// 		document.getElementById("currentStock-addup").value,
// 		10
// 	);
// 	var newValues = parseInt(document.getElementById("newStock-addup").value, 10);

// 	if (!isNaN(oldValues) && !isNaN(newValues)) {
// 		var total = oldValues + newValues;
// 		document.getElementById("updated-addup").value = total;
// 	} else {
// 		document.getElementById("updated-addup").value = "Invalid input";
// 	}
// }

// function addNewValues() {
// 	var oldValues = parseInt(
// 		document.getElementById("currentStock-addup").value,
// 		10
// 	);
// 	var newValues = parseInt(document.getElementById("newStock-addup").value, 10);

// 	if (!isNaN(oldValues) && !isNaN(newValues)) {
// 		var total = oldValues + newValues;
// 		document.getElementById("updated-addup").value = total;
// 	} else {
// 		document.getElementById("updated-addup").value = "Invalid input";
// 	}
// }

function addNewValues() {
	var oldValues = parseInt(
		document.getElementById("currentStock-addup").value,
		10
	);
	var newValues = parseInt(document.getElementById("newStock-addup").value, 10);
	var Unitsaddup = parseInt(document.getElementById("Units-addup").value, 10);

	if (!isNaN(oldValues) && !isNaN(newValues)) {
		var total = newValues * Unitsaddup + oldValues;
		document.getElementById("updated-addup").innerHTML = total;
	} else {
		document.getElementById("updated-addup").innerHTML = "Invalid input";
	}
}

function findUnitCost() {
	// addNewValues();
	let actualCost = parseFloat(
		document.getElementById("ActualCost-addup").value
	);
	let units = parseFloat(document.getElementById("Units-addup").value);
	if (units > 0) {
		let unitCost = actualCost / units;
		document.getElementById("unitCost").innerText = unitCost.toFixed(2);
	} else {
		document.getElementById("unitCost").innerText = "0.00";
	}
}

function clearModalValues() {
	document.getElementById("itemCode-addup").value = "";
	document.getElementById("itemName-addup").value = "";
	document.getElementById("currentStock-addup").value = "";
	document.getElementById("newStock-addup").value = "0";
	document.getElementById("updated-addup").innerHTML = "";
	document.getElementById("proc-id").value = "";
}

$(document).ready(function () {
	$("#addtoitemsModal").on("hidden.bs.modal", function () {
		clearModalValues();
	});
});

function trigger() {
	addNewValues();
	findUnitCost();
}
//Enter New Stock level
// $("#btnAddNewStockQty").click(function () {
// 	// Prompt the user for confirmation using SweetAlert
// 	Swal.fire({
// 		title: "Confirm?",
// 		text: "Are you sure you want to update quantity of selected stock item?",
// 		icon: "warning",
// 		buttons: true,
// 		dangerMode: true,
// 	}).then((willUpdate) => {
// 		if (willUpdate) {
// 			// If user confirms the update, proceed with the AJAX request
// 			var formData = $("#addUpToItemsForm").serialize(); // Serialize form data
// 			// var selStaff = $("#selemail").val(); // Get selected staff email

// 			$.ajax({
// 				url: "process/update_stock_levels.php",
// 				method: "POST",
// 				data: formData,
// 				success: function (response) {
// 					Swal.fire({
// 						title: "Update Successful",
// 						text: "Selected stock item quantity updated successfully",
// 						icon: "success",
// 						buttons: true,
// 						// dangerMode: true,
// 					});
// 					// Reload the current page upon successful update
// 					location.reload();
// 				},
// 				error: function (xhr, status, error) {
// 					console.error(error);
// 					// Display error message using SweetAlert
// 					swal(
// 						"Error",
// 						"An error occurred while saving the record. Please try again later.",
// 						"error"
// 					);
// 				},
// 			});
// 		} else {
// 			// If user cancels the update, display a message using SweetAlert
// 			swal("Process Cancelled", "Data information remains unchanged.", "info");
// 		}
// 	});
// });

$("#btnAddNewStockQty").click(function () {
	Swal.fire({
		title: "Confirm?",
		text: "Are you sure you want to update the quantity of the selected stock item?",
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, update it!",
		cancelButtonText: "No, cancel!",
	}).then((result) => {
		if (result.isConfirmed) {
			var formData = $("#addUpToItemsForm").serialize(); // Serialize form data

			$.ajax({
				url: "process/stockEntry.php",
				method: "POST",
				data: formData,
				dataType: "json",
				success: function (response) {
					if (response.success) {
						Swal.fire({
							title: "Update Successful",
							text: response.success,
							icon: "success",
							confirmButtonText: "OK",
						}).then(() => {
							location.reload();
						});
					} else {
						Swal.fire("Error", response.error, "error");
					}
				},
				error: function (xhr, status, error) {
					console.error(error);
					Swal.fire({
						title: "Error Updating Stock Levels",
						text: error,
						icon: "success",
						confirmButtonText: "OK",
					});
				},
			});
		} else {
			Swal.fire(
				"Process Cancelled",
				"Data information remains unchanged.",
				"info"
			);
		}
	});
});

// nature change handler
function handleItemNatureChange() {
	var unitsInput = document.getElementById("Units-addup");
	if (document.getElementById("singles").checked) {
		unitsInput.value = 1;
		unitsInput.disabled = true;
	} else {
		unitsInput.disabled = false;
	}
	findUnitCost(); // Call this to update the unit cost if needed
}

// Call the function on page load to set initial state
document.addEventListener("DOMContentLoaded", handleItemNatureChange);
