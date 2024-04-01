document.addEventListener("DOMContentLoaded", function () {
  // Select all checkboxes when the select all checkbox is checked
  var selectAllCheckbox = document.getElementById("selectAll");
  var checkboxess = document.querySelectorAll(
    'table tbody input[type="checkbox"]'
  );

  selectAllCheckbox.addEventListener("click", function () {
    checkboxess.forEach(function (checkbox) {
      checkbox.checked = selectAllCheckbox.checked;
    });
  });

  checkboxess.forEach(function (checkbox) {
    checkbox.addEventListener("click", function () {
      if (!this.checked) {
        selectAllCheckbox.checked = false;
      }
    });
  });

  // shows the delete button when at least one checkbox is checked
  var checkboxes = document.querySelectorAll(".custom-checkbox");
  const deleteAllSelectedButton = document.querySelector(
    ".deleteAllSelectedButton"
  );

  checkboxes.forEach(function (checkbox) {
    checkbox.addEventListener("change", function () {
      var atLeastOneChecked = false;
      checkboxes.forEach(function (chk) {
        if (chk.checked) {
          atLeastOneChecked = true;
        }
      });
      if (atLeastOneChecked) {
        deleteAllSelectedButton.classList.add("showDeleteAllSelectedButton");
        console.log("At least one checkbox is checked.");
      } else {
        deleteAllSelectedButton.classList.remove("showDeleteAllSelectedButton");
        console.log("No checkbox is checked.");
      }
    });
  });
});

/* function addSubmission() {
  var tableBody = document.querySelector("#dataTable tbody");
  var newRow = document.createElement("tr");

  // Add cells to the row
  newRow.innerHTML = `
            <td>
                <div class="form-check">
                    <input class="form-check-input custom-checkbox" type="checkbox" value="">
                    <label class="form-check-label"></label>
                </div>
            </td>
            <td>New ID</td>
            <td>New Email</td>
            <td>New Subject</td>
            <td>New Date</td>
            <td>New Time</td>
            <td>New Status</td>
            <td>
                <a href="#submissionDetailsModal" class="details" data-toggle="modal">
                    <i class="uil-file-contract"></i>
                </a>
            </td>
            <td>
                <a href="#deleteSubmissionModal" class="delete" data-toggle="modal">
                    <i class="uil-trash"></i>
                </a>
            </td>
        `;

  tableBody.appendChild(newRow);
}
// Function to fetch latest data from server and update HTML table
function updateTable() {
  fetch('fetch_latest_rows.php')
      .then(response => response.json())
      .then(data => {
          const tableBody = document.getElementById('tableBody');
          tableBody.innerHTML = ''; // Clear existing rows
          data.forEach(row => {
              const newRow = `<tr><td>${row.id}</td><td>${row.email}</td><td>${row.subject}</td><td>${row.message}</td><td>${row.status}</td><td>${row.date}</td></tr>`;
              tableBody.innerHTML += newRow;
          });
      })
      .catch(error => console.error('Error fetching data:', error));
}

// Call the updateTable function initially to populate the table
updateTable();

// Set up a timer to periodically fetch updates
setInterval(updateTable, 5000); // Fetch updates every 5 seconds (adjust as needed) */





