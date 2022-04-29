<!DOCTYPE html>
<html lang="sr">

<?php
session_start();
$page_title = "Unos testa";
require "connection.php";
require "head.php";


if (array_key_exists('id', $_SESSION) && isset($_SESSION['id'])) {

/* BUTTON 1 */
    if(isset($_POST['btn_edit_test'])) {

      $edit_test = mysqli_real_escape_string($conn, $_POST['edit_test']);
      $sqlEdit = "SELECT * FROM tests WHERE test_name = '$edit_test'";
      $queryEdit = mysqli_query($conn, $sqlEdit);
      $result = mysqli_fetch_all($queryEdit, MYSQLI_ASSOC);
      $error = NULL;
      $error1 = NULL;
      $error2 = NULL;

      if (empty($edit_test)) {
        $error = "Morate uneti novo ime testa";
      } elseif (count($result) > 0) {
        $error1 = "Unešeni test već postoji";
      } else {
        $sql = "INSERT INTO tests (test_name) VALUES ('$edit_test')";
        if(mysqli_query($conn, $sql)) {
          header("Location: edit_test.php");
        }
      }
    }
}





$sqlSelect = "SELECT * FROM tests ORDER BY test_name ASC";
$querySelect = mysqli_query($conn, $sqlSelect);
$testList = mysqli_fetch_all($querySelect, MYSQLI_ASSOC);
//print_r($testList);

$sqlId = "SELECT * FROM tests ORDER BY id DESC LIMIT 1";
$queryId = mysqli_query($conn, $sqlId);
$testId = mysqli_fetch_all($queryId, MYSQLI_ASSOC);
//print_r($testId);


?>

<body>

<?php 
require "header.php";
?>

<h1>Unos testa</h1>
<div class="container">
  <div class="row table_bg">
    <div class="col-1"></div>
    
    <div class="col-9">

      <form action="edit_test.php" method="post" class="text-light">
      <p style="color: red; font-weight: 700; font-size: 16px; margin-left: 70px;"> <?php echo $error ?? ''; ?> </p>
      <p style="color: red; font-weight: 700; font-size: 16px; margin-left: 70px;"> <?php echo $error1 ?? ''; ?> </p>
        <div class="mb-3">
          <label class="form-label">Ukoliko vam je potrebno novo ime testa, unesite ime i potvrdite unos:</label>
          <input type="text" name="edit_test" placeholder="Unesite novo ime testa" class="form-control" aria-describedby="emailHelp">
        </div>

        <button type="submit" name="btn_edit_test" class="btn btn-danger" value="<?php echo $testId[0]['id']; ?>">Potvrdite unos novog testa</button>
      </form>

        <br><br>

      <form action="edit_questions.php" method="get" class="text-light">
      <p style="color: red; font-weight: 700; font-size: 16px; margin-left: 70px;"> <?php echo $error2 ?? ''; ?> </p>
        <div class="mb-3">
          <label class="form-label">Ukoliko želite da dodate nova pitanja u postojeći test, izaberite test i potvrdite unos:</label>
          <br>
          <select name="select_test" class="form-select">
            <?php foreach ($testList as $test) { ?>
              <option value="<?php echo $test['id'] ?>"><?php echo $test['test_name'] ?></option>
            <?php } ?>
          </select>
        </div>

        <button type="submit" name="btn_select_test" value=true class="btn btn-danger">Dalje...</button>

      </form>
    </div>

<!--     <div class="col-2"></div> -->  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>