<?php
try {
    $db = dbConnection::getConnection();

    $sql = "SELECT * FROM form_submissions";
    $stmt = $db->prepare($sql);

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $id = $row["id"];
        $name = $row["name"];
        $subject = $row["subject"];
        $date = $row["date"];
        $message = $row["message"];
        echo
            '
                <div id="submissionDetailsModal' . $id . '" class="modal fade">
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
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
