<?php
foreach ($contactForms as $row) {
    $id = $row->id;
    $subject = $row->subject;
    $date = substr($row->date, 0, 10);
    $time = substr($row->date, 10);
    $message = $row->message;
    echo '                              <tr> 
                                            <td>
                                                <div class="form-check">
                                                    <input class="form-check-input custom-checkbox" type="checkbox" value=""
                                                        id="checkbox" data-id="' . $id . '">
                                                </div>
                                            </td>
                                            <td>' . $id . '</td>
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

