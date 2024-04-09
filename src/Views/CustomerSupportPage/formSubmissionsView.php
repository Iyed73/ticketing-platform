<div class="container-fluid">
    <div class="container py-5">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Contact Form Submissions</h2>
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
        <nav aria-label="page_nav" class="d-flex justify-content-center">
            <ul class="pagination d-inline-flex justify-content-between">
                <?php if ($currentPage > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo ($currentPage == $i) ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>

                <?php if ($currentPage < $totalPages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
    <?php include "src\Views\CustomerSupportPage\submissionDetailModal.php" ?>