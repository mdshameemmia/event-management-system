<?php 
include_once '../../../config/Database.php';
include_once '../../../classes/User.php';


function checkAuthenticateUser(){

    $database = new Database();
    $db = $database->getConnection();

    $user_id = $_SESSION['user_id'];
    if(!isset($user_id)){
        header('location: login.php');
    }

    if($user_id){
        $user = new User($db);
        return $user->checkIsUserIsAuthorized($_SESSION);
    }
}

