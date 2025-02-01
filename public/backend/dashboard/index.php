<?php 
include_once '../partials/header.php';

?>

<div class="container">
<h1 class="text-dark text-center my-3">Admin Control Panel</h1>

<div class="row dashboard">
    <div class="col-md-3 ">
    <a href="../users/index.php" class="text-decoration-none">
        <div class="card text-center bg-success text-white" >
            <div class="card-body">
                <h5 class="card-title">Users</h5>
            </div>
        </div>
    </a>
    </div>
    <div class="col-md-3 ">
        <a href="../events/index.php" class="text-decoration-none">
            <div class="card text-center bg-info text-white" >
                <div class="card-body">
                    <h5 class="card-title">Events</h5>
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 ">
        <a href="../attendees/index.php" class="text-decoration-none">
        <div class="card text-center bg-primary text-white" >
            <div class="card-body">
                <h5 class="card-title">Attendees</h5>
            </div>
        </div>
        </a>
    </div>
    <div class="col-md-3 ">
        <a href="../reports/index.php" class="text-decoration-none">
        <div class="card text-center bg-warning text-white" >
            <div class="card-body">
                <h5 class="card-title">Reports & API</h5>
            </div>
        </div>
        </a>
    </div>
</div>  
</div>

<?php include_once '../partials/footer.php';?>
