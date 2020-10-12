<?php require_once('./assets/inc/db.php'); 
      require_once('./assets/inc/functions.php'); 
      require('./assets/inc/header.php'); 

    if (!isset($_GET["id"])) {
        header("Location: news.php");
        exit;
    } else if (empty($_GET['id'])) {
        header("Location: news.php");
        exit;
    }
    $id = $_GET["id"];


    if (isset($_POST['valider'])) {
        
        $sql = 'UPDATE news SET auteurid = %d, titre="%s", contenu="%s", temps_edit=now() WHERE id = %d';
        $newsql = sprintf($sql, $_POST['auteur'], $_POST['titre'], $_POST['contenu'], $id);

        if (!mysqli_query($mysqli, $newsql)) {
            info_error(mysqli_error($mysqli));
        } else {
            header("Location: admin_news.php");
        }
        //mysqli_query($mysqli, $newsql);
        //header('Location: admin_news.php');

    }

    if (isset($_POST['del'])) {

        $sql = "UPDATE news SET deleted = 1 WHERE id = %d";
        $new_sql = sprintf($sql, $id);
    
        if (!mysqli_query($mysqli, $new_sql)) {
            info_error(mysqli_error($base));
        } else {
            header("Location: admin_news.php");
        }
    }

    if (isset($_POST['del_inf'])) {

        $sql = "DELETE FROM news WHERE id = %d";
        $new_sql = sprintf($sql, $id);
    
        if (!mysqli_query($mysqli, $new_sql)) {
            info_error(mysqli_error($base));
        } else {
            header("Location: admin_news.php");
        }
    }

    if (isset($_POST['restaurer'])) {

        $sql = "UPDATE news SET deleted = 0 WHERE id = %d";
        $new_sql = sprintf($sql, $id);
    
        if (!mysqli_query($mysqli, $new_sql)) {
            info_error(mysqli_error($base));
        } else {
            header("Location: admin_news.php");
        }
    }

    

    $sql = "SELECT * FROM news WHERE id = ". $id;
    $result = mysqli_query($mysqli, $sql);
                
    if ($result) {
        $count = 0;
        while ($row = $result->fetch_assoc()) {

            $sql = 'SELECT * FROM users WHERE id = ' .$_SESSION['auth'];
            $user = mysqli_query($mysqli, $sql);

            if (mysqli_num_rows($user) != 0) {
                while ($rw = $user->fetch_assoc()) {
                    if (($_SESSION['auth'] != $row['auteurid'] ) && $rw['rank'] != 1 ) {
                        header("Location: ./error/403.php");
                        exit;
                    }
                }
            }

            
            $count++;?>

            <form action="" method="post">

                <div class="form-group">
                    <label for="titre">Titre</label>
                    <input type="text" class="form-control" name="titre" id="titre" value="<?= $row['titre']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="contenu">Contenu</label>
                    <textarea class="form-control" name="contenu" id="contenu" rows="20" required><?= $row['contenu']; ?></textarea>
                </div>
                <div class="form-group">
    
      
    
            <?php 
            $sql = "SELECT * FROM users";
            $users = mysqli_query($mysqli, $sql);

            
            if (!$users) {
                info_error(mysqli_error($mysqli));
            } else { ?>
<label for="auteur">Auteur</label>
    <select class="form-control" name="auteur" id="auteur">
            <?php
                while ($user = $users->fetch_assoc()) {?>
                <option <?= ($row['auteurid'] == $user['id']) ? "selected" : "" ?> value="<?= $user['id']; ?>"> <?= ($user['rank'] == 2) ? "[BANNI]" : ""?> <?= $user['username']; ?> <?= ((!empty($user['prenom'])) && (!empty($user['nom']))) ? " | " . $user['prenom'] . " " . $user['nom'] : "" ?></option>
                <?php }?>
                </select>
  </div>
            <?php }?>



                <a href="admin_news.php" class="btn btn-outline-primary"><i class="fas fa-angle-double-left"></i> Retour</a> <button type="submit" name="valider" id="valider" class="btn btn-outline-success"><i class="fas fa-check"></i> Valier</button>


            </form>

<br>
            
            
            <?php if ($row['deleted'] == 1) { ?>
                <form action="" method="post"> 
                    <button type="submit" name="restaurer" id="restaurer" class="btn btn-success"><i class="fas fa-check"></i> Restaurer</button> 
                </form><br>
           <?php } else {?>
                <form action="" method="post"> 
                    <button type="submit" name="del" id="del" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Supprimer</button> 
                </form><br>
           <?php } ?>

                <form action="" method="post"> 
                    <button type="submit" name="del_inf" id="del_inf" class="btn btn-danger"><i class="fas fa-trash-alt"></i> Supprimer défénitivement</button> 
                </form>
            
            


<br><br>


        <?php } if ($count == 0) { ?>
            
            <div class="col-md-4 offset-md-4">
                <div class="card">
                    <div class="card-header bg-info">
                        <strong class="card-title text-light"><i class="fas fa-exclamation-triangle"></i> Article Introuvable</strong>
                    </div>
                    <div class="card-body text-white bg-info">
                        <p class="card-text text-light">L'article que vous rechercher est introuvable.</p>
                    </div>
                    <div class="card-footer text-center bg-info">
                            <a href="admin_news.php"><button type="button" class="btn btn-primary"><i class="fas fa-reply"></i> Revenir à la liste des News</button></a>
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