// Initialize the page number and the number of items per page
var currentPage = 1;
var itemsPerPage = 10;

// Function to get the data for the current page using Ajax
function getData() {
	// Make an Ajax request to get the data for the current page
	var xhr = new XMLHttpRequest();
	xhr.onreadystatechange = function () {
		if (xhr.readyState == 4 && xhr.status == 200) {
			// Parse the JSON response and display the data
			var data = JSON.parse(xhr.responseText);
			displayData(data);
		}
	};
	xhr.open("GET", "/data?page=" + currentPage + "&per_page=" + itemsPerPage);
	xhr.send();
}

// Function to display the data for the current page
function displayData(data) {
	// Display the data on the page
	var container = document.getElementById("data-container");
	container.innerHTML = "";
	data.forEach(function (item) {
		var element = document.createElement("div");
		element.innerHTML = item.title;
		container.appendChild(element);
	});

	// Update the pagination links
	var pagination = document.getElementById("pagination");
	pagination.innerHTML = "";
	for (var i = 1; i <= Math.ceil(data.total / itemsPerPage); i++) {
		var link = document.createElement("a");
		link.href = "#";
		link.innerHTML = i;
		link.onclick = function () {
			currentPage = this.innerHTML;
			getData();
			return false;
		};
		if (i == currentPage) {
			link.classList.add("active");
		}
		pagination.appendChild(link);
	}
}

// Call the getData function to display the initial data
getData();
