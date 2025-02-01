<?php include_once 'partials/header.php';?>

<div class="container">
    <div class="row">
        <h1 class="text-dark text-center my-3"> Login</h1>
        <div class="col-md-6 offset-md-3">
            <fieldset>
                <form action="login_process.php" method="post">
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" placeholder="Enter email here..." id="email" name="email" required>
                        <div class="text-danger">
                            <?php if (isset($_GET['email_error'])): ?>
                                <?php echo $_GET['email_error']; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter password here..." id="password"  name="password" required>
                        <div class="text-danger">
                            <?php if (isset($_GET['password_error'])): ?>
                                <?php echo $_GET['password_error']; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                   
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-success my-1">Login</button> <br>
                        <span href="#">Not registered? <a href="register.php">Create an account</a> </span>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>

<?php include_once 'partials/footer.php'; ?>