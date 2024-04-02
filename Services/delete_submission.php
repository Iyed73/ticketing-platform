<?php
$prefix = $_ENV['prefix'];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {

    $submissionId = $_GET['id'];
    require_once "..\src\Models\FormSubmissionsRepo.php";

    $formSubmissionsRepo = new FormSubmissionsRepo();
    // Check if the submissionId is a single id or multiple ids
    if (substr_count($submissionId, ',') == 0){
        $formSubmissionsRepo->deleteFormSubmissions($submissionId);
    }else {
        $submissionId = explode(",", $submissionId);
        foreach ($submissionId as $id) {
            $formSubmissionsRepo->deleteFormSubmissions($id);
        }
    }

    // Redirect back to the form submissions page
    header("Location:  {$prefix}/customerSupport?submissionDeleted");
    exit();
} else {
    header("Location:  {$prefix}/customerSupport?invalidSubmissionId");
    exit();
}
