// document.addEventListener("DOMContentLoaded", function () {
// 	const contentSection = document.querySelector(".content");
// 	const navLinks = document.querySelectorAll(".nav-link");

// 	const contentMapping = {
// 		viewStocks: `
//                     <div class="card">
//                     <h3>View Stocks</h3>
//                     <div id="stocksContainer">
//                         <!-- Stocks list will be loaded here -->
//                     </div>
//                 </div>
//                 `,
// 		queryStocks: `
//                     <div class="card">
//                         <h3>Query Stocks</h3>
//                         <p>Query stocks form goes here.</p>
//                     </div>
//                 `,
// 		depletingStocks: `
//                     <div class="card">
//                         <h3>Depleting Stocks</h3>
//                         <p>List of depleting stocks goes here.</p>
//                     </div>
//                 `,
// 	};

// 	navLinks.forEach((link) => {
// 		link.addEventListener("click", function (event) {
// 			if (!this.hasAttribute("data-toggle")) {
// 				event.preventDefault();
// 				const contentKey = this.getAttribute("data-content");
// 				contentSection.innerHTML = contentMapping[contentKey];
// 				if (contentKey === "viewStocks") {
// 					loadStocks();
// 				}
// 			}
// 		});
// 	});

// 	// Load initial content
// 	contentSection.innerHTML = contentMapping.viewStocks;
// 	// loadStocks();
// });

// // Function to load stocks data
// function loadStocks() {
// 	fetch("")
// 		.then((response) => {
// 			if (!response.ok) {
// 				throw new Error(`HTTP error! status: ${response.status}`);
// 			}
// 			return response.json();
// 		})
// 		.then((data) => {
// 			const stocksContainer = document.getElementById("stocksContainer");
// 			let stocksHtml = `
//                 <table class="table table-bordered">
//                     <thead>
//                         <tr>
//                             <th scope="col">Item Code</th>
//                             <th scope="col">Item Name</th>
//                             <th scope="col">Description</th>
//                             <th scope="col">Current Stock</th>
//                             <th scope="col">Status</th>
//                             <th scope="col"></th>
//                             <th scope="col"></th>
//                             <th scope="col"></th>
//                         </tr>
//                     </thead>
//                     <tbody>
//             `;
// 			data.forEach((stock) => {
// 				stocksHtml += `
//                     <tr>
//                         <td>${stock.itemid}</td>
//                         <td>${stock.itemName}</td>
//                         <td>${stock.itemDesc}</td>
//                         <td>""</td>
//                         <td><span style="width:15px; height: 5px; background-color: red"></span></td>
//                         <td><a href="#" style="color: green"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Up</a></td>
//                         <td><a href="#"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Details</a></td>
//                         <td><a href="#" style="color: red"><i class="fa fa-trash" aria-hidden="true"></i> Delete Item</a></td>
//                     </tr>
//                 `;
// 			});
// 			stocksHtml += `
//                     </tbody>
//                 </table>
//             `;
// 			stocksContainer.innerHTML = stocksHtml;
// 		})
// 		.catch((error) => {
// 			const stocksContainer = document.getElementById("stocksContainer");
// 			stocksContainer.innerHTML = `Error: ${error.message}`;
// 			console.error("Error fetching stocks:", error);
// 		});
// }

// document.addEventListener("DOMContentLoaded", (event) => {
// 	loadStocks();
// });

// // ADD NEW STOCKS
// $("#addItemForm").on("submit", function (event) {
// 	event.preventDefault();
// 	const formData = $(this).serialize();

// 	$.ajax({
// 		url: 'process/add-new-item.php?curuser="ADMIN"',
// 		type: "POST",
// 		data: formData,
// 		dataType: "json",
// 		success: function (response) {
// 			if (response.success) {
// 				Swal.fire({
// 					icon: "success",
// 					title: "Success",
// 					text: response.success,
// 				});
// 				loadStocks();
// 			} else {
// 				Swal.fire({
// 					icon: "error",
// 					title: "Error",
// 					text: response.error,
// 				});
// 			}
// 			$("#addNewModal").modal("hide");
// 		},
// 		error: function () {
// 			Swal.fire({
// 				icon: "error",
// 				title: "Error",
// 				text: "An error occurred while adding the item.",
// 			});
// 		},
// 	});
// });

document.addEventListener("DOMContentLoaded", function () {
	// ADD NEW STOCKS
	$("#addItemForm").on("submit", function (event) {
		event.preventDefault();
		const formData = $(this).serialize();

		$.ajax({
			url: "process/add-new-item.php?curuser='Admin'",
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
					loadStocks();
				} else {
					Swal.fire({
						icon: "error",
						title: "Error",
						text: response.error,
					});
				}
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
