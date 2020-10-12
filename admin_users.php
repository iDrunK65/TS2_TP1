<?php 
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header_admin.php'); 
?>


<div class="container">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-uppercase mb-0">Utilisateurs</h5>
            </div>
            <div class="table-responsive">
                <table class="table no-wrap user-table mb-0">
                  <thead>
                    <tr>
                      <th scope="col" class="border-0 text-uppercase font-medium pl-4">#</th>
                      <th scope="col" class="border-0 text-uppercase font-medium">Identifiant</th>
                      <th scope="col" class="border-0 text-uppercase font-medium">Date d'insription</th>
                      <th scope="col" class="border-0 text-uppercase font-medium">Grade</th>
                      <th scope="col" class="border-0 text-uppercase font-medium">Gérer</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
    $sql = "SELECT count(*) AS total FROM users ORDER BY id DESC";

    $result = mysqli_query($mysqli, $sql);
    $total = mysqli_fetch_object($result);

    $page_temp = $total->total / 10;
    $page_mod = ($total->total % 10) / 10;

    $page = $page_temp - $page_mod;

    if ($page_mod != 0) {
        $page++; 
    }

    if ($page === 0) {
        $page = 1;
    }

    if((!isset($_GET["page"])) || $_GET["page"] <= 1) {
        $limit = "0";
    } else if($_GET["page"] == 2) {
        $limit = 10;
    } else if ($_GET["page"] >= $page) {
        $limit = 10 * $page;
    } else if ($_GET["page"] > 1 && $_GET["page"] < $page) {
        $limit = 10 * $_GET["page"];
    }

    $sql = 'SELECT * FROM users ORDER BY id ASC LIMIT '.$limit.',10';
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
?>

                    <tr>
                      <td class="pl-4"><?= $row['id']; ?></td>
                      <td>
                            <h6 class="mb-0"><?= $row['username']; ?></h6>
                            <span class="text-muted"><?= $row['prenom']; ?> <?= $row['nom']; ?></span>
                      </td>
                      <td>
                            <h6 class="mb-0"><?= dateToFrench($row['date_join'],'l j F Y'); ?></h6>
                            <span class="text-muted"><?= $row['time_join']; ?></span>
                      </td>
                      <td>
                            <h6 class="mb-0"><?php
                            if ($row['rank'] == 1) {
                                echo "Administrateur";
                            } else if ($row['rank'] == 2) {
                                echo "Banni";
                            }else {
                                echo "Membre";
                            }
                            ?></h6>
                      </td>
                      <td>
                            <a href="admin_users_edit.php?id=<?= $row['id']; ?>" class="btn btn-outline-info btn-circle btn-circle ml-2"><i class="fa fa-edit"></i> Editer</a>
                      </td>
                    </tr>
                    <?php }
        $result->close();
    } ?>
    


                    
                  </tbody>
                </table>
            </div>
        </div>
        <br>
        <?php 
                                    
                                    $next_active = "";

                                    if (isset($_GET['page'])) {
                                        $page_nav = $_GET['page'];
                                    } else {
                                        $page_nav = 1;
                                    }
                                    
                                    if ($page_nav <= 1 ) {
                                        $prev_active = "disabled";
                                    }

                                    if($page_nav >= $page) {
                                        $next_active = "disabled";
                                        $page_nav = $page;
                                    }

                                    
                                    ?>

                                    <nav aria-label="Page navigation example">
                                        <ul class="pagination">
                                            <li class="page-item <?php echo $prev_active;?>">
                                            <a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/admin_users.php?page=<?php echo $page_nav -1 ?>" aria-label="Précédent">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                            </li>
                                            <?php if($page_nav >= 3) { ?>
                                                <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/admin_users.php?page=<?php echo $page_nav -2 ?>"><?php echo $page_nav -2 ?></a></li>
                                           <?php } ?>
                                           <?php if($page_nav >= 2) { ?>
                                                <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/admin_users.php?page=<?php echo $page_nav -1 ?>"><?php echo $page_nav -1 ?></a></li>
                                           <?php } ?>
                                            <li class="page-item active"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/admin_users.php?page=<?php echo $page_nav  ?>"><?php echo $page_nav  ?></a></li>
                                            <?php if($page_nav <= $page-1) { ?>
                                            <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/admin_users.php?page=<?php echo $page_nav +1 ?>"><?php echo $page_nav +1 ?></a></li>
                                            <?php } ?>
                                            <?php if($page_nav <= $page-2) { ?>
                                            <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/admin_users.php?page=<?php echo $page_nav +2 ?>"><?php echo $page_nav +2 ?></a></li>
                                            <?php } ?>
                                            <li class="page-item <?php echo $next_active;?>">
                                            <a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/admin_users.php?page=<?php echo $page_nav +1 ?>" aria-label="Suivant">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                            </li>
                                        </ul>
                                    </nav>
    </div>
    
</div>
</div>

</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>