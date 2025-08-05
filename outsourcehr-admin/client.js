$(document).ready(function () {	
	// Get single parameter
	$.getParam = (name) => {
		const results = new RegExp(`[?&]${name}=([^&#]*)`).exec(window.location.href);
		return results ? decodeURIComponent(results[1]) : null;
	};

	// Get all parameters
	$.getParams = () => {
		const params = {};
		window.location.search
			.substring(1)
			.split("&")
			.forEach((pair) => {
				const [key, value] = pair.split("=");
				if (key) params[key] = decodeURIComponent(value || "");
			});
		return params;
	};
	const cat = $.getParam("cat");
	const d_cat = atob(cat);

	const single = $.getParam("single");
	const d_single = atob(single);

	let originalData = [];
	let filteredData = [];
	let currentPage = 1;
	let entriesPerPage = 10;

	function paginate(data, page, perPage) {
		const start = (page - 1) * perPage;
		return data.slice(start, start + perPage);
	}

	function renderPagination(totalItems) {
		const totalPages = Math.ceil(totalItems / entriesPerPage);
		let paginationHtml = "";

		const visiblePages = 5; // show current ±2
		const startPage = Math.max(1, currentPage - 2);
		const endPage = Math.min(totalPages, currentPage + 2);

		// Always show first page
		if (startPage > 1) {
			paginationHtml += `<button class="page-btn btn btn-sm btn-light mx-1 ${
				currentPage === 1 ? "btn-primary" : ""
			}" data-page="1">1</button>`;
			if (startPage > 2) paginationHtml += `<span class="mx-1">...</span>`;
		}

		// Middle pages
		for (let i = startPage; i <= endPage; i++) {
			paginationHtml += `<button class="page-btn btn btn-sm mx-1 ${
				i === currentPage ? "btn-primary" : "btn-light"
			}" data-page="${i}">${i}</button>`;
		}

		// Always show last page
		if (endPage < totalPages) {
			if (endPage < totalPages - 1) paginationHtml += `<span class="mx-1">...</span>`;
			paginationHtml += `<button class="page-btn btn btn-sm btn-light mx-1 ${
				currentPage === totalPages ? "btn-primary" : ""
			}" data-page="${totalPages}">${totalPages}</button>`;
		}

		$("#pagination").html(paginationHtml);
	}

	function renderTable(data) {
		const $tbody = $(".table tbody");
		$tbody.empty();

		if (data.length === 0) {
			$tbody.html('<tr><td colspan="10" class="text-center">No records found</td></tr>');
			return;
		}

		let html = "";
		$.each(data, function (index, row) {
			html += `<tr>
            <td>${(currentPage - 1) * entriesPerPage + index + 1}</td>            
            <td>${row.firstname} ${row.surname}<br>${row.email_address}</td>				
            <td>${row.sex}</td>				
            <td>${row["1st_qualification_code"] || ""}</td>				
            <td>${row.company_code || ""}</td>				
            <td>${row.status}</td>				                        
        </tr>`;
		});

		$tbody.html(html);
	}

	function updateTable() {
		const paginated = paginate(filteredData, currentPage, entriesPerPage);
		renderTable(paginated);
		renderPagination(filteredData.length);
	}

	function applySearchFilter() {
		const keyword = $("#tableSearch").val().toLowerCase();
		filteredData = originalData.filter(
			(row) =>
				row.EmployeeID?.toLowerCase().includes(keyword) ||
				row.firstname?.toLowerCase().includes(keyword) ||
				row.surname?.toLowerCase().includes(keyword) ||
				row.email_address?.toLowerCase().includes(keyword)
		);
		currentPage = 1;
		updateTable();
	}

	// Fetch data initially
	function fetchData() {
		const cat = $.getParam("cat");
		const d_cat = atob(cat);

		const single = $.getParam("single");
		const d_single = atob(single);		

		$.ajax({
			url: "ajax_client",
			method: "GET",
			data: { cat: d_cat, single: d_single },
			beforeSend: function () {
				$(".table tbody").html(
					'<tr><td colspan="10" class="text-center">Loading...</td></tr>'
				);
			},
			success: function (response) {				

				
				// If it's a string, try parsing it
				if (typeof response === "string") {
					try {
						response = JSON.parse(response);
						console.log(response);
					} catch (e) {
						console.error("❌ JSON parse error:", e);
						return;
					}
				}

				if (response.success) {
					originalData = response.data;
					filteredData = [...originalData];
					updateTable();
				} else {
					console.warn("❌ response.success is false or undefined");
				}
			},
		});
	}

	// Events
	$(document).ready(function () {
		fetchData();

		$("#entriesPerPage").on("change", function () {
			entriesPerPage = parseInt($(this).val());
			currentPage = 1;
			updateTable();
		});

		$("#tableSearch").on("input", function () {
			applySearchFilter();
		});

		$(document).on("click", ".page-btn", function () {
			currentPage = parseInt($(this).data("page"));
			updateTable();
		});
	});
});
