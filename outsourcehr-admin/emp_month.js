let currentPage = 1;
let currentLimit = 10;
let currentSearch = "";
let totalRecords = 0; // set this at top-level scope


$(document).on("click", ".page-link", function (e) {
	e.preventDefault();
	const pageAction = $(this).data("page");
	const totalPages = Math.ceil(totalRecords / currentLimit); // define totalRecords globally if needed

	if (pageAction === "prev" && currentPage > 1) {
		currentPage--;
	} else if (pageAction === "next" && currentPage < totalPages) {
		currentPage++;
	} else if (!isNaN(pageAction)) {
		currentPage = parseInt(pageAction);
	} else {
		return;
	}

	loadEmployees(currentPage);
});


function loadEmployees(page = 1) {
    
    const token = new URLSearchParams(window.location.search).get("token");  
    
		

	$.getJSON(
		"get_employees.php",
		{
			token: token,
			page: page,
			limit: currentLimit,
			search: currentSearch,
		},
        function (res) {
					const tbody = $(".table tbody");
					const userPrivilege = localStorage.getItem("userPrivilege");
					tbody.empty();

					if (res.data.length === 0) {
						tbody.append("<tr><td colspan='3'>No records found</td></tr>");
						$("#pagination").html("");
						return;
					}

					res.data.forEach((emp, index) => {
						const passport = res.passport
							? `./assets/img/160x160/${emp.passport}`
							: `./assets/img/160x160/img10.jpg`;

						const modalId = `newProjectModal${emp.id}`;

						tbody.append(`
<tr>
  <td>${(res.page - 1) * res.limit + index + 1}</td>
  <td class="table-column-ps-0">
    <span class="d-flex align-items-center">
      <div class="flex-shrink-0">
        <div class="avatar avatar-sm avatar-circle">
          <img src="${passport}" class="rounded-circle avatar" alt="">
        </div>
      </div>
      <div class="flex-grow-1 ms-3">
        <h5 class="text-inherit mb-0">${emp.firstname} ${emp.lastname}</h5>
        <span class="fs-5">${emp.email}</span>
      </div>
    </span>
  </td>
  <td>${emp.staff_id}</td>
  <td>${emp.position}</td>
  
  <td>${emp.salary}</td>
  <td>${emp.paye}</td>
  <td>${emp.pension}</td>
  ${
		userPrivilege == "Super Admin"
			? `
  <td style="text-align: left;">
    <a href="javascript:;" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#${modalId}">
      <i class="bi-eye" title="View full details of employee salary"></i>
    </a>

    <div class="modal fade" id="${modalId}" tabindex="-1" aria-labelledby="newProjectModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newProjectModalLabel">See ${emp.firstname} ${emp.lastname} Staff Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body">
                        <!-- Step Form -->
                        <form class="js-step-form" data-hs-step-form-options='{
                                                            "progressSelector": "#createProjectStepFormProgress",
                                                            "stepsSelector": "#createProjectStepFormContent",
                                                            "endSelector": "#createProjectFinishBtn",
                                                            "isValidate": false
                                                            }' method="post" enctype="multipart/form-data">


                            <!-- Content Step Form -->
                            <div id="createProjectStepFormContent">
                                <div id="createProjectStepDetails" class="active">


                                    <!-- Form -->
                                    <div class="details">
                                        <div class="mb-4">

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Client [optional] </label>
                                                    <div class="input-group input-group-merge">

                                                        <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="${emp.client}" aria-label="" readonly>
                                                    </div>
                                                </div>
                                                <!-- End Col -->
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Name</label>
                                                    <div class="input-group input-group-merge">
                                                        <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="${emp.firstname} ${emp.lastname}" aria-label="" readonly>
                                                    </div>
                                                </div>
                                                <!-- End Col -->
                                            </div>
                                            <!-- End Row -->
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="mb-4">

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Position</label>
                                                    <div class="input-group input-group-merge">
                                                        <input class="form-control" id="clientNewProjectLabel" placeholder="" name="position" value="${emp.position}" aria-label="" readonly>
                                                    </div>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Staff_ID </label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="${emp.staff_id}" aria-label="" readonly>
                                                    </div>
                                                </div>
                                                <!-- End Col -->
                                            </div>
                                            <!-- End Row -->
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="mb-4">

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Email</label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="email" class="form-control" id="clientNewProjectLabel" placeholder="" name="email" value="${emp.email}" aria-label="" readonly>
                                                    </div>
                                                </div>
                                                <!-- End Col -->

                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Phone Number</label>
                                                    <div class="input-group input-group-merge">
                                                        <input class="form-control" id="clientNewProjectLabel" placeholder="" name="gross" value="${emp.phone}" aria-label="" readonly>
                                                    </div>
                                                </div>

                                                <!-- End Col -->
                                            </div>
                                            <!-- End Row -->
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="mb-4">

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Position </label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_vol" value="${emp.position}" aria-label="" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Department </label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_stat" value="${emp.department}" aria-label="" readonly>
                                                    </div>
                                                </div>
                                                <!-- End Col -->

                                                <!-- End Col -->
                                            </div>
                                            <!-- End Row -->
                                        </div>
                                        <!-- End Form -->

                                        <!-- Form -->
                                        <div class="mb-4">

                                            <div class="row align-items-center">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Bank(%) </label>
                                                    <div class="input-group input-group-merge">
                                                        <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="loan" value="${emp.bank_name}" aria-label="" readonly>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-md-6 mb-3">
                                                    <label for="clientNewProjectLabel" class="form-label">Bank Account </label>
                                                    <div class="input-group input-group-merge">
                                                        <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="${emp.bank_account}" aria-label="" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End Row -->
                                        </div>
                                        <!-- End Form -->
                                    </div>

                                    <div class="allow">
    <h5 class="modal-title mt-2 mb-3" id="newProjectModalLabel">Staff Allowance</h5>
    <div class="mb-4">
      
        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Monthly Gross </label>
                <div class="input-group input-group-merge">

                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="${emp.allowance.gross}" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Salary </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="${emp.allowance.gross}" aria-label="" readonly>
                </div>
            </div>
            <div class="col-12 col-md-12 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Basic </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="${emp.allowance.basic}" aria-label="" readonly>
                </div>
            </div>
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Gross</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="${emp.allowance.gross_income}" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Gross</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="position" value="${emp.allowance.annual_gross_income}" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->

            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Basic </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="${emp.allowance.basic}" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Housing</label>
                <div class="input-group input-group-merge">
                    <input type="email" class="form-control" id="clientNewProjectLabel" placeholder="" name="email" value="${emp.allowance.housing}" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Transport</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="gross" value="${emp.allowance.transport}" aria-label="" readonly>
                </div>
            </div>

            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Utility </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_vol" value="${emp.allowance.utility}" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Leave Allowance </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_stat" value="${emp.allowance.leave_allo}" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->

            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">13<sup>th</sup> Month </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="loan" value="${emp.allowance["13th_month"]}" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Entertainment </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="${emp.allowance.meals}" aria-label="" readonly>
                </div>
            </div>
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Consolidated Relief </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="${emp.allowance.consolidated_relief}" aria-label="" readonly>
                </div>
            </div> -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->
</div>
                                    <div class="deduct">
    <h5 class="modal-title mt-2 mb-3" id="newProjectModalLabel">Staff Deduction</h5>
    <div class="mb-4">

        <div class="row align-items-center">
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Employee Pension </label>
                <div class="input-group input-group-merge">

                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="${emp.allowance.pension}" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Pension</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="name" value="${emp.allowance.annual_pension}" aria-label="" readonly>
                </div>
            </div> -->
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Employer Pension </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="${emp.allowance.employer_pension}" aria-label="" readonly>
                </div>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">NHF </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="${emp.allowance.monthly_nhf}" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual NHF</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="position" value="${emp.allowance.annual_nhf}" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->

            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Total Relief </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_id" value="${emp.allowance.total_relief}" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Taxable Income</label>
                <div class="input-group input-group-merge">
                    <input type="email" class="form-control" id="clientNewProjectLabel" placeholder="" name="email" value="${emp.allowance.taxable}" aria-label="" readonly>
                </div>
            </div> -->
            <!-- End Col -->

            <!-- <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Annual Tax</label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="gross" value="${emp.allowance.annual_tax}" aria-label="" readonly>
                </div>
            </div> -->

            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Paye </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_vol" value="${emp.allowance.total_paye}" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">Total Salary Deduction </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="staff_stat" value="${emp.allowance.total_deduction}" aria-label="" readonly>
                </div>
            </div>
            <!-- End Col -->

            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->

    <!-- Form -->
    <div class="mb-4">

        <div class="row align-items-center">
            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">NSITF </label>
                <div class="input-group input-group-merge">
                    <input type="text" class="form-control" id="clientNewProjectLabel" placeholder="" name="loan" value="${emp.allowance.nsitf}" aria-label="" readonly>
                </div>
            </div>

            <div class="col-12 col-md-6 mb-3">
                <label for="clientNewProjectLabel" class="form-label">ITF </label>
                <div class="input-group input-group-merge">
                    <input class="form-control" id="clientNewProjectLabel" placeholder="" name="allowance" value="${emp.allowance.itf}" aria-label="" readonly>
                </div>
            </div>
        </div>
        <!-- End Row -->
    </div>
    <!-- End Form -->
</div>

                                    <!-- Form -->
                                    <!-- Footer -->
                                    <div class="d-flex align-items-center mt-5">
                                        <div class="ms-auto">
                                            <button type="button" class="btn btn-primary allowance" data-hs-step-form-next-options='{
                                                                        "targetSelector": "#createProjectStepTerms"
                                                                        }'>
                                                Show Allowance
                                            </button>
                                            <button type="button" class="btn btn-primary personal" data-hs-step-form-next-options='{
                                                                        "targetSelector": "#createProjectStepTerms"
                                                                        }'>
                                                Show Personal Details
                                            </button>

                                            <button type="button" class="btn btn-outline-danger deductions" data-hs-step-form-next-options='{
                                                                        "targetSelector": "#createProjectStepTerms"
                                                                        }'>
                                                Show Deduction
                                            </button>
                                        </div>
                                        <!-- End Footer -->
                                    </div>
                                </div>
                                <!-- End Content Step Form -->
                        </form>
                        <!-- End Step Form -->
                    </div>
                    <!-- End Body -->
                </div>
            </div>
        </div>
  </td>`
			: `<td>-</td>`
	}
</tr>`);
					});
					// After appending the modal HTML for this employee
					$(document).ready(function() {
            $('.allow').hide()
            $('.deduct').hide()
            $('.personal').hide()
            $('.allowance').click(function() {
                $('.allow').show()
                $('.details').hide()
                $('.deduct').hide()
                $('.allowance').hide()
                $('.personal').show()
                $('.deductions').show()
            })
            $('.deductions').click(function() {
                $('.allow').hide()
                $('.details').hide()
                $('.deductions').hide()
                $('.allowance').show()
                $('.deduct').show()
                $('.personal').show()
            })
            $('.personal').click(function() {
                $('.allow').hide()
                $('.allowance').show()
                $('.details').show()
                $('.deductions').show()
                $('.deduct').hide()
                $('.personal').hide()
            })

        })

					// Pagination
					// Pagination with ellipsis
					totalRecords = res.total; // update this line
					updatePaginationControls(totalRecords, res.limit);
				}
	);
}


function updatePaginationControls(totalRecords, entriesPerPage) {
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

// Event bindings
$(document).on("click", ".page-btn", function () {
	const page = $(this).data("page");
	currentPage = page;
	loadEmployees(page);
});

$("#datatableEntries").on("change", function () {
	currentLimit = parseInt(this.value);
	currentPage = 1;
	loadEmployees(currentPage);
});

$("#searchInput").on("input", function () {
	currentSearch = this.value;
	currentPage = 1;
	loadEmployees(currentPage);
});

// Initial load
loadEmployees();