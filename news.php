<?php 
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header.php'); 
?>


    <div class="row row-cols-1 row-cols-md-3">

<?php 
    $sql = "SELECT count(*) AS total FROM news ORDER BY id DESC LIMIT 3";

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
        $limit = 12;
    } else if ($_GET["page"] >= $page) {
        $limit = 12 * $page;
    } else if ($_GET["page"] > 1 && $_GET["page"] < $page) {
        $limit = 12 * $_GET["page"];
    }

    $sql = 'SELECT * FROM news ORDER BY id DESC LIMIT '.$limit.',12';
    $result = mysqli_query($mysqli, $sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $count++;
?>
            <div class="col mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["titre"]; ?></h5>
                        <p class="card-text"><?php 
                        if (strlen( $row["contenu"]) > 185) {
                            $str = substr( $row["contenu"], 0, 175) . ' ...';
                        } else {
                            $str = $row["contenu"];
                        }

                        echo $str ?></p>
                        <a href="voirNews.php?id=<?php echo $row["id"]; ?>" class="btn btn-primary">Lire la suite</a>
                    </div>
                    <div class="card-footer">
                        <?php 
                            $sql = 'SELECT * FROM users WHERE id = ' . $row['auteurid'];
                                $users = mysqli_query($mysqli, $sql);



                                if (mysqli_num_rows($users) != 0) {

                                    while ($user = $users->fetch_assoc()) {

                                        if (!empty($user['prenom']) && !empty($user['nom'])) { ?>
                                            <small class="text-muted"><i class="fas fa-user-tag"></i> Auteur : <?= $user['prenom']; ?> <?= $user['nom']; ?></small><br>
                                        <?php } else {?>
                                            <small class="text-muted"><i class="fas fa-user-tag"></i> Auteur : <?= $user['username']; ?></small><br>
                                        <?php }

                                    }
                                } else { ?>
                                    <small class="text-muted"><i class="fas fa-user-tag"></i> Auteur : Inconnu</small><br>
                                <?php }
                            ?>
                        <small class="text-muted"><i class="fas fa-feather-alt"></i> Crée le : <?= dateToFrench($row['temps_date'],'l j F Y'); ?> à <?= $row['temps_heure']; ?></small>
                        <?php if (!is_null($row['temps_edit'])) { ?>
                            <br><small class="text-muted"><i class="far fa-edit"></i> Dernière edition : il y a <?= TimeToNow($row["temps_edit"]); ?></small>
                        <?php } else {?>
                            <br><small class="text-muted"><i class="far fa-edit"></i> Dernière edition : Jamais</small>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php }
        if ($count == 0) { ?>
            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">Aucun Article</h4>
                <p>Il y a actullement aucun article sur le site.</p>
                <hr>
                <p class="mb-0">Pour créer un article, cliquez <b>ICI</b>.</p>
            </div>

        <?php }
        $result->close();
    } ?>

</div>

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
                                            <a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/news.php?page=<?php echo $page_nav -1 ?>" aria-label="Précédent">
                                                <span aria-hidden="true">&laquo;</span>
                                            </a>
                                            </li>
                                            <?php if($page_nav >= 3) { ?>
                                                <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/news.php?page=<?php echo $page_nav -2 ?>"><?php echo $page_nav -2 ?></a></li>
                                           <?php } ?>
                                           <?php if($page_nav >= 2) { ?>
                                                <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/news.php?page=<?php echo $page_nav -1 ?>"><?php echo $page_nav -1 ?></a></li>
                                           <?php } ?>
                                            <li class="page-item active"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/news.php?page=<?php echo $page_nav  ?>"><?php echo $page_nav  ?></a></li>
                                            <?php if($page_nav <= $page-1) { ?>
                                            <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/news.php?page=<?php echo $page_nav +1 ?>"><?php echo $page_nav +1 ?></a></li>
                                            <?php } ?>
                                            <?php if($page_nav <= $page-2) { ?>
                                            <li class="page-item"><a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/news.php?page=<?php echo $page_nav +2 ?>"><?php echo $page_nav +2 ?></a></li>
                                            <?php } ?>
                                            <li class="page-item <?php echo $next_active;?>">
                                            <a class="page-link" href="http://idrunk.fr/nicolas/TS2_TP1/news.php?page=<?php echo $page_nav +1 ?>" aria-label="Suivant">
                                                <span aria-hidden="true">&raquo;</span>
                                            </a>
                                            </li>
                                        </ul>
                                    </nav>



    


</div>


</div>


















    
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>