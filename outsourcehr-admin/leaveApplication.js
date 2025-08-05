$(document).ready(function () {
	const cat = localStorage.getItem("cat") || "client";
	let currentPage = 1;
	let entriesPerPage = 10;
	let totalRecords = 0;
	let searchQuery = "";	

	function base64Encode(str) {
		return btoa(unescape(encodeURIComponent(str)));
	}

	function renderTable(data) {
		const tableBody = $(".table tbody");
		tableBody.empty();
		const module = localStorage.getItem("module");

        data.forEach((result, index) => {
					const token = btoa(result.id);
					const shortLeave = (result.leave_type || "").substring(0, 10);
					const row = `
				<tr>
					<td>${index + 1}</td>
					<td>${result.short_date || ""}</td>					
					<td>${result.staff_id || ""}</td>
					<td>${result.names || ""}</td>
					<td>${result.access_type || ""}</td>					
					<td>${
						shortLeave || ""
					}...<a id="valid" href="view-reason?id=${token}">more</a>                    					                                         					
                    </td>
					<td>${result.status2 || ""}</td>										
				</tr>
			`;
					tableBody.append(row);
				});
	}

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
				fetchTableData();
			});
		});
	}

	function fetchTableData() {
		$.ajax({
			url: "ajax_leave_Application.php",
			method: "GET",
			data: {
				cat: cat,
				search: {
					name: searchQuery,
				},
				start: (currentPage - 1) * entriesPerPage,
				length: entriesPerPage,
			},
			beforeSend: function () {
				$(".table tbody").html('<tr><td colspan="10" class="text-center">Loading...</td></tr>');
			},
			success: function (response) {    

    // Check if it's a string
    if (typeof response === "string") {
        try {
            response = JSON.parse(response);            
        } catch (e) {
            console.error("Failed to parse JSON:", e);
            return;
        }
    }

    // Now check if it's an array
    if (Array.isArray(response)) {
        console.error("❌ Backend returned an array instead of an object. Check your PHP.");
        return;
    }

    if (response.success && response.data.length > 0) {
        totalRecords = response.total || response.data.length;
        renderTable(response.data);
        updatePaginationControls();
    } else {
        $(".table tbody").html(
            '<tr><td colspan="10" class="text-center">No data found</td></tr>'
        );
        $(".datatablePagination").empty();
    }
},
			error: function (xhr, status, error) {
				console.error("AJAX Error:", status, error);
				console.log("Response Text:", xhr.responseText);
			},
		});
	}

	// 🔍 Handle search input
	$("#searchInput").on("input", function () {
		searchQuery = $(this).val();
		currentPage = 1;
		fetchTableData();
	});

	// 🔄 Change entries per page
	$("#datatableEntries").change(function () {
		entriesPerPage = parseInt($(this).val());
		currentPage = 1;
		fetchTableData();
	});

	// 🚀 Initial fetch
	fetchTableData();
});
