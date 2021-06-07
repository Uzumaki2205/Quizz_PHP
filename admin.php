<?php
require 'vendor/autoload.php';
use App\SQLiteConnection;
use App\Admin;
$isAdmin = new Admin((new SQLiteConnection())->connect()); ?>

<?php include 'View/admin.header.php'?>
    <h1 class="text-center">Welcome to Admin Dashboard</h1>
<?php include 'View/admin.footer.php'?>
