// Global variables
let currentPage = 1;
let entriesPerPage = 10;
let totalRecords = 0;

// Modified loadJobs function
function loadJobs(cat, search = "", filters = {}) {
	const params = new URLSearchParams();
	params.append("cat", cat);
	params.append("draw", Date.now());
	if (search) params.append("search", btoa(search));
	params.append("start", (currentPage - 1) * entriesPerPage);
	params.append("length", entriesPerPage);

	// Add filters
	Object.entries(filters).forEach(([key, value]) => {
		if (value) params.append(`filters[${key}]`, value);
	});

	fetch(`ajax_jobs.php?${params.toString()}`)
		.then((response) => response.json())
		.then((data) => {
			if (data.success) {
				totalRecords = data.filtered;
				renderJobs(data.data);
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
	const pagination = document.querySelector(".datatablePagination");

	// Clear existing pagination
	pagination.innerHTML = "";

	// Create document fragment for better performance
	const fragment = document.createDocumentFragment();

	// Previous button
	const prevLi = document.createElement("li");
	prevLi.className = `page-item ${currentPage <= 1 ? "disabled" : ""}`;
	prevLi.innerHTML = `<a class="page-link" href="#" data-page="prev">&laquo;</a>`;
	fragment.appendChild(prevLi);

	// Page numbers
	const maxVisiblePages = 5;
	let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
	let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

	// Adjust if we're at the end
	if (endPage - startPage < maxVisiblePages - 1) {
		startPage = Math.max(1, endPage - maxVisiblePages + 1);
	}

	// First page and ellipsis
	if (startPage > 1) {
		const firstLi = document.createElement("li");
		firstLi.className = "page-item";
		firstLi.innerHTML = `<a class="page-link" href="#" data-page="1">1</a>`;
		fragment.appendChild(firstLi);

		if (startPage > 2) {
			const ellipsisLi = document.createElement("li");
			ellipsisLi.className = "page-item disabled";
			ellipsisLi.innerHTML = `<span class="page-link">...</span>`;
			fragment.appendChild(ellipsisLi);
		}
	}

	// Page numbers
	for (let i = startPage; i <= endPage; i++) {
		const pageLi = document.createElement("li");
		pageLi.className = `page-item ${i === currentPage ? "active" : ""}`;
		pageLi.innerHTML = `<a class="page-link" href="#" data-page="${i}">${i}</a>`;
		fragment.appendChild(pageLi);
	}

	// Last page and ellipsis
	if (endPage < totalPages) {
		if (endPage < totalPages - 1) {
			const ellipsisLi = document.createElement("li");
			ellipsisLi.className = "page-item disabled";
			ellipsisLi.innerHTML = `<span class="page-link">...</span>`;
			fragment.appendChild(ellipsisLi);
		}

		const lastLi = document.createElement("li");
		lastLi.className = "page-item";
		lastLi.innerHTML = `<a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>`;
		fragment.appendChild(lastLi);
	}

	// Next button
	const nextLi = document.createElement("li");
	nextLi.className = `page-item ${currentPage >= totalPages ? "disabled" : ""}`;
	nextLi.innerHTML = `<a class="page-link" href="#" data-page="next">&raquo;</a>`;
	fragment.appendChild(nextLi);

	// Append all at once
	pagination.appendChild(fragment);

	// Prevent default behavior for all pagination links
	pagination.querySelectorAll("a").forEach((link) => {
		link.addEventListener("click", function (e) {
			e.preventDefault();
			const pageAction = this.dataset.page;

			if (pageAction === "prev" && currentPage > 1) {
				currentPage--;
			} else if (pageAction === "next" && currentPage < totalPages) {
				currentPage++;
			} else if (!isNaN(pageAction)) {
				currentPage = parseInt(pageAction);
			} else {
				return;
			}

			const cat = localStorage.getItem("cat");
			const search = document.getElementById("searchInput").value;
			loadJobs(cat, search);
		});
	});
}

// Event listener for pagination
document
	.querySelector(".datatablePagination")
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

		const cat = localStorage.getItem("cat");
		const search = document.getElementById("searchInput").value;
		loadJobs(cat, search);
	});

// Event listener for entries dropdown
document
	.getElementById("datatableEntries")
	.addEventListener("change", function (e) {
		entriesPerPage = parseInt(e.target.value);
		currentPage = 1;
		const cat = localStorage.getItem("cat");
		const search = document.getElementById("searchInput").value;
		loadJobs(cat, search);
	});
function renderJobs(jobs) {
	const tableBody = document.querySelector(".table tbody");
	tableBody.innerHTML = "";
	const userPrivilege = localStorage.getItem("userPrivilege");

	jobs.forEach((job) => {
		const row = document.createElement("tr");
		const cat = localStorage.getItem("cat");
		row.innerHTML = `
            <td>
                <label class="fancy-checkbox">
                    <input class="checkbox-tick" type="checkbox" value="${
											job.id
										}" name="id[]">                                                        
                </label>
            </td>
			    <td>${job.firstname} ${job.lastname}</td>
            <td>${job.gender ? job.gender : ""}(${job.age ? job.age : ""})</td>
            <td>${job.job_title}</td>            
            <td>${job.qualification ? job.qualification : ""}</td>
            <td>${job.client_name}</td>
            <td>${job.date}</td>
            <td>${job.status}</td>
                 
        `;

		// Action cell
		const actionCell = document.createElement("td");

		// View button
		const viewBtn = document.createElement("a");
		viewBtn.className = "btn btn-sm btn-outline-secondary";
		viewBtn.innerHTML = '<i class="fa bi-eye"></i>';
		viewBtn.setAttribute("data-toggle", "tooltip");
		viewBtn.setAttribute("title", "View Applicant");
		viewBtn.href = `view_applicants?unique=${btoa(job.id)}`;
		viewBtn.target = "_blank";
		actionCell.appendChild(viewBtn);

		// Download button (if file exists)

		const downloadBtn = document.createElement("a");
		downloadBtn.className = "btn btn-sm btn-outline-secondary";
		downloadBtn.innerHTML = '<i class="fa bi-download"></i>';
		downloadBtn.setAttribute("data-toggle", "tooltip");
		downloadBtn.setAttribute("title", "Download CV");
		downloadBtn.setAttribute("download", "");
		downloadBtn.href = `/${window.APP_CONFIG.FILE_DIR}/${job.filepath}`;
		actionCell.appendChild(downloadBtn);

		// Delete button (for admins only)
		if (userPrivilege === "Super Admin" || userPrivilege === "Admin") {
			const deleteBtn = document.createElement("a");
			deleteBtn.className = "btn btn-sm btn-outline-secondary";
			deleteBtn.innerHTML = '<i class="fas bi-trash"></i>';
			deleteBtn.setAttribute("data-toggle", "tooltip");
			deleteBtn.setAttribute("title", "Delete Applicant");

			deleteBtn.onclick = (e) => {
				e.preventDefault();
				if (
					confirm(`Are you sure you want to delete ${job.firstname}'s record?`)
				) {
					deleteRecord(job.id, "jobs_applied", "applicants");
				}
			};

			actionCell.appendChild(deleteBtn);
		}

		row.appendChild(actionCell);
		tableBody.appendChild(row);
	});

	// Initialize tooltips
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
				alert("Error deleting record: " + data.message);
			}
		})
		.catch((error) => {
			console.error("Error:", error);
			alert("An error occurred while deleting");
		});
}
// Event listener for filter form submission
document.querySelectorAll("#filterForm select").forEach(function (select) {
	select.addEventListener("change", function () {
		const form = document.getElementById("filterForm");
		const formData = new FormData(form);

		const filters = {
			job_title: formData.get("job_title"),
			gender: formData.get("sex"),
			qualification: formData.get("qualification"),
			class_degree: formData.get("class_degree"),
			client_name: formData.get("client_name"),
		};

		const cat = localStorage.getItem("cat");
		loadJobs(cat, "", filters);
	});
});

function closeModal() {
	const modal = document.getElementById("exampleModal"); // Replace with your modal ID
	if (modal) {
		// For Bootstrap modal
		if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
			const bsModal = bootstrap.Modal.getInstance(modal);
			if (bsModal) {
				bsModal.hide();
			} else {
				new bootstrap.Modal(modal).hide();
			}
		}
		// For non-Bootstrap modal
		else {
			modal.style.display = "none";
			document.body.classList.remove("modal-open");
			const modalBackdrop = document.querySelector(".modal-backdrop");
			if (modalBackdrop) {
				modalBackdrop.remove();
			}
		}
	}
}

// Initial load
document.addEventListener("DOMContentLoaded", function () {
	const cat = localStorage.getItem("cat");
	const search = "";
	loadJobs(cat, search);
});
// Reset filters
function resetFilters() {
	document.getElementById("filterForm").reset();
	const cat = localStorage.getItem("cat");
	loadJobs(cat);
}

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
	const cat = localStorage.getItem("cat");
	loadJobs(cat, e.target.value);
});
