<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Form Submissions</h2>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-danger deleteAllSelectedButton">
                                <i class="uil-trash"></i>
                                <span>Delete</span>
                            </a>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>
                                <div class="form-check">
                                    <input class="form-check-input custom-checkbox" type="checkbox" value=""
                                        id="selectAll">
                                    <label class="form-check-label" for="selectAll"></label>
                                </div>
                            </th>

                            <th>ID</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Details</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php include "src\Views\CustomerSupportPage\submissionsTableBody.php" ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php include "src\Views\CustomerSupportPage\submissionDetailModal.php" ?>
    <script src="Static\JS\customerSupportScript.js"></script>