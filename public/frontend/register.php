<?php include_once 'partials/header.php'; ?>

<div class="container">
    <h1 class="text-dark text-center my-3">User Registration Form</h1>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <fieldset>
                <form action="register_process.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" placeholder="Enter name here..." id="name" name="name" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['name_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" placeholder="Enter email here..." id="email" name="email" required>
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
                        <input type="text" class="form-control" placeholder="Enter mobile here..." id="mobile" maxlength="11" name="mobile" required>
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

<?php include_once 'partials/footer.php'; ?>