<!DOCTYPE html>
<html lang="sr">

<?php
session_start();
$page_title = "Pregled pitanja";
require "connection.php";
require "head.php";


if (array_key_exists('id', $_SESSION) && isset($_SESSION['id'])) {

    $testId = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT questions.id AS q_id, question, answer1, answer2, answer3, answer4, answer5, correct_answer  FROM questions LEFT JOIN tests ON questions.test_id = tests.id WHERE questions.test_id = '$testId'";
    $query = mysqli_query($conn, $sql);
    $results = mysqli_fetch_all($query, MYSQLI_ASSOC);

    $sql1 = "SELECT * FROM tests WHERE id = '$testId'";
    $query1 = mysqli_query($conn, $sql1);
    $result = mysqli_fetch_all($query1, MYSQLI_ASSOC);

    if (isset($_POST['send_test'])) {

      $test_id = mysqli_real_escape_string($conn, $_GET['id']);

      $sql2 = "SELECT * FROM tests";
      $query2 = mysqli_query($conn, $sql2);
      $results2 = mysqli_fetch_all($query2, MYSQLI_ASSOC);
      $correct = 0;

        for ($i=0; $i < count($results2); $i++) {
          $sql3 = "UPDATE tests SET display_test = 1 WHERE id = $test_id";
          $sql4 = "UPDATE tests SET display_test = 0 WHERE id <> $test_id";
          mysqli_query($conn, $sql3) && mysqli_query($conn, $sql4);
        }
        
        $correct = "Test je uspešno poslat učenicima";
    }

}
?>

<body>

<?php 
require "header.php";
?>

<h1>Pregled pitanja za test: <?php echo " ". htmlspecialchars($result[0]['test_name']); ?></td>
</h1>
<div class="container">
  <div class="row table_bg">

    <div class="col-11">

      <form action="preview_test.php?id=<?php echo $_GET['id'] ?>" method="post">
      <span style="color: green; font-weight: 700; font-size: 16px; margin-left: 70px;"> <?php echo $correct ?? ''; ?> </span>

          <table class="table table-hover preview_tests">
            <thead>
              <tr>
                <th>#</th>
                <th>Pitanje</th>
                <th>Odgovor 1</th>
                <th>Odgovor 2</th>
                <th>Odgovor 3</th>
                <th>Odgovor 4</th>
                <th>Odgovor 5</th>
                <th>Tačan odgovor</th>
                <th>Obrisati pitanje</th>
              </tr>
            </thead>

            <?php for($i=0; $i < count($results); $i++) { ?>
              <tr>
                <td><?php echo $i+1; ?></td>
                <td><?php echo htmlspecialchars($results[$i]['question']); ?></td>
                <td><?php echo htmlspecialchars($results[$i]['answer1']); ?></td>
                <td><?php echo htmlspecialchars($results[$i]['answer2']); ?></td>
                <td><?php echo htmlspecialchars($results[$i]['answer3']); ?></td>
                <td><?php echo htmlspecialchars($results[$i]['answer4']); ?></td>
                <td><?php echo htmlspecialchars($results[$i]['answer5']); ?></td>
                <td><?php echo htmlspecialchars($results[$i]['correct_answer']); ?></td>
                <td><a href="delete_question.php?id=<?php echo htmlspecialchars($results[$i]['q_id']); ?>&test=<?php echo $testId; ?>" class="btn btn-danger btn-sm">Obrisati</a></td>

              </tr>
            <?php } ?>
          </table>

        <input type="submit" name="send_test" value="Pošalji učenicima" class="btn btn-danger">

      </form>
    </div>

    <!-- <div class="col-2"></div> -->
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>