<?php  
session_start();
include_once '../../../config/app.php';
include_once '../../../config/checkingAuthenticateUser.php';
if(!checkAuthenticateUser() && !checkAuthenticateUser()['status'] == true){
    header("Location:". "../../frontend/login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="../../../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../../../assets/css/style.css" rel="stylesheet" />
    <link href="../../../assets/css/bootstrap-icons.min.css" rel="stylesheet" />
</head>

<body>
<nav class="navbar navbar-expand-lg  text-white" >
  <div class="container-fluid">
    <a class="navbar-brand" href="../dashboard/index.php">Event Management System</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      </ul>
      <div class="d-flex login-register">
        <a href="../logout.php" class="btn btn-outline-danger text-white">Logout</a>
      </div>
    </div>
  </div>
</nav>