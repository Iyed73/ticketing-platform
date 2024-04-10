<?php
$prefix = $_ENV['prefix'];

class DeleteSubmissionController {
    public function __construct() {
    }
    public function handleDeletion($prefix) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
            $submissionId = $_GET['id'];

            $FormSubmissionsModel = new FormSubmissionsModel();
            // Check if the submissionId is a single id or multiple ids
            if (substr_count($submissionId, ',') == 0){
                $FormSubmissionsModel->deleteFormSubmissions($submissionId);
            } else {
                $submissionId = explode(",", $submissionId);
                foreach ($submissionId as $id) {
                    $FormSubmissionsModel->deleteFormSubmissions($id);
                }
            }

            // Redirect back to the form submissions page
            if(isset($_GET['page'])) {
                header("Location:  {$prefix}/customerSupport?page=".$_GET['page']);
                exit();
            }
            else{
                header("Location:  {$prefix}/customerSupport?page=1");
                exit();
            }

        } else {
            header("Location:  {$prefix}/customerSupport?invalidSubmissionId");
            exit();
        }
    }
}


$deleteController = new DeleteSubmissionController();
$deleteController->handleDeletion($prefix);
