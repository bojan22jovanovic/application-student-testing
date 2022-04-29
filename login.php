<!DOCTYPE html>
<html lang="sr">

<?php
$page_title = "Prijava";
session_start();
require "head.php";
require "connection.php";

if(isset($_POST['signup'])) {
  $email = mysqli_real_escape_string($conn, $_POST['email']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $error_mail = NULL;
  $error_pass = NULL;
  $correct = NULL;

  $sql = "SELECT id, email, password FROM members WHERE email = '$email'";
  $query = mysqli_query($conn, $sql);
  $user = mysqli_fetch_all($query, MYSQLI_ASSOC);
  //print_r($user);
    if (count($user) < 1) {
      $error_mail = "Pogrešna email adresa";
    } elseif (!password_verify($password, $user[0]['password'])) {
      $error_pass = "Pogrešna šifra";
    } elseif (password_verify($password, $user[0]['password'])) {
      $_SESSION['id'] = $user[0]['id'];
      $correct = "Uspešno ste se prijavili";
      //print_r($_SESSION['id']);
    }
}
?>

<body>

<?php 
require "header.php";
?>

<h1>Prijava</h1>
<div class="container">
  <div class="row table_bg">

    <div class="col-2"></div>

    <div class="col-8">
      <form action="login.php" method="post">
        <span style="color: red; font-weight: 700; font-size: 16px; margin-left: 100px;"> <?php echo $error_mail ?? ''; ?> </span>
        <span style="color: green; font-weight: 700; font-size: 15px;"><?php echo $correct ?? ''; ?> </span>
        <div class="mb-3">
          <label class="form-label">Email adresa</label>
          <input type="email" name="email" placeholder="Unesite Vaš email" class="form-control" aria-describedby="emailHelp">
        </div>
        <span style="color: red; font-weight: 700; font-size: 16px; margin-left: 100px;"> <?php echo $error_pass ?? ''; ?> </span>
        <div class="mb-3">
          <label class="form-label">Šifra</label>
          <input type="password" name="password" placeholder="Unesite Vašu šifru" class="form-control">
        </div>
        <br>
        <button type="submit" name="signup" class="btn btn-danger">Prijavi se</button>
      </form>
    </div>

    <!-- <div class="col-2"></div> -->  
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>