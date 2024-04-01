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
                            <a href="#deleteSubmissionModal" class="btn btn-danger deleteAllSelectedButton"
                                data-toggle="modal">
                                <i class="uil-trash"></i>
                                <span>Delete</span></a>
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
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Details</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-check">
                                    <input class="form-check-input custom-checkbox" type="checkbox" value=""
                                        id="selectAll">
                                    <label class="form-check-label" for="selectAll"></label>
                                </div>
                            </td>
                            <?php   
                                /* require_once "src\Models\FormSubmissionsRepo.php";
                                $formSubmissionsRepo = new FormSubmissionsRepo();
                                $submissions = $formSubmissionsRepo->getAllFormSubmissions();
                                foreach ($submissions as $submission) {
                                    $submission->delete();
                                } */
                            ?>

                            <td>1</td>
                            <td>thomashardy@mail.com</td>
                            <td>refund</td>
                            <td>22/12/2018</td>
                            <td>12:45:07</td>
                            <td>pending</td>

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
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- <div class="clearfix">
                <div class="hint-text">Showing <b>5</b> out of <b>25</b> entries</div>
                <ul class="pagination">
                    <li class="page-item disabled"><a href="#">Previous</a></li>
                    <li class="page-item"><a href="#" class="page-link">1</a></li>
                    <li class="page-item"><a href="#" class="page-link">2</a></li>
                    <li class="page-item active"><a href="#" class="page-link">3</a></li>
                    <li class="page-item"><a href="#" class="page-link">4</a></li>
                    <li class="page-item"><a href="#" class="page-link">5</a></li>
                    <li class="page-item"><a href="#" class="page-link">Next</a></li>
                </ul>
            </div> -->
        </div>
    </div>
    <div id="submissionDetailsModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submission Details</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col att">
                            <p><b>Submission ID</b></p>
                        </div>
                        <div class="col info">
                            <p>456</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col att">
                            <p><b>Submitted at</b></p>
                        </div>
                        <div class="col info">
                            <p>22:45:07 01/01/2012</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col att">
                            <p><b>Submission status</b></p>
                        </div>
                        <div class="col info">
                            <p>pending</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col att">
                            <p><b>Name</b></p>
                        </div>
                        <div class="col info">
                            <p>Seif Chouchane</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col att">
                            <p><b>Email</b></p>
                        </div>
                        <div class="col info">
                            <p>euseifchouchane@gmail.com</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col att">
                            <p><b>Subject</b></p>
                        </div>
                        <div class="col info">
                            <p>fqdfdqfq</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col att">
                            <p style="text-align:center"><b>Message</b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col message">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. lacus. Nam dictum cursus tellus,
                                nec laoreet ligula consectetur a.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="deleteSubmissionModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Delete</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this submission?</p>
                    <p class="text-warning"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                    <input type="submit" class="btn btn-danger" value="Delete">
                </div>
            </div>
        </div>
    </div>
    <script src="Static\JS\customerSupportScript.js"></script>