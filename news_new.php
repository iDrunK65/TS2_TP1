<?php
require_once('./assets/inc/db.php'); 
require_once('./assets/inc/functions.php'); 
require('./assets/inc/header.php'); 

if (!isset($_SESSION['auth'])) {
    header("Location: ./error/403.php");
    exit();
}

if (isset($_POST['news_send'])) {
    $sql ='INSERT INTO news (auteurid, titre, contenu) VALUES (%d, "%s", "%s")';
    $id = $_SESSION['auth'];
    $titre = mysqli_real_escape_string($mysqli, $_POST['news_titre']);
    $contenu = mysqli_real_escape_string($mysqli, $_POST['news_contenu']);

    $newsql = sprintf($sql, $id, $titre, $contenu);
    info_error($newsql);

    if (!mysqli_query($mysqli, $newsql)) {
        info_error(mysqli_error($mysqli));
    } else {
        $news_id = mysqli_insert_id($mysqli);
        header("Location: voirNews.php?id=". $news_id);
    }




} else {
    $titre = $contenu = "";
}


?>


<form action="" method="post">

<div class="form-group">
    <label for="news_titre">Titre</label>
    <input type="text" class="form-control" name="news_titre" id="news_titre" aria-describedby="emailHelp" required>
  </div>
  <div class="form-group">
    <label for="news_contenu">Contenu</label>
    <textarea class="form-control" name="news_contenu" id="news_contenu" rows="20" required></textarea>
  </div>
  <button type="submit" id="news_send" name="news_send" class="btn btn-primary">Valider</button>

</form>