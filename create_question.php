<?php
require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\Admin;

$pdo = new Admin((new SQLiteConnection())->connect());
if (isset($_POST['create']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    // collect value of input field
    $isSuccess = $pdo->CreateQuestion(
        $_POST['title'],
        $_POST['description'],
        $_POST['type_question'],
        $_POST['point_question'],
        $_POST['answer_A'],
        $_POST['answer_B'],
        $_POST['answer_C'],
        $_POST['answer_D'],
        $_POST['result']
    );
?> <script>
        alert('<?php echo $isSuccess ?>')
    </script> <?php
            }
                ?>
<?php include 'View/admin.header.php' ?>
<h1 class="text-center">Input Question Below</h1>
<form class="align-middle p-5" method="post" action="create_question.php">
    <div class="input-group mb-3">
        <span class="input-group-text">Title</span>
        <input type="text" class="form-control" aria-label="Title" name="title" required>
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text">Description</span>
        <input type="text" class="form-control" name="description">
    </div>
    <div class="input-group mb-3">
        <span class="input-group-text">Type Question</span>
        <input type="text" class="form-control" name="type_question">
    </div>
    <div class="input-group mb-3">
        <select class="form-select" name="point_question">
            <option selected value="5">Point of Question (Default = 5)</option>
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="15">15</option>
            <option value="20">20</option>
            <option value="25">25</option>
            <option value="30">30</option>
        </select>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" value="1" name="result">
        </div>
        <input type="text" class="form-control" placeholder="Answer A" name="answer_A" required>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" value="2" name="result">
        </div>
        <input type="text" class="form-control" placeholder="Answer B" name="answer_B" required>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" value="3" name="result">
        </div>
        <input type="text" class="form-control" placeholder="Answer C" name="answer_C" required>
    </div>
    <div class="input-group mb-3">
        <div class="input-group-text">
            <input class="form-check-input mt-0" type="checkbox" value="4" name="result">
        </div>
        <input type="text" class="form-control" placeholder="Answer D" name="answer_D" required>
    </div>
    <div class="form-group mb-3" style="float: right">
        <button type="submit" name="create" class="btn btn-primary">Create</button>
        <a href="create_question.php"><button type="button" class="btn btn-danger">Cancel</button></a>
    </div>
</form>

<?php include 'View/admin.footer.php' ?>