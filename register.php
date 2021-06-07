<?php
require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\Users;

if (isset($_POST['signup']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = new Users((new SQLiteConnection())->connect());
    // collect value of input field
    $isSuccess = $pdo->CreateUser($_POST['username'], $_POST['email'], $_POST['password'], $_POST['re_password']);
}
?>

<?php include 'View/header.php' ?>
<div class="container">
    <form class="position-absolute top-50 start-50 translate-middle" style="width: 50%" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <h1 class="text-center">Register</h1>
        <div class="mb-3">
            <label class="form-label">MSSV</label>
            <input type="text" class="form-control" name="username" autofocus required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" name="password" minlength="6" required>
        </div>
        <div class="mb-3">
            <label class="form-label">RePass</label>
            <input type="password" class="form-control" name="re_password" minlength="6" required>
        </div>
        <div style="float: right">
            <button type="submit" class="btn btn-primary" name="signup">Sign Up</button>
            <button type="button" class="btn btn-secondary">Cancel</button>
        </div>
    </form>
</div>
<?php include 'View/footer.php' ?>