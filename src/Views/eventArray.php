<?php
        // some dummy data
$categories = ["Category 1", "Category 2", "Category 3"];
$events = [
    [
        "name" => "Event 1",
        "category" => "Category 1",
        "description" => "Description of Event 1",
        "price" => 10.99,
        "startSellTime" => "2024-03-30 09:00:00",
        "endSellTime" => "2024-03-30 18:00:00",
        "eventDate" => "2024-04-01",
        "image" => "image1.jpg"
    ],
    [
        "name" => "Event 2",
        "category" => "Category 2",
        "description" => "Description of Event 2",
        "price" => 15.99,
        "startSellTime" => "2024-03-31 09:00:00",
        "endSellTime" => "2024-03-31 18:00:00",
        "eventDate" => "2024-04-02",
        "image" => "image2.jpg"
    ],
    [
        "name" => "Event 3",
        "category" => "Category 3",
        "description" => "Description of Event 3",
        "price" => 20.99,
        "startSellTime" => "2024-04-01 09:00:00",
        "endSellTime" => "2024-04-01 18:00:00",
        "eventDate" => "2024-04-03",
        "image" => "image3.jpg"
    ],
    [
        "name" => "Event 4",
        "category" => "Category 1",
        "description" => "Description of Event 4",
        "price" => 25.99,
        "startSellTime" => "2024-03-25 10:00:00",
        "endSellTime" => "2024-03-30 18:00:00",
        "eventDate" => "2024-03-27",
        "image" => "image4.jpg"
    ],
    [
        "name" => "Event 5",
        "category" => "Category 3",
        "description" => "Description of Event 5",
        "price" => 30.99,
        "startSellTime" => "2024-03-20 09:00:00",
        "endSellTime" => "2024-03-30 18:00:00",
        "eventDate" => "2024-03-22",
        "image" => "image5.jpg"
    ],
    [
        "name" => "Event 6",
        "category" => "Category 3",
        "description" => "Description of Event 5",
        "price" => 30.99,
        "startSellTime" => "2024-03-20 09:00:00",
        "endSellTime" => "2024-03-30 18:00:00",
        "eventDate" => "2024-03-22",
        "image" => "image5.jpg"
    ]
];
$eventsByCategory = [];
foreach ($events as $event) {
    $category = $event['category'];
    if (!isset($eventsByCategory[$category])) {
        $eventsByCategory[$category] = [];
    }
    $eventsByCategory[$category][] = $event;
}