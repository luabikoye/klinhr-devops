$(document).ready(function () {
	// Initialize variables
	let currentPage = 1;
	let entriesPerPage = 10;
	let totalRecords = 0;
	let searchTerm = "";
	let searchTimeout;

	// Get parameters from URL or localStorage
	const urlParams = new URLSearchParams(window.location.search);
	const cat = urlParams.get("cat") || localStorage.getItem("cat");
    const backlog = urlParams.get("backlog") || localStorage.getItem("backlog");
    

	// Load initial data
	loadExamResults();

	// Search input with debounce
	$("#searchInput").on("keyup", function () {
		clearTimeout(searchTimeout);
		searchTimeout = setTimeout(function () {
			currentPage = 1;
			searchTerm = $("#searchInput").val();
			loadExamResults();
		}, 500);
	});

	// Entries dropdown change
	$("#entries-select").change(function () {
		currentPage = 1;
		entriesPerPage = $(this).val();
		loadExamResults();
	});

	// Pagination click
	$(document).on("click", ".page-link", function (e) {
		e.preventDefault();
		const action = $(this).data("page");

		if (action === "prev" && currentPage > 1) {
			currentPage--;
		} else if (action === "next" && currentPage < Math.ceil(totalRecords / entriesPerPage)) {
			currentPage++;
		} else if (!isNaN(action)) {
			currentPage = parseInt(action);
		}

		loadExamResults();
	});

	// Load exam results
	function loadExamResults() {
		const start = (currentPage - 1) * entriesPerPage;
		

		$.ajax({
			url: "ajax_staff_details", // Use current page
			type: "GET",
			data: {
				search: searchTerm,
				start: start,
				length: entriesPerPage,
				cat: cat,
				backlog: backlog,
			},
			dataType: "json",
			beforeSend: function () {
				$("#resultsTable tbody").html('<tr><td colspan="8">Loading...</td></tr>');
			},
			success: function (response) {								
				if (response.success) {
					totalRecords = response.total;					
					renderTable(response.data);
					updatePaginationControls();
					updateEntriesInfo();
				} else {
					showError(response.error || "Error loading data");
				}
			},
			error: function (xhr, status, error) {
				console.error("AJAX Error:", xhr.responseText);
				showError("Network error: " + error);
			},
		});
	}

	function age(dateString) {
		const birthDate = new Date(dateString).getTime() / 1000;
		// Get current timestamp (in seconds)
		const now = Math.floor(Date.now() / 1000);
		// Calculate age in years (31556926 = seconds in a year)
		return Math.floor((now - birthDate) / 31556926);
	}
	function formatDate(dateString, options = {}) {
		const defaults = {
			invalidText: "Invalid date",
			showSuffix: true,
		};
		const settings = { ...defaults, ...options };

		const date = new Date(dateString);
		if (isNaN(date.getTime())) return settings.invalidText;

		const day = date.getDate();
		const monthNames = [
			"Jan",
			"Feb",
			"Mar",
			"Apr",
			"May",
			"Jun",
			"Jul",
			"Aug",
			"Sep",
			"Oct",
			"Nov",
			"Dec",
		];
		const year = date.getFullYear();

		let suffix = "";
		if (settings.showSuffix) {
			suffix =
				day % 10 === 1 && day !== 11
					? "st"
					: day % 10 === 2 && day !== 12
					? "nd"
					: day % 10 === 3 && day !== 13
					? "rd"
					: "th";
		}

		return `${day}${suffix} ${monthNames[date.getMonth()]}, ${year}`;
	}
	
	// Render table data
	function renderTable(data) {
		const tbody = $(".table tbody");
		tbody.empty();

		if (data.length === 0) {
			tbody.html('<tr><td colspan="6">No records found</td></tr>');
			return;
		}

		data.forEach((result) => {
			// Calculate age safely
			const years = age(result.date_of_birth) || "30";

			tbody.append(`
				<tr>
					<td>
						<div class="form-check">
							<input class="form-check-input" type="checkbox" value="${
								result.id
							}" name="id[]">
							<input class="form-check-input" type="hidden" value="${
								result.candidate_id
							}" name="candidate_id[]">
							<label class="form-check-label" for="usersDataCheck2"></label>
						</div>
					</td>
					<td>${result.firstname} ${result.surname}<br>${result.email_address}</td>
					<td>${result.sex}${years ? `(${years})` : ""}</td>
					<td>${result.onboarding_code}</td>
					<td>${result["1st_qualification_code"] || ""}</td>
					<td>${result.company_code}</td>
					<td>${formatDate(result.date)}</td>                    
					<td>
						<a data-toggle="tooltip" data-placement="top" 
						   data-original-title="View Applicant" 
						   class="btn btn-sm btn-outline-secondary" 
						   href="view_onboarding?id=${btoa(result.id)}&unique=${btoa(
				result.email_address
			)}">
						   <i class="fas bi-eye"></i>
						</a>				
					</td>                    
				</tr>
			`);
		});
	}

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
		nextLi.className = `page-item ${
			currentPage >= totalPages ? "disabled" : ""
		}`;
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

	// Update entries info
	function updateEntriesInfo() {
		const start = Math.min((currentPage - 1) * entriesPerPage + 1, totalRecords);
		const end = Math.min(start + entriesPerPage - 1, totalRecords);
		$("#entriesInfo").text(`Showing ${start} to ${end} of ${totalRecords} entries`);
	}

	// Show error message
	function showError(message) {
		$("#resultsTable tbody").html(`<tr><td colspan="6" class="text-danger">${message}</td></tr>`);
	}
});
