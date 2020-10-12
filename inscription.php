<?php 
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header.php'); 

if (isset($_SESSION['auth'])) {
    header('Location: ./');
}
?>
<h1>Inscription</h1>
<?php
$pseudo = "";
if (isset($_POST) && !empty($_POST['valider1'])) {
    //Pseudo
    $pseudo = $_POST["pseudo"];


    if(empty($_POST["pseudo"])) {
        $_SESSION['inscription']['erreur']['username'] = "Vous devez mettre un Pseudo.";
    } else if(!preg_match('/^[a-zA-Z0-9_]+$/', $_POST['pseudo'])) {
        $_SESSION['inscription']['erreur']['username'] = "Votre pseudo n'est pas valide (alphanumérique)";
    } else {

        $sql = 'SELECT id FROM users WHERE username = "'. $_POST["pseudo"] .'"';
        $result = mysqli_query($mysqli, $sql);
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['inscription']['erreur']['username'] = 'Ce pseudo est déjà pris';
        }
    }

    //MDP
    if(empty($_POST['pass']) || empty($_POST['confirm_pass'])) {
        $_SESSION['inscription']['erreur']['password'] = "Vous devez mettre un mot de passe.";
    } else if ($_POST['pass'] != $_POST['confirm_pass']) {
        $_SESSION['inscription']['erreur']['password'] = "Votre mot de passe est différent de la confirmation.";
    } 
    
    if (isset($_SESSION['inscription']['erreur'])) { ?> 
            
            <br>
        <div class="col-md-12 offset-md-3" style="width: 100%;">
            <div class="alert alert-danger col-md-6 mb-3" role="alert">
                <b>Veuillez vérifier les informations suivants :</b>
                
                <?php
                foreach ( $_SESSION['inscription']['erreur'] as $type => $message) { ?>

                    <li class="text-left"><?= $message; ?></li>

                <?php } ?>
               
                
            </div>
        </div>
        <br>

        <?php unset($_SESSION['inscription']['erreur']); 
    } else {

        $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
        $sql = 'INSERT INTO users (username, password) VALUES ("'. $_POST["pseudo"] .'", "'. $pass .'")';

        mysqli_query($mysqli, $sql);

        unset( $_SESSION['inscription']);
        header("Location: connexion.php");

    }
}



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
                    <div class="form-row">
                        <div class="col-md-4 offset-md-4 mb-3">
                            <label for="validationTooltip04">Confirmation du Mot de passe</label>
                            <input type="password" name="confirm_pass" class="form-control" id="validationTooltip04">
                        </div>
                    </div>
                    
                    

                    <input name="valider1" id="valider1" type="submit" value="Valider ✔️" class="btn btn-success"/>
                </form>
</div>