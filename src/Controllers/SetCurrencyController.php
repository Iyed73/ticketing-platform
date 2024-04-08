<?php
class SetCurrencyController {
    public function handleRequest() {
        if (isset($_POST['currency'])) {
            $_SESSION['currency'] = $_POST['currency'];
        }
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $setCurrencyController = new SetCurrencyController();
    $setCurrencyController->handleRequest();
}