<?php
$prefix = $_ENV['prefix'];
require_once "src/Models/FormSubmissionsRepo.php"; 


class DeleteSubmissionController {
    public function __construct() {
    }
    public function handleDeletion($prefix) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $submissionId = $_GET['id'];

            $formSubmissionsRepo = new FormSubmissionsRepo();
            // Check if the submissionId is a single id or multiple ids
            if (substr_count($submissionId, ',') == 0){
                $formSubmissionsRepo->deleteFormSubmissions($submissionId);
            } else {
                $submissionId = explode(",", $submissionId);
                foreach ($submissionId as $id) {
                    $formSubmissionsRepo->deleteFormSubmissions($id);
                }
            }

            // Redirect back to the form submissions page
            header("Location:  {$prefix}/customerSupport?page=".$_GET['page']);
            exit();
        } else {
            header("Location:  {$prefix}/customerSupport?invalidSubmissionId");
            exit();
        }
    }
}


$deleteController = new DeleteSubmissionController();
$deleteController->handleDeletion($prefix);
