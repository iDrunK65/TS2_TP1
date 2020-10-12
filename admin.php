<?php 
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header_admin.php'); 
?>

<div class="row row-cols-1 row-cols-md-2">
  <div class="col mb-4">
    <div class="card">
      <div class="card-body">
        <?php
        $sql = "SELECT * FROM news";
        $result = mysqli_query($mysqli, $sql);
                                
        if ($result) {
            $count = 0;
            while ($row = $result->fetch_assoc()) {
                $count++;
            }
        }
            $result->close();
        ?>

        <h5 class="card-title"><i class="far fa-newspaper"></i> <?= $count; ?> Articles</h5>
        <p class="card-text"><a href="voirNews.php?id=<?= $count; ?>" class="btn btn-primary"><i class="fas fa-reply"></i> Lire le dernier articles</a></p>
      </div>
    </div>
  </div>
  <div class="col mb-4">
    <div class="card">
      <div class="card-body">

        <?php
            $sql = "SELECT * FROM users";
            $result = mysqli_query($mysqli, $sql);
                                    
            if ($result) {
                $count1 = 0;
                while ($row = $result->fetch_assoc()) {
                    $count1++;
                }
            }
            $result->close();
        ?>
        <h5 class="card-title"><i class="fas fa-users"></i> <?= $count1; ?> Membres</h5>
        <p class="card-text"><a href="admin_users.php" class="btn btn-primary"><i class="fas fa-reply"></i> Liste des membres</a></p>
      </div>
    </div>
  </div>
</div>







</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>