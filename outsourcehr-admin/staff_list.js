$(document).ready(function () {
	const cat = localStorage.getItem("cat") || "client";

	let currentPage = 1;
	let entriesPerPage = 10;
	let totalRecords = 0;
	let lastFilters = {};

	const base64Encode = (str) => btoa(unescape(encodeURIComponent(str)));

	const renderTable = (data) => {
		const tableBody = $(".table tbody").empty();
		const module = localStorage.getItem("module");

		data.forEach((result, index) => {
			const fullName = `${result.firstname || ""} ${result.surname || ""}`;
			const row = `
        <tr>
          <td>${(currentPage - 1) * entriesPerPage + index + 1}</td>
          <td><a href="#">${result.EmployeeID || ""}</a></td>
          <td><a target="_blank" href="view_onboarding?candidate_id=${btoa(
						result.id
					)}&unique=${btoa(result.email_address)}">${result.firstname} ${
				result.middlename || ""
			} ${result.surname}</a></td>
          <td>${result.position_name || ""}</td>
          <td>${result.client_name || ""}</td>
          <td>${[
						"1st_qualification_code",
						"2nd_qualification_code",
						"3rd_qualification_code",
					]
						.map((k) => result[k] || "")
						.join("<br>")}</td>
          <td>${["1st_course_code", "2nd_course_code", "3rd_course_code"]
						.map((k) => result[k] || "")
						.join("<br>")}</td>
          <td>${result.date_moved || ""}</td>
          <td><a class="btn btn-sm btn-outline-secondary" title="Download CV" download href="/document/${
						result.filepath || ""
					}"><i class="fa bi-download"></i></a></td>
        </tr>`;
			tableBody.append(row);
		});
	};

	const updatePaginationControls = () => {
		const totalPages = Math.ceil(totalRecords / entriesPerPage);
		const wrapper = $("#datatablePagination").empty();

		const ul = $("<ul>", {
			class: "pagination datatable-custom-pagination",
			id: "datatable_pagination",
		});

		const createPageItem = (
			page,
			label = page,
			disabled = false,
			active = false
		) => {
			return $("<li>", {
				class: `paginate_item page-item ${disabled ? "disabled" : ""} ${
					active ? "active" : ""
				}`,
				html: `<a class="paginate_button page-link" data-dt-idx="${page}" tabindex="0">${label}</a>`,
			});
		};

		ul.append(
			createPageItem(
				currentPage - 1,
				"<span aria-hidden='true'>Prev</span>",
				currentPage <= 1
			)
		);

		const range = [...Array(Math.min(5, totalPages)).keys()].map((i) => i + 1);
		range.forEach((page) => {
			ul.append(createPageItem(page, page, false, page === currentPage));
		});

		ul.append(
			createPageItem(
				currentPage + 1,
				"<span aria-hidden='true'>Next</span>",
				currentPage >= totalPages
			)
		);

		wrapper.append(ul);

		ul.find("a").on("click", function (e) {
			e.preventDefault();
			const idx = Number($(this).data("dt-idx"));
			if (!isNaN(idx) && idx >= 1 && idx <= totalPages && idx !== currentPage) {
				currentPage = idx;
				fetchTableData(cat, lastFilters);
			}
		});
	};

	const fetchTableData = (cat, filters = {}) => {
		lastFilters = filters;

		$.ajax({
			url: "ajax_staff_list.php",
			method: "GET",
			data: {
				draw: 1,
				order: [{ column: 0, dir: "desc" }],
				search: {
					name: filters.name || "",
					firstname: filters.firstname || "",
					lastname: filters.lastname || "",
					email: filters.email || "",
					client: filters.client || "",
					phone: filters.phone || "",
					staff_id: filters.staff_id || "",
					role: filters.role || "",
				},
				start: (currentPage - 1) * entriesPerPage,
				length: entriesPerPage,
			},
			beforeSend: () => {
				$(".table tbody").html(
					'<tr><td colspan="10" class="text-center">Loading...</td></tr>'
				);
			},
			success: (response) => {
				try {
					response =
						typeof response === "string" ? JSON.parse(response) : response;
				} catch (e) {
					console.error("❌ JSON parse error:", e);
					return;
				}

				if (response.success && Array.isArray(response.data)) {
					totalRecords = response.total || response.data.length;
					renderTable(response.data);
					updatePaginationControls();
				} else {
					$(".table tbody").html(
						'<tr><td colspan="10" class="text-center">No data found</td></tr>'
					);
					$("#datatablePagination").empty();
					console.warn("⚠️ No data found or success flag is false.");
				}
			},
		});
	};

	$("#searchInput").on("input", function () {
		currentPage = 1;
		fetchTableData(cat, { ...lastFilters, name: $(this).val() });
	});

	$("#entriesPerPage").change(function () {
		entriesPerPage = parseInt($(this).val());
		currentPage = 1;
		fetchTableData(cat, lastFilters);
	});

	$("#formpost").on("submit", function (e) {
		e.preventDefault();
		currentPage = 1;
		const filters = {
			firstname: $("#firstname").val(),
			client: $("select[name='client']").val(),
			staff_id: $("input[name='staff_id']").val(),
			role: $("input[name='role']").val(),
			email: $("input[name='email']").val(),
			phone: $("input[name='phone']").val(),
			lastname: $("input[name='lastname']").val(),
		};
		fetchTableData(cat, filters);
	});

	fetchTableData(cat);
});
