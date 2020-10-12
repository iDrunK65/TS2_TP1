<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$here = $_SERVER['PHP_SELF'];
$array = explode("/",$here);

$actual = $array[count($array) - 1];

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!doctype html>
<html lang="fr">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="./assets/css/vote.css">
    <script src="https://kit.fontawesome.com/b16e522a2f.js" crossorigin="anonymous"></script>
    <title>
        
    <?php 
    if ($actual == "index.php") {
        echo "Accueil";
    } else if ($actual == "news.php") {
        echo "News";
    } else if ($actual == "voirNews.php") {
        echo "News n°". $_GET['id'];
    } else if ($actual == "inscription.php") {
        echo "Inscription"; 
    } else if ($actual == "connexion.php") {
        echo "Connexion";
    } else if ($actual == "admin.php") {
        echo "Administration";
    } else if ($actual == "403.php") {
        echo "Accès Interdit";
    } else if ($actual == "404.php") {
        echo "Page Introuvable";
    } else if ($actual == "news_edit.php") {
        echo "Édition News n°". $_GET['id'];
    } else if ($actual == "news_new.php") {
        echo "Nouvelle News";
    } else {
        echo "Page Inconnue";
    }

?>
    </title>
</head>
<body>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
    <div class="navbar-collapse collapse w-100 order-1 order-md-0 dual-collapse2">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link <?= ($actual == "index.php") ? "active" : "" ?>" href="<?= ($actual == "403.php" || $actual == "404.php") ? ".." : "." ?>/"><i class="fas fa-home"></i> Accueil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?= ($actual == "news.php" || $actual == "voirNews.php") ? "active" : "" ?>" href="<?= ($actual == "403.php" || $actual == "404.php") ? "../" : "" ?>news.php"><i class="far fa-newspaper"></i> News</a>
            </li>
        </ul>
    </div>
    <div class="mx-auto order-0">
        <a class="navbar-brand mx-auto" href="<?= ($actual == "403.php" || $actual == "404.php") ? ".." : "." ?>/">NEWS</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">

        <ul class="navbar-nav ml-auto">
            <?php if (isset($_SESSION['auth'])) { ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i> <?php 
                            $sql = "SELECT username, prenom, nom, rank FROM users WHERE id = ".$_SESSION['auth'];
                            $result = mysqli_query($mysqli, $sql);


                            while ($row = $result->fetch_assoc()) {
                                if (!empty($row['prenom']) && !empty($row['nom'])) {
                                    echo $row['prenom'] . " ". $row['nom'];
                                } else {
                                    echo $row['username'];
                                }
                        ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <!--<a class="dropdown-item" href="#">Profil</a>
                        <a class="dropdown-item" href="#">Paramètres</a>
                        <div class="dropdown-divider"></div>-->
                        <a class="dropdown-item" href="<?= ($actual == "403.php" || $actual == "404.php") ? "../" : "" ?>deconnexion.php">Se déconnecter</a>
                    </div>
                </li>
                <?php if ($row['rank'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($actual == "admin.php") ? "active" : "" ?>" href="<?= ($actual == "403.php" || $actual == "404.php") ? "../" : "" ?>admin.php"><i class="fas fa-cog"></i> Administration </a>
                </li>
                <?php } if ($row['rank'] != 2) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($actual == "news_new.php") ? "active" : "" ?>" href="<?= ($actual == "403.php" || $actual == "404.php") ? "../" : "" ?>news_new.php"><i class="fas fa-file-medical"></i> Ecrire un article </a>
                </li>
            <?php } } } else { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ($actual == "inscription.php") ? "active" : "" ?>" href="<?= ($actual == "403.php" || $actual == "404.php") ? "../" : "" ?>inscription.php"><i class="fas fa-user-plus"></i> S'inscrire  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= ($actual == "connexion.php") ? "active" : "" ?>" href="<?= ($actual == "403.php" || $actual == "404.php") ? "../" : "" ?>connexion.php"><i class="fas fa-sign-in-alt"></i> Se connecter</a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>

    <br>
    
    <div class="container-sm text-center">
