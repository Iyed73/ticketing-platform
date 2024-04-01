<?php
try {
    $db = dbConnection::getConnection();

    $sql = "SELECT * FROM form_submissions";
    $stmt = $db->prepare($sql);

    $stmt->execute();

    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $id = $row["id"];
        $email = $row["email"];
        $subject = $row["subject"];
        $date = substr($row["date"], 0, 10);
        $time = substr($row["date"], 10);
        $message = $row["message"];
        echo '                              <tr> 
                                                <td>
                                                    <div class="form-check">
                                                        <input class="form-check-input custom-checkbox" type="checkbox" value=""
                                                            id="checkbox" data-id="' . $id . '">
                                                    </div>
                                                </td>
                                                <td>' . $id . '</td>
                                                <td>' . $email . '</td>
                                                <td>' . $subject . '</td>
                                                <td>' . $date . '</td>
                                                <td>' . $time . '</td>
                                                <td>
                                                    <a href="#submissionDetailsModal' . $id . '" class="details" data-toggle="modal">
                                                        <i class="uil-file-contract"></i>
                                                    </a>

                                                </td>
                                                <td>
                                                    <a class="delete" data-id="' . $id . '"><i class="uil-trash"></i></a>
                                                </td>
                                            </tr>';
    }
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
