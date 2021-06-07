<?php
require 'vendor/autoload.php';
?>

<?php include('View/header.php') ?>
<div class="container">
    <?php
    if (!isset($_SESSION['username']) || !isset($_SESSION['email'])) {
    ?>
        <h1 class="text-center">Welcome To Dashboard</h1>
        <h2 class="text-center">Login To Quiz</h2>
    <?php } else { ?>
        <h1 class="text-center">Welcome <?php echo $_SESSION['username'] ?> Go To Dashboard</h1>
    <?php } ?>
</div>
<?php include('View/footer.php') ?>