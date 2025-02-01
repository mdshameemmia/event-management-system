<?php 
include_once '../partials/header.php';
include_once '../../../config/Database.php';
include_once '../../../classes/User.php';

$database = new Database();
$db = $database->getConnection();

$user  = new User($db);
$data = $user->edit($_GET);

if(!$data['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $data['message'];
    // header("Location: edit.php");
    // exit;
}
$user = $data['user'];

?>

<div class="container">
    <h1 class="text-dark text-center my-3">User Registration Form</h1>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <fieldset>
                <form action="update.php" method="post">
                <input type="hidden" name="id" value="<?= $user['id'] ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" value="<?= $user['name']?? '' ?>" placeholder="Enter name here..." id="name" name="name" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['name_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" value="<?= $user['email']?? '' ?>" placeholder="Enter email here..." id="email" name="email" required>
                        <div class="text-danger alert-msg">
                        <?= htmlspecialchars($_SESSION['error']['email_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter password here..." id="password"  name="password" required>
                        <div class="text-danger alert-msg">
                        <?= htmlspecialchars($_SESSION['error']['password_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Enter confirm password here..." id="confirm_password" name="confirm_password" required>
                        <div class="text-danger alert-msg">
                        <?= htmlspecialchars($_SESSION['error']['confirm_password_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" value="<?= $user['mobile']?? '' ?>" placeholder="Enter mobile here..." id="mobile" maxlength="11" name="mobile" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['mobile_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>

<?php include_once '../partials/footer.php'; ?>