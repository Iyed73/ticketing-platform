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
  var deleteAllSelectedButton = document.querySelector(
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

  // Delete button for each submission
  var deleteButtons = document.querySelectorAll(".delete");
  deleteButtons.forEach(function (button) {
    button.addEventListener("click", function () {
      var submissionId = this.getAttribute("data-id");
      var confirmation = confirm(
        "Are you sure you want to delete this submission?"
      );
      if (confirmation) {
        // Redirect to DeleteSubmissionController.php with submission ID
        window.location.href =
          "./deleteSubmission?id=" + submissionId+"&"+(window.location.search).substring(1);
      }
    });
  });

  // Delete button for all selected submissions

  deleteAllSelectedButton.addEventListener("click", function () {
    const selectedCheckboxes = document.querySelectorAll(
      ".custom-checkbox:checked:not(#selectAll)"
    );
    const selectedSubmissionIds = Array.from(selectedCheckboxes).map(function (
      checkbox
    ) {
      return checkbox.getAttribute("data-id");
    });
    const confirmation = confirm(
      "Are you sure you want to delete the selected submissions?"
    );
    if (confirmation) {
        // Redirect to DeleteSubmissionController.php with submission IDs
        window.location.href =
        "./deleteSubmission?id=" +
        selectedSubmissionIds.join(",")+"&"+(window.location.search).substring(1);
    }
  });
});
