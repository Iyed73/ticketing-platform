<?php
require_once "src/Models/CategoryRepo.php";
require_once "src\Models\EventRepo.php";

class SearchController {
    private $eventTable;
    private $categoryTable;
    private $searchedEvents;
    private $categories;

    public function __construct() {
        $this->eventTable = new EventRepo();
        $this->categoryTable = new CategoryRepo();
    }
    
    private function getData(){
        if(!isset($_POST['searchInput'])){
            http_response_code(401);
            die();
        }

        $categories = $this->categoryTable->findAll();

        foreach ($categories as $category) $this->categories[] = $category->name;

        $this->searchedEvents = $this->eventTable->getResults($_POST['searchInput']);
    }
    
    public function handleRequest(){
        $this->getData();
                
        $_SESSION["categories"] = serialize($this->categories);
        $_SESSION["searchedEvents"] = serialize($this->searchedEvents);
        
        require_once "src/Views/search.php";
        die();
    }
}

$searchController = new SearchController();
$searchController->handleRequest();


