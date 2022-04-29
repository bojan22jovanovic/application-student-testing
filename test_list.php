<!DOCTYPE html>
<html lang="sr">

<?php
session_start();
$page_title = "Odabir testa";
require "connection.php";
require "head.php";


if (array_key_exists('id', $_SESSION) && isset($_SESSION['id'])) {

    $azbuka = ['A', 'B', 'C', 'Ć', 'Č', 'D', 'Đ', 'Dž', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'Lj', 'M', 'N', 'Nj', 'O', 'P', 'R', 'S', 'Š', 'T', 'U', 'V', 'Z', 'Ž'];
    $results = [];
    for ($i=0; $i < 30; $i++) {
      $letter = $azbuka[$i];
      $sql[$i] = "SELECT id, test_name FROM tests WHERE test_name LIKE '$letter%'";
      $query[$i] = mysqli_query($conn, $sql[$i]);
      $results[$i] = mysqli_fetch_all($query[$i], MYSQLI_ASSOC);
    }

/* 
echo '<pre>';
print_r($results);
echo '</pre>';

 */

  if (isset($_POST['send_checked'])) {

        $display_question = $_POST['display_question'];
        $questionId = $_POST['question_id'];
        //print_r($display_question);
        //echo "<br>";
        //print_r($questionId);

        $correct = NULL;

        foreach($display_question as $index => $value) {
          $sqlUpdate = "UPDATE questions SET display_question = '$display_question[$index]' WHERE id = $questionId[$index]";
          if (mysqli_query($conn, $sqlUpdate)) {
              header("Location:test.php");
              //echo "Index: ". $index ." vrednost: " . $value . " za ID: " . $questionId[$index] .'<br/>';
          }
        }
  }
}

?>

<body>

<?php 
require "header.php";
?>

<h1>Odabir testa</h1>
<div class="container">
  <div class="row table_bg">

      <?php for ($i=0; $i < 30; $i++) {  ?>
            <?php if (count($results[$i]) > 0) { ?>
              <div class="col-3 test_list">
                <h5><?php echo $azbuka[$i] ?> </h5>

                    <?php for ($j=0; $j < count($results[$i]); $j++) { ?>
                      <a href="preview_test.php?id=<?php echo htmlspecialchars($results[$i][$j]['id']); ?>"><?php echo $results[$i][$j]['test_name']?> </a>
                      <a href="delete_test.php?id=<?php echo htmlspecialchars($results[$i][$j]['id']); ?>" class="btn btn-sm m-1">Obrisati</a>
                      <br>
                    <?php } ?>
              </div>
      <?php } } ?>
  </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>