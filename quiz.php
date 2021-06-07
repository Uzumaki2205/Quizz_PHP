<?php
if (!isset($_SESSION)) session_start();
require 'vendor/autoload.php';

use App\SQLiteConnection;
use App\Users;

$pdo = new Users((new SQLiteConnection())->connect());
$questions = $pdo->Question();

if (isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $result = $pdo->SubmitQuestion($_POST, $_POST['mssv'], $_POST['name'], $_POST['email']);
    if ($result) {
?>
        <!-- Modal -->
        <div class="modal fade" id="modalResult" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal Final Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5>MSSV: <?php echo $_POST['mssv'] ?></h5>
                        <h5>NAME: <?php echo $_POST['name'] ?></h5>
                        <h5>RESULT: <?php echo $result ?></h5>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            window.onload = function() {
                document.getElementById('btnModal').click();
            }
        </script> <?php
                }
            }
                    ?>

<?php include 'View/header.php' ?>
<div class="container">
    <form method="POST" action="quiz.php">
        <div class="row g-3 mb-3 needs-validation">
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">MSSV</label>
                <input type="text" class="form-control" id="validationCustom01" value="<?php echo $_SESSION['username'] ?>" name="mssv" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Name</label>
                <input type="text" class="form-control" id="validationCustom02" name="name" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustomEmail" class="form-label">Email</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="email" class="form-control" id="validationCustomEmail" aria-describedby="inputGroupPrepend" name="email" value="<?php echo $_SESSION['email'] ?>" required>
                    <div class="invalid-feedback">
                        Please choose a email.
                    </div>
                </div>
            </div>
        </div>


        <?php $i = 1;
        foreach ($questions as $question) { ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Question <?php echo $i . ': ' . $question['Title'] . ' - ' . $question['Description'] . ' (' . $question['Point'] . 'đ)' ?></h5>
                    <span style="margin-bottom: 20px;">Type: <?php echo $question['TypeQuestion'] ?></span>
                    <div class="list-group form-check">
                        <label class="list-group-item">
                            <input class="form-check-input me-1 question-a" type="radio" name="result<?php echo $question['Id'] ?>" value="1" required>
                            <?php echo $question['ANS_A'] ?>
                        </label>
                        <label class="list-group-item">
                            <input class="form-check-input me-1 question-b" type="radio" name="result<?php echo $question['Id'] ?>" value="2" required>
                            <?php echo $question['ANS_B'] ?>
                        </label>
                        <label class="list-group-item">
                            <input class="form-check-input me-1 question-c" type="radio" name="result<?php echo $question['Id'] ?>" value="3" required>
                            <?php echo $question['ANS_C'] ?>
                        </label>
                        <label class="list-group-item">
                            <input class="form-check-input me-1 question-d" type="radio" name="result<?php echo $question['Id'] ?>" value="4" required>
                            <?php echo $question['ANS_D'] ?>
                        </label>
                    </div>
                </div>
            </div>
        <?php $i++;
        } ?>
        <button class="btn btn-primary mb-3" style="width: 100%;" name="submit" type="submit">Submit</button>
    </form>
</div>
<!-- Button trigger modal -->
<button type="button" style="display: none;" class="btn btn-primary" id="btnModal" data-bs-toggle="modal" data-bs-target="#modalResult">
</button>

<!-- <script>
    window.onload = function() {
        document.getElementById('btnModal').click();
    }
</script> -->
<?php include 'View/footer.php' ?>