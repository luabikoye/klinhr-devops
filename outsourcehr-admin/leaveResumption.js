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
		const tableBody = $("#myTable tbody");
		tableBody.empty();
		const module = localStorage.getItem("module");

		data.forEach((result) => {
			const id = result.id || "";
			const shortLeave = (result.leave_type || "").substring(0, 10);
			const row = `
				<tr>
					<td><label class="fancy-checkbox"><input class="checkbox-tick" type="checkbox" value="${
						result.id || ""
					}" name="id[]"></label></td>
					<td>${result.short_date || ""}</td>					
					<td>${result.staff_id || ""}</td>
					<td>${result.names || ""}</td>
					<td>${result.access_type || ""}</td>
					<td>${
						shortLeave || ""
					}...<a id="valid" href="#" data-toggle="modal" data-backdrop="static" data-keyboard="false" data-target="#onboarding${id}">more</a>
                    <!-- Modal -->
					<div class="modal fade" id="onboarding${id}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="email_modal">
										${result.names || ""} (${result.staff_id || ""})
									</h4>
								</div>
								<div class="modal-body">
									<table class="tab table-bordered">
										<tr><td>Email</td><td>${result.email || ""}</td></tr>
										<tr><td>Manager</td><td>${result.manager || ""}</td></tr>
										<tr><td>Manager Email</td><td>${result.manager_email || ""}</td></tr>
									
										<tr><td>Type of Leave</td><td>${result.leave_type || ""}</td></tr>
										<tr class="text-danger"><td>Date Applied</td><td>${result.letter_date || ""}</td></tr>
										<tr class="text-danger"><td>Start Date</td><td>${
											result.start_date !== "0000-00-00" ? result.start_date : result.purpose || ""
										}</td></tr>
										<tr class="text-danger"><td>End Date</td><td>${result.end_date || ""}</td></tr>
										<tr class="text-danger"><td>Resumption Date</td><td>${result.resumption_date || ""}</td></tr>
										<tr><td>Purpose of Leave</td><td>${result.purpose || ""}</td></tr>
										<tr><td></td>
											<td><a download href="../staffportal/${
												result.image_path || "#"
											}" class="btn btn-primary" target="_blank">Download Signed Form</a></td>
										</tr>
									</table>									
								</div>
								<form action="approve_leave" method="post">
									<div class="modal-footer">										
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</form>
							</div>
						</div>
					</div>
                    </td>					
				</tr>
			`;
			tableBody.append(row);
		});
	}

	function renderPagination(total) {
		const totalPages = Math.ceil(total / entriesPerPage);
		const pagination = $("#pagination");
		pagination.empty();
		if (totalPages <= 1) return;

		const createButton = (page, isActive = false) => `
		<button class="btn btn-sm ${
			isActive ? "btn-primary" : "btn-outline-primary"
		} mx-1" data-page="${page}">
			${page}
		</button>`;

		const addEllipsis = () => `<span class="mx-1">...</span>`;
		let pages = [1];

		if (currentPage > 4) pages.push(addEllipsis());
		for (let i = currentPage - 1; i <= currentPage + 1; i++) {
			if (i > 1 && i < totalPages) pages.push(i);
		}
		if (currentPage < totalPages - 3) pages.push(addEllipsis());
		if (totalPages > 1) pages.push(totalPages);

		pages.forEach((p) => {
			if (typeof p === "string") {
				pagination.append(p);
			} else {
				pagination.append(createButton(p, p === currentPage));
			}
		});

		pagination.find("button").click(function () {
			currentPage = parseInt($(this).data("page"));
			fetchTableData();
		});
	}

	function fetchTableData() {
		$.ajax({
			url: "ajax_leave_Resumption.php",
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
				$("#myTable tbody").html('<tr><td colspan="10" class="text-center">Loading...</td></tr>');
			},
			success: function (response) {				
				if (response.success && response.data.length > 0) {
					totalRecords = response.total || response.data.length;
					renderTable(response.data);
					renderPagination(totalRecords);
				} else {
					$("#myTable tbody").html(
						'<tr><td colspan="10" class="text-center">No data found</td></tr>'
					);
					$("#pagination").empty();
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
	$("#entriesPerPage").change(function () {
		entriesPerPage = parseInt($(this).val());
		currentPage = 1;
		fetchTableData();
	});

	// 🚀 Initial fetch
	fetchTableData();
});
