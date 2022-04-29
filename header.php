<?php

if (!isset($_SESSION)) session_start();

if(array_key_exists('id', $_SESSION) && isset($_SESSION['id'])) {
  $userId = $_SESSION['id'];
  //print_r($userId);
  $sql = "SELECT userName, userLastName FROM members WHERE id = $userId";
  $query = mysqli_query($conn, $sql);
  $user = mysqli_fetch_all($query, MYSQLI_ASSOC); 
  //print_r($user);
  ?>
  
  <header>
    <div class="container">
      <div class="row">
        
        <div class="col-4">
          <p>Dobro došli: <?php echo htmlspecialchars($user[0]['userName']) . " " . htmlspecialchars($user[0]['userLastName']); ?></p>
        </div>
        
        <div class="col-6">
          <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon bg-danger">=</span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-lg-0">
                  <li class="nav-item"><a href="edit_test.php" class="btn btn-danger m-3">Unos testa</a></li>
                  <li class="nav-item"><a href="test_list.php" class="btn btn-danger m-3">Lista testova</a></li>
                  <li class="nav-item"><a href="users.php" class="btn btn-danger m-3">Učenici</a></li>
                </ul>
              </div>
            </div>
          </nav>
        </div>

        <div class="col-1">
          <a href="test.php" class="btn btn-danger m-3">Test</a>
        </div>
        <div class="col-1">
          <a href="logout.php" class="btn btn-danger m-3">Odjava</a>
        </div>
        
      </div>
    </div>
  </header>

<?php } else { ?>

  <header>
      <div class="container">
        <div class="row">
          
        <div class="col-10"></div>
        <div class="col-2">
          <?php 
            if ($page_title == "Registracija") { ?>
              <a href="login.php" class="btn btn-danger m-3">Prijava</a>
            <?php } elseif ($page_title == "Prijava") { ?>
              <a href="index.php" class="btn btn-danger m-3">Registracija</a>
            <?php } ?>
        </div>

        </div>
      </div>
  </header>

<?php } ?>