<!DOCTYPE html>
<html lang="sr">

<?php
session_start();
$page_title = "Unos pitanja";
require "connection.php";
require "head.php";

$testId = mysqli_real_escape_string($conn, $_GET['select_test']);
$sqlSelect = "SELECT * FROM tests WHERE id = '$testId'";
$querySelect = mysqli_query($conn, $sqlSelect);
$testName = mysqli_fetch_all($querySelect, MYSQLI_ASSOC);


if (array_key_exists('id', $_SESSION) && isset($_SESSION['id']) && isset($_POST['edit_questions'])) {
    
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer1 = mysqli_real_escape_string($conn, $_POST['answer1']);
    $answer2 = mysqli_real_escape_string($conn, $_POST['answer2']);
    $answer3 = mysqli_real_escape_string($conn, $_POST['answer3']);
    $answer4 = mysqli_real_escape_string($conn, $_POST['answer4']);
    $answer5 = mysqli_real_escape_string($conn, $_POST['answer5']);
    $correct_answer = mysqli_real_escape_string($conn, $_POST['correct_answer']);
    $test_id = mysqli_real_escape_string($conn, $_GET['select_test']);

    $error = NULL;
    $correct = NULL;

        if (!$question || !$answer1 || !$answer2 || !$answer3 || !$answer4  || !$answer5 || !$correct_answer) {
          $error = "Sva polja moraju biti popunjena";
        } else {
          $sql = "INSERT INTO questions (question, answer1, answer2, answer3, answer4, answer5, correct_answer, test_id) 
          VALUES ('$question', '$answer1', '$answer2', '$answer3', '$answer4', '$answer5','$correct_answer', '$test_id')";
          
          if (mysqli_query($conn, $sql)) {
            $correct = "Uspešno ste uneli pitanje.";
          }
        }
}

?>

<body>

<?php 
require "header.php";
?>

<h1>Unos pitanja za test: <?php echo htmlspecialchars($testName[0]['test_name']) ?></h1>
<div class="container">
  <div class="row table_bg">
    <div class="col-1"></div>
    
    <div class="col-9">

      <form action="edit_questions.php?select_test=<?php echo htmlspecialchars($_GET['select_test']); ?>" method="post" class="text-light">
        
        <span style="color: red; font-weight: 700; font-size: 16px; margin-left: 70px;"> <?php echo $error ?? ''; ?> </span>
        <span style="color: green; font-weight: 700; font-size: 15px;"><?php echo $correct ?? ''; ?></span>

        <div class="mb-3">
          <input readonly type="hidden" name="test_name" value="<?php echo $testName[0]['test_name'] ?>" class="form-control" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label class="form-label">Pitanje</label>
          <input type="text" name="question" placeholder="Unesite pitanje" class="form-control" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label class="form-label">Odgovor 1</label>
          <input type="text" name="answer1" placeholder="Unesite odgovor 1" class="form-control" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label class="form-label">Odgovor 2</label>
          <input type="text" name="answer2" placeholder="Unesite odgovor 2" class="form-control" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label class="form-label">Odgovor 3</label>
          <input type="text" name="answer3" placeholder="Unesite odgovor 3" class="form-control" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label class="form-label">Odgovor 4</label>
          <input type="text" name="answer4" placeholder="Unesite odgovor 4" class="form-control" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label class="form-label">Odgovor 5</label>
          <input type="text" name="answer5" placeholder="Unesite odgovor 5" class="form-control" aria-describedby="emailHelp">
        </div>

        <div class="mb-3">
          <label class="form-label">Tačan odgovor je:</label>
          <select name="correct_answer">
            <option>---</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="4">5</option>
          </select>
        </div>

        <button type="submit" name="edit_questions" class="btn btn-danger">Unos pitanja</button>

      </form>
    </div>

<!--     <div class="col-2"></div> -->  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>