<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="./assets/bootstrap-5.3.6-dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">


        <div class="row">
            <div class="col-md-12">

                <?php if($_SESSION['msg']): ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info"><?php echo $_SESSION['msg']; $_SESSION['msg'] = null; ?></div>
                        </div>
                    </div>
                <?php endif; ?>

                <h1>Login</h1>
                <form action="login_act.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>

            </div>
        </div>

    </div>

    <script src="./assets/bootstrap-5.3.6-dist/js/bootstrap.min.js"></script>
</body>

</html>