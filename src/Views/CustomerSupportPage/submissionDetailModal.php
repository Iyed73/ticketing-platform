<?php
require_once "src\Controllers\includes\configSession.inc.php";
$contactForms = unserialize($_SESSION["contactForms"]) ?? [];
foreach ($contactForms as $row) {
    $id = $row->id;
    $name = $row->name;
    $subject = $row->subject;
    $date = substr($row->date, 0, 10);
    $time = substr($row->date, 10);
    $message = $row->message;
    echo
        '
            <div id="submissionDetailsModal' . $id . '" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Submission Details</h4>
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col att">
                                    <p><b>Submission ID</b></p>
                                </div>
                                <div class="col info">
                                    <p>
                                        ' . $id . '
                                    </p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col att">
                                    <p><b>Submitted at</b></p>
                                </div>
                                <div class="col info">
                                    <p>' . $date . '</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col att">
                                    <p><b>Name</b></p>
                                </div>
                                <div class="col info">
                                    <p>' . $name . '</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col att">
                                    <p><b>Subject</b></p>
                                </div>
                                <div class="col info">
                                    <p>' . $subject . '</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col att">
                                    <p style="text-align:center"><b>Message</b></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col message">
                                    <p>' . $message . '</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            ';
}

