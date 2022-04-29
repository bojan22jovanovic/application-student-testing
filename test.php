<!DOCTYPE html>
<html lang="sr">

<?php
session_start();
$page_title = "test";
require "connection.php";
require "head.php";


if (array_key_exists('id', $_SESSION) && isset($_SESSION['id'])) {

    $sessionId = $_SESSION['id'];
    $sql = "SELECT questions.id AS q_id, question, answer1, answer2, answer3, answer4, answer5, correct_answer, test_id, tests.id AS testId, test_name FROM questions LEFT JOIN tests ON questions.test_id = tests.id WHERE tests.display_test = 1";
    $query = mysqli_query($conn, $sql);
    $results = mysqli_fetch_all($query, MYSQLI_ASSOC);

/* 
echo '<pre>';
print_r($results);
echo '</pre>';
 */

    $userTest = $results[0]['testId'];
    
    $sql2 = "SELECT * FROM members JOIN user_tests ON members.id = user_tests.user_id JOIN tests ON user_tests.test_id = tests.id WHERE members.id = '$sessionId' AND user_tests.test_id = '$userTest'";
    $query2 = mysqli_query($conn, $sql2);
    $results2 = mysqli_fetch_all($query2, MYSQLI_ASSOC);

    $message_error = NULL;
    $message_correct = NULL;
    $worning = NULL;
    $message_yes = (array) NULL;
    $message_no = (array) NULL;

    if (isset($_POST['send_test_answers'])) {

        $empty = 0;
        for ($i=0; $i < count($results); $i++) {
            
            if (empty($_POST['question'.$i])) {
              $message_error = "Morate da popunite sva polja!";
              $empty++;
            }
        }

        if ($empty == 0 && count($results2) == 0) {

            $correct = 0;
            for ($i=0; $i < count($results); $i++) {

              $test_id = $results[$i]['test_id'];
              $question_id = $results[$i]['q_id'];
              $user_answers = $_POST['question'.$i];

                if ($user_answers == $results[$i]['correct_answer']) {
                    $message_yes[$i] = 'Tačan odgovor';
                    $correct++;
                } elseif ($user_answers != $results[$i]['correct_answer']){
                    $message_no[$i] = 'Odgovor nije tačan';
                }
              $sql_insert = "INSERT INTO user_tests (user_id, test_id, question_id, user_answer) 
                             VALUES ('$_SESSION[id]', $test_id, '$question_id', '$user_answers')";
              mysqli_query($conn, $sql_insert);
            }
            $correct_answers = $correct . "/" . count($results);
            $message_correct  = "Test je završen. Hvala." .  "<br>" . "Broj tačnih odgovora je: " . $correct_answers;
            $sql_correct_answer = "INSERT INTO correct_answers (user_id, test_id, correct_answer) 
                                   VALUES ('$_SESSION[id]', $test_id, '$correct_answers')";
            mysqli_query($conn, $sql_correct_answer);
        } elseif ($empty == 0 && count($results2) > 0) {
          $message_worning = "Ne možete dva puta da radite test";
        }
    }
}



?>

<body>

<?php 
require "header.php";
?>

<h1>Test: <?php echo htmlspecialchars($results[0]['test_name']); ?></h1>
<div class="container">
  <div class="row table_bg">

    <div class="col-1"></div>

    <div class="col-6">
      <form action="test.php" method="post">
        <?php
        /* Presek */
          for($i=0; $i < count($results); $i++) { ?>
              <h5> <?php echo $i+1 . ". " . htmlspecialchars($results[$i]['question']); ?> </h5>

              <input type="radio" name="question<?php echo $i; ?>" value="1" <?php if(isset($_POST['question'.$i]) && $_POST['question'.$i] =='1' ){echo "checked";}?> >
              <label><?php echo htmlspecialchars($results[$i]['answer1']); ?></label><br>
              <input type="radio" name="question<?php echo $i; ?>" value="2" <?php if(isset($_POST['question'.$i]) && $_POST['question'.$i] =='2' ){echo "checked";}?> >
              <label><?php echo htmlspecialchars($results[$i]['answer2']); ?></label><br>
              <input type="radio" name="question<?php echo $i; ?>" value="3" <?php if(isset($_POST['question'.$i]) && $_POST['question'.$i] =='3' ){echo "checked";}?> >
              <label><?php echo htmlspecialchars($results[$i]['answer3']); ?></label><br>
              <input type="radio" name="question<?php echo $i; ?>" value="4" <?php if(isset($_POST['question'.$i]) && $_POST['question'.$i] =='4' ){echo "checked";}?> >
              <label><?php echo htmlspecialchars($results[$i]['answer4']); ?></label><br>
              <input type="radio" name="question<?php echo $i; ?>" value="5" <?php if(isset($_POST['question'.$i]) && $_POST['question'.$i] =='5' ){echo "checked";}?> >
              <label><?php echo htmlspecialchars($results[$i]['answer5']); ?></label><br><br>

              <p class="message_yes"><?php echo $message_yes[$i]?? ''; ?></p>
              <p class="message_no"><?php echo $message_no[$i]?? ''; ?></p>
              <p class="message_no"><?php echo $message_error2[$i]?? ''; ?></p>

        <?php } ?>

        <input type="submit" name="send_test_answers" value="Pošalji izabrano" class="btn btn-danger">

      </form>

    </div> <!-- END col -->

    <div class="col-5">
      <p class="message_error"><?php echo $message_error?? ''; ?></p>
      <p class="message_correct"><?php echo $message_correct?? ''; ?></p>
      <p class="message_error"><?php echo $message_worning?? ''; ?></p>
    </div>

  </div> <!-- END div row -->
</div> <!-- END div container -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>