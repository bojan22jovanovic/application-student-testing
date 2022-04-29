<!DOCTYPE html>
<html lang="sr">

<?php
session_start();
$page_title = "Odgovori učenika";
require "connection.php";
require "head.php";


if (array_key_exists('id', $_SESSION) && isset($_SESSION['id'])) {

    $userId = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = 
    "SELECT members.id AS m_id, userName, userLastName, birthYear, user_tests.user_id AS ut_id, question_id, user_answer, questions.id AS q_id, question, answer1, answer2, answer3, answer4, answer5, questions.correct_answer AS qca, questions.test_id AS qt_id, tests.id AS t_id, test_name
    FROM members 
    RIGHT JOIN user_tests ON members.id = user_tests.user_id 
    LEFT JOIN questions ON question_id = questions.id 
    LEFT JOIN tests ON questions.test_id = tests.id
    WHERE members.id = '$userId'";
    $query = mysqli_query($conn, $sql);
    $results = mysqli_fetch_all($query, MYSQLI_ASSOC);
    /*
    echo "<pre>";
    print_r($results);
    echo "</pre>";
    */

    $sql1 = 
    "SELECT tests.id AS t_id, test_name, correct_answers.user_id AS ca_id, correct_answers.test_id AS cat_id, correct_answers.correct_answer AS caca, correct_answers.created_at AS date
    FROM correct_answers 
    LEFT JOIN tests ON correct_answers.test_id = tests.id
    WHERE correct_answers.user_id = '$userId'";
    $query1 = mysqli_query($conn, $sql1);
    $results1 = mysqli_fetch_all($query1, MYSQLI_ASSOC);
    /* 
    echo "<pre>";
    print_r($results1);
    echo "</pre>";
    */

    $sql2 = 
    "SELECT id, userName, userLastName, birthYear
    FROM members
    WHERE members.id = '$userId'";
    $query2 = mysqli_query($conn, $sql2);
    $results2 = mysqli_fetch_all($query2, MYSQLI_ASSOC);
    /*
    echo "<pre>";
    print_r($results2);
    echo "</pre>";
    */
}


?>

<body>

<?php 
require "header.php";
?>

<h1>Odgovori učenika: <?php echo " ". htmlspecialchars($results2[0]['userName'])." ".($results2[0]['userLastName'])." - ".htmlspecialchars($results2[0]['birthYear']); ?></td>
</h1>
<div class="container">
  <div class="row table_bg">

    <div class="col-9">

          <table class="table table-hover preview_tests">
            <thead>
              <tr>
                <th>Test</th>
                <th>Pitanje</th>
                <th>Odgovor 1</th>
                <th>Odgovor 2</th>
                <th>Odgovor 3</th>
                <th>Odgovor 4</th>
                <th>Odgovor 5</th>
                <th>Tačan odgovor</th>
                <th>Učenikov odgovor</th>
              </tr>
            </thead>

            <?php foreach($results AS $column) { ?>
              <tr>
                <td><?php echo htmlspecialchars($column['test_name']); ?></td>
                <td><?php echo htmlspecialchars($column['question']); ?></td>
                <td><?php echo htmlspecialchars($column['answer1']); ?></td>
                <td><?php echo htmlspecialchars($column['answer2']); ?></td>
                <td><?php echo htmlspecialchars($column['answer3']); ?></td>
                <td><?php echo htmlspecialchars($column['answer4']); ?></td>
                <td><?php echo htmlspecialchars($column['answer5']); ?></td>
                <td class="text-center"><?php echo htmlspecialchars($column['qca']); ?></td>
                <?php if($column['qca'] == $column['user_answer']) { ?>
                  <td class="green text-center"><?php echo htmlspecialchars($column['user_answer']); ?></td>
                <?php } else { ?>
                  <td class="red text-center"><?php echo htmlspecialchars($column['user_answer']); ?></td>
                <?php } ?>
              </tr>
            <?php } ?>
          </table>
    </div>

    <div class="col-3">
      <br>
        <table class="table table-hover preview_tests">
          <thead>
            <tr>
              <th>Test</th>
              <th>Rezultat</th>
              <th>Urađen</th>
            </tr>
          </thead>

          <?php foreach($results1 AS $correct) { ?>
            <tr>
              <td><?php echo htmlspecialchars($correct['test_name']); ?></td>
              <td><?php echo htmlspecialchars($correct['caca']); ?></td>
              <td><?php echo htmlspecialchars($correct['date']); ?></td>
            </tr>
          <?php } ?>
        </table>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>