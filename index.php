<?php 
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header.php'); 

$sql = "SELECT * FROM news WHERE deleted = 0 ORDER BY id DESC LIMIT 3";
$result = mysqli_query($mysqli, $sql);
                        
if ($result) {
    $count = 0;
    while ($row = $result->fetch_assoc()) {
        $count++;
?>

        <div class="col-sm">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row["titre"]; ?></h5>
                    <p class="card-text"><?php 
                        if (strlen( $row["contenu"]) > 255) {
                            $str = substr( $row["contenu"], 0, 245) . ' ...';
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

        <br>


<?php
                }


                if ($count == 0) { ?>
            <div class="alert alert-primary" role="alert">
                <h4 class="alert-heading">Aucun Articles</h4>
                <p>Il y a actullement aucun article sur le site.</p>
                <hr>
                <p class="mb-0">Pour créer un article, cliquez <b>ICI</b>.</p>
            </div>

              <?php  

                }
                $result->close();
            } ?>


    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>