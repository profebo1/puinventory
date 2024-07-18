document.addEventListener("DOMContentLoaded", function () {
	//  fetch_related_items
	$(".track-item").click(function () {
		var itemid = $(this).data("itemid");

		$.ajax({
			url: "process/fetch_related_items.php",
			method: "POST",
			data: { itemid: itemid },
			dataType: "json",
			success: function (response) {
				if (response.error) {
					alert(response.error);
				} else {
					var tableBody = $("#trackItemsTableBody");
					tableBody.empty();

					response.forEach(function (item) {
						var row =
							"<tr>" +
							"<td>" +
							item.item_id +
							"</td>" +
							"<td>" +
							item.batch_id +
							"</td>" +
							"<td>" +
							item.cost +
							"</td>" +
							"<td>" +
							item.entryDate +
							"</td>" +
							"</tr>";
						tableBody.append(row);
					});

					$("#trackItemsModal").modal("show");
				}
			},

			error: function (xhr, status, error) {
				console.error(xhr.responseText); // Log the detailed error message
				Swal.fire({
					title: "Error Updating Stock Levels",
					text: "An unexpected error occurred. Please try again later.",
					icon: "error",
					confirmButtonText: "OK",
				});
			},
		});
	});

	// ADD NEW STOCKS
	$("#addItemForm").on("submit", function (event) {
		event.preventDefault();
		const formData = $(this).serialize();

		$.ajax({
			url: "process/add-new-item.php?curuser=Admin",
			type: "POST",
			data: formData,
			dataType: "json",
			success: function (response) {
				if (response.success) {
					Swal.fire({
						icon: "success",
						title: "Success",
						text: response.success,
					}).then(() => {
						location.reload();
					});
					$("#addNewModal").modal("hide");
					// loadStocks();
				} else {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: response.error,
					});
					// loadStocks();
				}
			},
			error: function (xhr, status, error) {
				console.error("Error response:", xhr.responseText);
				let errorMessage = "An error occurred while adding the item.";
				try {
					const jsonResponse = JSON.parse(xhr.responseText);
					if (jsonResponse.error) {
						errorMessage = jsonResponse.error;
					}
				} catch (e) {
					errorMessage += ` ${error}`;
				}
				Swal.fire({
					icon: "error",
					title: "Error",
					text: errorMessage,
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
					// text: "An error occurred while adding the item.",
					text: response.error,
				});
			},
		});

		// Add event listeners to the add-to-item buttons
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
	// Call the function to set initial state
	handleItemNatureChange();
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
	let actualCost = parseFloat(
		document.getElementById("ActualCost-addup").value
	);
	let units = parseFloat(document.getElementById("updated-addup").value);
	// let units = parseFloat(document.getElementById("Units-addup").value);
	// updated - addup;
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

$("#btnAddNewStockQty").click(function (event) {
	event.preventDefault(); // Prevent the default form submission
	let ThisitemId = document.getElementById("itemCode-addup").value;

	Swal.fire({
		title: "Confirm?",
		html: `Are you sure you want to update the quantity of the selected stock item?<br /> Below are the entries to be made effected! <br /> `,
		icon: "warning",
		showCancelButton: true,
		confirmButtonText: "Yes, update it!",
		cancelButtonText: "No, cancel!",
	}).then((result) => {
		if (result.isConfirmed) {
			var form = $("#addUpToItemsForm")[0];

			// Check if form is valid
			if (form.checkValidity() === false) {
				Swal.fire("Error", "Please fill out all required fields.", "error");
				return;
			}

			var formData = $(form).serialize(); // Serialize form data

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
					console.error(xhr.responseText); // Log the detailed error message
					Swal.fire({
						title: "Error Updating Stock Levels",
						text: "An unexpected error occurred. Please try again later.",
						icon: "error",
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
