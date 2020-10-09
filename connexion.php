<?php 
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header.php'); 

if (isset($_SESSION['auth'])) {
    header('Location: ./');
}
?>
<h1>Connexion</h1>
<?php
$pseudo = "";
if (isset($_POST['valider'])) {
    $pseudo = $_POST['pseudo'];
    $sql = 'SELECT * FROM users WHERE username = "'. $pseudo .'"';
    $result = mysqli_query($mysqli, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = $result->fetch_assoc()) {

            if(password_verify($_POST['pass'], $row['password'])){

                $_SESSION['auth'] = $row['id'];
                header("Location: ./");

            } else {
                $error = true;
?>
                <br>
                <div class="col-md-12 offset-md-3" style="width: 100%;">
                    <div class="alert alert-danger col-md-6 mb-3" role="alert">
                        <b>Le Pseudo ou Mot de passe est invalide.</b>
                    </div>
                </div>
                <br>
    
<?php 
            }
        }
    } else {
        $error = true;
?>
            <br>
            <div class="col-md-12 offset-md-3" style="width: 100%;">
                <div class="alert alert-danger col-md-6 mb-3" role="alert">
                    <b>Le Pseudo ou Mot de passe est invalide.</b>
                </div>
            </div>
            <br>
<?php 
    } 

}


    //debug($_SESSION);


?>


                
<form method="POST" action="">
                            <div class="form-row">
                                <div class="col-md-4 offset-md-4 mb-3">
                                    <label for="validationTooltip01">Pseudo</label>
                                    <input type="text" name="pseudo" class="form-control" id="validationTooltip01" value="<?= $pseudo ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-4 offset-md-4 mb-3">
                                    <label for="validationTooltip03">Mot de passe</label>
                                    <input type="password" name="pass" class="form-control" id="validationTooltip03">
                                </div>
                            </div>


                            <input name="valider" id="valider" type="submit" value="Valider ✔️" class="btn btn-success"/>
                        </form>
                    
                    
</div>