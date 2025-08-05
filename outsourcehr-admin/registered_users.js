// Global variables
let currentPage = 1;
let entriesPerPage = 10;
let totalRecords = 0;

let successAlerts = document.getElementsByClassName("alert-success");

for (let i = 0; i < successAlerts.length; i++) {
	successAlerts[i].classList.add("hidden");
}


// Modified loadUser function
function loadUser(search = "") {
	const params = new URLSearchParams();	
	params.append("draw", Date.now());
	if (search) params.append("search", btoa(search));
	params.append("start", (currentPage - 1) * entriesPerPage);
	params.append("length", entriesPerPage);	
	
	fetch(`ajax_registered_user.php?${params.toString()}`)
		.then((response) => response.json())
		.then((data) => {        			
			if (data.success) {     				
                totalRecords = data.filtered;
				renderUser(data.data);
				updatePaginationControls();
				updateEntriesInfo(data);
			}
		})
		.catch((error) => console.error("Error:", error));
}

// Update pagination info
function updateEntriesInfo(data) {
	const start = Math.min((currentPage - 1) * entriesPerPage + 1, totalRecords);
	const end = Math.min(start + entriesPerPage - 1, totalRecords);
	document.querySelector(".entries-info");
}

// Update pagination controls
// Update pagination controls
function updatePaginationControls() {
	const totalPages = Math.ceil(totalRecords / entriesPerPage);
	const paginationWrapper = document.querySelector("#datatablePagination");

	paginationWrapper.innerHTML = "";

	const nav = document.createElement("div");
	nav.className = "dataTables_paginate paging_simple_numbers";
	nav.id = "datatable_paginate";

	const ul = document.createElement("ul");
	ul.className = "pagination datatable-custom-pagination";
	ul.id = "datatable_pagination";

	// Prev button
	const prevLi = document.createElement("li");
	prevLi.className = `paginate_item page-item ${
		currentPage <= 1 ? "disabled" : ""
	}`;
	prevLi.innerHTML = `
		<a class="paginate_button previous page-link" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous">
			<span aria-hidden="true">Prev</span>
		</a>`;
	ul.appendChild(prevLi);

	// Page buttons with ellipsis
	const maxVisiblePages = 5;
	let startPage = Math.max(currentPage - 2, 1);
	let endPage = Math.min(currentPage + 2, totalPages);

	if (currentPage <= 3) {
		endPage = Math.min(maxVisiblePages, totalPages);
	}
	if (currentPage >= totalPages - 2) {
		startPage = Math.max(totalPages - maxVisiblePages + 1, 1);
	}

	if (startPage > 1) {
		appendPageBtn(1);
		if (startPage > 2) appendEllipsis();
	}

	for (let i = startPage; i <= endPage; i++) {
		appendPageBtn(i);
	}

	if (endPage < totalPages) {
		if (endPage < totalPages - 1) appendEllipsis();
		appendPageBtn(totalPages);
	}

	// Next button
	const nextLi = document.createElement("li");
	nextLi.className = `paginate_item page-item ${
		currentPage >= totalPages ? "disabled" : ""
	}`;
	nextLi.innerHTML = `
		<a class="paginate_button next page-link" aria-controls="datatable" data-dt-idx="${
			totalPages + 1
		}" tabindex="0" id="datatable_next">
			<span aria-hidden="true">Next</span>
		</a>`;
	ul.appendChild(nextLi);

	nav.appendChild(ul);
	paginationWrapper.appendChild(nav);

	// Click listeners
	paginationWrapper.querySelectorAll("a").forEach((link) => {
		link.addEventListener("click", function (e) {
			e.preventDefault();
			const idx = this.getAttribute("data-dt-idx");

			if (this.id === "datatable_previous" && currentPage > 1) {
				currentPage--;
			} else if (this.id === "datatable_next" && currentPage < totalPages) {
				currentPage++;
			} else if (!isNaN(idx)) {
				currentPage = parseInt(idx);
			}

			const search = document.getElementById("searchInput").value;
			loadUser(search);
		});
	});

	// Helpers
	function appendPageBtn(page) {
		const li = document.createElement("li");
		li.className = `paginate_item page-item ${
			page === currentPage ? "active" : ""
		}`;
		li.innerHTML = `
			<a class="paginate_button page-link" aria-controls="datatable" data-dt-idx="${page}" tabindex="0">${page}</a>`;
		ul.appendChild(li);
	}

	function appendEllipsis() {
		const li = document.createElement("li");
		li.className = "paginate_item page-item disabled";
		li.innerHTML = `<span class="page-link">…</span>`;
		ul.appendChild(li);
	}
}


// Event listener for pagination
document
	.querySelector("#datatablePagination")
	.addEventListener("click", function (e) {
		e.preventDefault();
		const target = e.target.closest(".page-link");
		if (!target) return;

		const pageAction = target.dataset.page;

		if (pageAction === "prev" && currentPage > 1) {
			currentPage--;
		} else if (
			pageAction === "next" &&
			currentPage < Math.ceil(totalRecords / entriesPerPage)
		) {
			currentPage++;
		} else if (!isNaN(pageAction)) {
			currentPage = parseInt(pageAction);
		} else {
			return;
		}

		const search = document.getElementById("searchInput").value;
		loadUser(search);
	});

document
	.getElementById("datatableEntries")
	.addEventListener("change", function (e) {
		entriesPerPage = parseInt(e.target.value);
		currentPage = 1;
		const search = document.getElementById("searchInput").value;
		loadUser(search);
	});

// Event listener for entries dropdown
function renderUser(users) {
	const tableBody = document.querySelector(".table tbody");
	const userPrivilege = localStorage.getItem("userPrivilege");
	tableBody.innerHTML = "";

	users.forEach((user) => {
		const row = document.createElement("tr");
		row.innerHTML = `
            <td class="table-column-pe-0">                
				<div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                value="${user.id}" name="id[]" id="usersDataCheck2">
                                            <label class="form-check-label" for="usersDataCheck2"></label>
                                        </div>
            </td>
			    <td>${user.firstname} ${user.lastname}</td>            
				<td>${user.email}</td>
            <td>${user.phone}</td>            
            <td>${user.status}</td>                      
        `;

		// <a title="Delete Applicant" class="btn btn-sm btn-outline-secondary" onclick="return confirm('Are you sure you want to delete this applicant? ');" href="delete-record?id=<?php echo $row['id']; ?>&tab=jobseeker_signup&return=registered-users"><i class="bi-trash"></i></a>
		// Action cell
		const actionCell = document.createElement("td");

		// Delete button (for admins only)
		if (userPrivilege === "Super Admin" || userPrivilege === "Admin") {
			const deleteBtn = document.createElement("a");
			deleteBtn.className = "btn btn-sm btn-outline-secondary";
			deleteBtn.innerHTML = '<i class="bi-trash"></i>';
			deleteBtn.setAttribute("data-toggle", "tooltip");
			deleteBtn.setAttribute("title", "Delete Applicant");

			deleteBtn.onclick = (e) => {
				e.preventDefault();
				if (
					confirm(`Are you sure you want to delete ${user.firstname}'s record?`)
				) {
					deleteRecord(user.id, "jobseeker_signup", "registered_users");
				}
			};

			actionCell.appendChild(deleteBtn);
		}

		row.appendChild(actionCell);
		tableBody.appendChild(row);
	});
}

// Function to handle deletion
function deleteRecord(id, table, returnPage) {
	fetch(`delete-record2?id=${id}&tab=${table}&return=${returnPage}`, {
		method: "GET",
		headers: {
			"Content-Type": "application/json",
		},
	})
		.then((response) => response.json())
		.then((data) => {
			if (data.success) {
				alert("Record deleted successfully");
				// Refresh the table or remove the row
				location.reload(); // or more specific DOM update
			} else {
				// alert("Error deleting record: " + data.message);
				let successAlerts = document.getElementsByClassName("alert-success");

				for (let i = 0; i < successAlerts.length; i++) {
					successAlerts[i].classList.remove("hidden"); // remove class
					successAlerts[i].textContent = data.message; // add text
				}
			}
		})
		.catch((error) => {
			console.error("Error:", error);
			alert("An error occurred while deleting");
		});
}
// Event listener for filter form submission


// Initial load
document.addEventListener("DOMContentLoaded", function () {	
    const search = "";    
	loadUser(search);
});


// Add this function to update pagination info
function updatePaginationInfo() {
	const start = Math.min((currentPage - 1) * entriesPerPage + 1, totalRecords);
	const end = Math.min(start + entriesPerPage - 1, totalRecords);
	document.querySelector(
		".entries-info"
	).textContent = `Showing ${start} to ${end} of ${totalRecords} entries`;
}

// Search functionality
document.getElementById("searchInput").addEventListener("input", function (e) {	
	loadUser(e.target.value);
});
