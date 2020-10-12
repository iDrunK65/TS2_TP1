<?php 
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header_admin.php'); 

if (!isset($_GET["id"])) {
    header("Location: admin_users.php");
    exit;
} else if (empty($_GET['id'])) {
    header("Location: admin_users.php");
    exit;
}
$id = $_GET["id"];

if (isset($_POST['valider'])) {

    $prenom = "'".$_POST['prenom']."'";
    $nom = "'". $_POST['nom']. "'";

    if (empty($_POST['prenom'])) {
        $prenom = 'NULL';
    }
    if (empty($_POST['nom'])) {
        $nom = 'NULL';
    }



    $sql = "UPDATE users SET username ='%s', prenom = %s, nom = %s, rank = '%d' WHERE id = %d";
    $newsql = sprintf($sql, $_POST['username'], $prenom, $nom, $_POST['rank'], $id);

    if (!mysqli_query($mysqli, $newsql)) {
        echo "Error updating record: " . mysqli_error($conn);
    }
    header('Location: admin_users.php');
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


$sql = "SELECT * FROM users WHERE id = ". $id;
$result = mysqli_query($mysqli, $sql);
                        
if ($result) {
    $count = 0;
        while ($row = $result->fetch_assoc()) {
            $count++;
?>

<br><h2>Edition de <?= (!empty($row['prenom']) && !empty($row['nom'])) ?  $row['prenom'] . " " . $row['nom'] : $row['username']; ?></h2>

<form action="" method="post">

    <div class="form-row">
        <div class="form-group col-md-3 container-sm text-center">
            <label for="username">Identifiant <span style="color: red; font-weight: bold;">*</span></label>
            <input type="text" class="form-control" name="username" id="username" value="<?= $row['username']; ?>" required>
        </div>
    </div>
    <br>
    <div class="form-row">
        <div class="form-group col-md-3 container-sm">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" name="prenom" id="prenom" value="<?= $row['prenom']; ?>" >
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-3 container-sm">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" name="nom" id="nom" value="<?= $row['nom']; ?>" >
        </div>
    </div>
    <br>


    

    <div class="form-group col-md-3 container-sm text-center">
        <label for="rank">Grade <span style="color: red; font-weight: bold;">*</span></label>
        <select class="form-control" name="rank" id="rank" required>
            <option <?= ( $row['rank'] == 1) ? "selected" : "" ?> value="1">Administrateur</option>
            <option <?= ( $row['rank'] == 0) ? "selected" : "" ?> value="0">Membre</option>
            <option <?= ( $row['rank'] == 2) ? "selected" : "" ?> value="2">Banni</option>
        </select>
    </div>

    <button type="submit" name="valider" id="valider" class="text-center btn btn-success"><i class="fas fa-user-check"></i> Valider</button>



</form>
</div>


<?php 
        } }
?>

</div>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>