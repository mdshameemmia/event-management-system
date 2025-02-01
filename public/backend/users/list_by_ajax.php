<?php

include_once '../../../config/Database.php';
include_once '../../../classes/User.php';

$db = new Database();
$user = new User($db->getConnection());


$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 10;
$offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'name';
$sort_order = isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC';
$key = isset($_GET['key']) ? $_GET['key'] : '';

$globalFilter = [
    'key' => $key?? '',
];


$users = $user->getDashboardData($limit, $offset, $sort_by, $sort_order,$globalFilter);
$totalUsers = $user->getTotalUsers($globalFilter);

echo json_encode([
    'users' => $users,
    'total' => $totalUsers
]);

