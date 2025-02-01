<?php

include_once '../../../config/Database.php';
include_once '../../../classes/EventRegistration.php';

$db = new Database();
$eventRegistration = new EventRegistration($db->getConnection());


$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'email';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';

$key = isset($_GET['key']) ? $_GET['key'] : '';

$globalFilter = [
    'key' => $key?? '',
];


$eventRegistrations = $eventRegistration->getDashboardData($limit, $offset, $sort_by, $sort_order, $globalFilter);
$totaleventRegistrations = $eventRegistration->getTotalEventRegistrations($globalFilter);

echo json_encode([
    'eventRegistrations' => $eventRegistrations,
    'total' => $totaleventRegistrations
]);

