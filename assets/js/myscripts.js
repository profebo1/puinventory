document.addEventListener("DOMContentLoaded", function () {
	const contentSection = document.querySelector(".content");
	const navLinks = document.querySelectorAll(".nav-link");

	const contentMapping = {
		viewStocks: `
                    <div class="card">
                    <h3>View Stocks</h3>
                    <div id="stocksContainer">
                        <!-- Stocks list will be loaded here -->
                    </div>
                </div>
                `,
		queryStocks: `
                    <div class="card">
                        <h3>Query Stocks</h3>
                        <p>Query stocks form goes here.</p>
                    </div>
                `,
		depletingStocks: `
                    <div class="card">
                        <h3>Depleting Stocks</h3>
                        <p>List of depleting stocks goes here.</p>
                    </div>
                `,
	};

	navLinks.forEach((link) => {
		link.addEventListener("click", function (event) {
			if (!this.hasAttribute("data-toggle")) {
				event.preventDefault();
				const contentKey = this.getAttribute("data-content");
				contentSection.innerHTML = contentMapping[contentKey];
				if (contentKey === "viewStocks") {
					loadStocks();
				}
			}
		});
	});

	// Load initial content
	contentSection.innerHTML = contentMapping.viewStocks;
	// loadStocks();
});

// Function to load stocks data
function loadStocks() {
	fetch("")
		.then((response) => {
			if (!response.ok) {
				throw new Error(`HTTP error! status: ${response.status}`);
			}
			return response.json();
		})
		.then((data) => {
			const stocksContainer = document.getElementById("stocksContainer");
			let stocksHtml = `
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
            `;
			data.forEach((stock) => {
				stocksHtml += `
                    <tr>
                        <td>${stock.itemid}</td>
                        <td>${stock.itemName}</td>
                        <td>${stock.itemDesc}</td>
                        <td>""</td>
                        <td><span style="width:15px; height: 5px; background-color: red"></span></td>
                        <td><a href="#" style="color: green"><i class="fa fa-plus-square" aria-hidden="true"></i> Add Up</a></td>
                        <td><a href="#"><i class="fa fa-pencil-square" aria-hidden="true"></i> Edit Details</a></td>
                        <td><a href="#" style="color: red"><i class="fa fa-trash" aria-hidden="true"></i> Delete Item</a></td>                           
                    </tr>
                `;
			});
			stocksHtml += `
                    </tbody>
                </table>
            `;
			stocksContainer.innerHTML = stocksHtml;
		})
		.catch((error) => {
			const stocksContainer = document.getElementById("stocksContainer");
			stocksContainer.innerHTML = `Error: ${error.message}`;
			console.error("Error fetching stocks:", error);
		});
}

document.addEventListener("DOMContentLoaded", (event) => {
	loadStocks();
});

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
