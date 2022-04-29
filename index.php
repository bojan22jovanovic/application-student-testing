<!DOCTYPE html>
<html lang="sr">

<?php
$page_title = "Registracija";
require "head.php";
require "connection.php";

if (isset($_POST['register'])) {
    $userName = mysqli_real_escape_string($conn, $_POST['userName']);
    $userLastName = mysqli_real_escape_string($conn, $_POST['userLastName']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $r_password = mysqli_real_escape_string($conn, $_POST['r_password']);
    $birthYear = mysqli_real_escape_string($conn, $_POST['birthYear']);
    $permit = mysqli_real_escape_string($conn, $_POST['permit']);

    $error = NULL;
    $correct = NULL;
    $error_mail = NULL;
    $error_pass = NULL;

    $sql_mail = "SELECT email FROM members WHERE email = '$email'";
    $query_mail = mysqli_query($conn, $sql_mail);
    $user_mail = mysqli_fetch_all($query_mail, MYSQLI_ASSOC);

        if (!$userName || !$userLastName || !$email || !$password || !$birthYear) {
          $error = "Sva polja moraju biti popunjena";
        } elseif (count($user_mail) > 0) {
          $error_mail = "E-mail adresa već postoji u bazi";
        } elseif ($password != $r_password) {
          $error_pass = "Šifre se ne poklapaju";
        } else {
          $password = password_hash($password, PASSWORD_DEFAULT);
          $sql = "INSERT INTO members (userName, userLastName, email, password, birthYear, role_id) VALUES ('$userName', '$userLastName', '$email', '$password', '$birthYear', '$permit')";
          
          if (mysqli_query($conn, $sql)) {
            $correct = "Uspešno ste se registovali. Sada se možete prijaviti.";
          }
        }
}

$sql_permit = "SELECT id, permitName FROM permissions";
$query_permit = mysqli_query($conn, $sql_permit);
$results_permit = mysqli_fetch_all($query_permit, MYSQLI_ASSOC);

?>

<body>

<?php 
require "header.php";
?>

<h1>Registracija</h1>
<div class="container">
  <div class="row table_bg">
    <div class="col-2"></div>

    <div class="col-8">
      <form action="index.php" method="post" class="text-light">
        <span style="color: red; font-weight: 700; font-size: 16px; margin-left: 70px;"> <?php echo $error ?? ''; ?> </span>
        <span style="color: red; font-weight: 700; font-size: 16px; margin-left: 40px;"><?php echo $error_pass ?? ''; ?></span>
        <span style="color: red; font-weight: 700; font-size: 16px; margin-left: 40px;"> <?php echo $error_mail ?? ''; ?> </span>
        <span style="color: green; font-weight: 700; font-size: 15px;"><?php echo $correct ?? ''; ?></span>
        <div class="mb-3">
          <label class="form-label">Ime</label>
          <input type="text" name="userName" placeholder="Unesite Vaše ime" class="form-control" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label class="form-label">Prezime</label>
          <input type="text" name="userLastName" placeholder="Unesite Vaše prezime" class="form-control" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label class="form-label">Email adresa</label>
          <input type="email" name="email" placeholder="Unesite Vaš email" class="form-control" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <div>
          <label class="form-label">Šifra</label>
          </div>
          <input style="width: 300px;" type="password" name="password" placeholder="Unesite Vašu šifru" class="form-control float-start">
          <input style="width: 300px;" type="password" name="r_password" placeholder="Ponovite Vašu šifru" class="form-control float-end">
        </div><br><br>
        <div class="mb-3">
          <label class="form-label">Broj đačke knjižice</label>
          <input type="number" name="birthYear" placeholder="Unesite broj đačke knjižice (primer: 0054)" max="2022" min="1901" class="form-control" aria-describedby="emailHelp">
        </div>


        <div class="mb-3" style="visibility: hidden;">
          <label class="form-label">Permits</label>
          <select name="permit" class="form-select" aria-label="Default select example">
            <?php foreach ($results_permit as $permit) { ?>
            <option value="<?php echo htmlspecialchars($permit['id']); ?>" > <?php echo htmlspecialchars($permit['permitName']); ?></option>
            <?php } ?>
          </select>
        </div>

        <button type="submit" name="register" class="btn btn-danger">Registruj se</button>

      </form>
    </div>

    <!-- <div class="col-2"></div> -->
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>