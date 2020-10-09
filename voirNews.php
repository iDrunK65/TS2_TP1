<?php require_once('./assets/inc/db.php'); 
      require_once('./assets/inc/functions.php'); 

    if (!isset($_GET["id"])) {
        header("Location: news.php");
        exit;
    } else if (empty($_GET['id'])) {
        header("Location: news.php");
        exit;
    }
    $id = $_GET["id"];


$userid = 1;
if (isset($_POST)) {

    $sql = "SELECT * FROM news WHERE id = ". $id;
    $result = mysqli_query($mysqli, $sql);
            
    while ($row = $result->fetch_assoc()) {
        if (isset($_POST['like'])) {

        } else if (isset($_POST['dislike'])) {
        
        }
    }

}





require('./assets/inc/header.php'); 




?>


        <?php

            $sql = "SELECT * FROM news WHERE id = ". $id;
            $result = mysqli_query($mysqli, $sql);
                        
            if ($result) {
                $count = 0;
                while ($row = $result->fetch_assoc()) {
                    $count++;

                    if ($row['deleted'] == 1) {
                        $count = 0;
                    }
        ?>
                    <h3><?php echo $row['titre']; ?></h3>
                    <br><br>

                    <div class="col-lg-8 offset-md-2">
                        <div class="jumbotron">
                            <p><?php echo $row['contenu']; ?></p>
                        </div>

                        <?php 
                        $sql = 'SELECT * FROM users WHERE id = ' . $row['auteurid'];
                            $users = mysqli_query($mysqli, $sql);



                            if (mysqli_num_rows($users) != 0) {

                                while ($user = $users->fetch_assoc()) {

                                    if (!empty($user['prenom']) && !empty($user['nom'])) { ?>
                                        <span class="text-muted"><i class="fas fa-user-tag"></i> Auteur : <?= $user['prenom']; ?> <?= $user['nom']; ?></span>
                                    <?php } else {?>
                                        <span class="text-muted"><i class="fas fa-user-tag"></i> Auteur : <?= $user['username']; ?></span>
                                    <?php }

                                }
                            } else { ?>
                                <span class="text-muted"><i class="fas fa-user-tag"></i> Auteur : Inconnu</span>
                            <?php }
                        ?>

                        <BR><span class="text-muted"><i class="fas fa-feather-alt"></i> Crée le : <?= dateToFrench($row['temps_date'],'l j F Y'); ?> à <?= $row['temps_heure']; ?></span>

                        <?php if (!is_null($row['temps_edit'])) { ?>
                            <br><span class="text-muted"><i class="far fa-edit"></i> Dernière edition : il y a <?= TimeToNow($row["temps_edit"]); ?></span>
                       <?php } 
                       
                        if (isset($_SESSION['auth'])) {

                            $sql = 'SELECT * FROM users WHERE id = ' .$_SESSION['auth'];
                            $user = mysqli_query($mysqli, $sql);

                            if (mysqli_num_rows($user) != 0) {


                                while ($rw = $user->fetch_assoc()) {
                                    if (($row['auteurid'] == $rw['id']) || ($rw['rank'] == 1) ) { ?>
                                        <br> <br><a href="news_edit.php?id=<?= $row['id']; ?>" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i> Modifier</a>
                                        
                                    <?php } if ($rw['rank'] == 1) { ?>
                                        <button type="button" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#confirmation">
                                            <i class="fas fa-trash-alt"></i> Supprimer
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="confirmation" tabindex="-1" aria-labelledby="confirmationLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmationLabel">Confirmation</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    ...
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="far fa-window-close"></i> Fermer</button>
                                                    <button type="button" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Confirmer la suppression</button>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    <?php }
                                }
                            }
                        } ?>



<br><br>
                        <div class="vote_bar">
                            <div class="vote_progress" style="width:<?= ( $row['like_count'] + $row['dislike_count'] ) == 0 ? 100 : (100 * ($row['like_count'] / ( $row['like_count'] + $row['dislike_count'] ))) ?>%"></div>
                        </div>
                        <div class="vote_btns">

                            <form method="POST" action="">
                                <button type="submit" name="like" id="like" class="vote_btn vote_like"><i class="fas fa-thumbs-up"></i> <?php echo $row['like_count']; ?></button>
                                <button type="submit" name="dislike" id="dislike"class="vote_btn vote_dislike"><i class="fas fa-thumbs-down"></i> <?php echo $row['dislike_count']; ?></button>
                            </form>
                        
                        </div>

                        

                    </div>

                    </div>



                <?php }
                    if ($count == 0) { ?>
                    
                    <div class="col-md-4 offset-md-4">
                        <div class="card">
                            <div class="card-header bg-info">
                                <strong class="card-title text-light"><i class="fas fa-exclamation-triangle"></i> Article Introuvable</strong>
                            </div>
                            <div class="card-body text-white bg-info">
                                <p class="card-text text-light">L'article que vous rechercher est introuvable.</p>
                            </div>
                            <div class="card-footer text-center bg-info">
                                    <a href="news.php"><button type="button" class="btn btn-primary"><i class="fas fa-reply"></i> Revenir à la liste des News</button></a>
                            </div>
                        </div>
                    </div>



                <?php }

            }
        ?>

</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>