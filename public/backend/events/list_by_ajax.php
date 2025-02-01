<?php

include_once '../../../config/Database.php';
include_once '../../../classes/Event.php';

$db = new Database();
$event = new Event($db->getConnection());


$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'startdate';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
$location = isset($_GET['location']) ? $_GET['location'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

$key = isset($_GET['key']) ? $_GET['key'] : '';

$globalFilter = [
    'key' => $key?? '',
];


$events = $event->getDashboardData($limit, $offset, $sort_by, $sort_order, $globalFilter);
$totalEvents = $event->getTotalEvents($globalFilter);

echo json_encode([
    'events' => $events,
    'total' => $totalEvents
]);

