<?php

function TimeToNow($timestamp, $textbefore = false) {

    $datetime = new DateTime($timestamp);
    $now = new DateTime("now");
    $interval = $datetime->diff($now);
    

    if ( $interval->format("%a") == 0 && $interval->format("%h") == 0 && $interval->format("%i") == 0) {
        if ($interval->format("%s") <= 1 ) {
            $time = $interval->format("%s seconde");
        } else {
            $time = $interval->format("%s secondes");
        }
    } else if ( $interval->format("%a") == 0 && $interval->format("%h") == 0 ){
        if ($interval->format("%i") <= 1 ) {
            $time = $interval->format("%i minute");
        } else {
            $time = $interval->format("%i minutes");
        }
    } else if ($interval->format("%a") == 0) {
        if ($interval->format("%h") <= 1 ) {
            $time = $interval->format("%h heure");
        } else {
            $time = $interval->format("%h heures");
        }
    } else if ($interval->format("%y") == 0 && $interval->format("%m") == 0) {
        if ($interval->format("%d") <= 1 ) {
            $time = $interval->format("%d jour");
        } else {
            $time = $interval->format("%d jours");
        }
    } else if ($interval->format("%y") == 0) {
        $time = $interval->format("%m mois");
    } else {
        if ($interval->format("%y") <= 1 ) {
            $time = $interval->format("%y an");
        } else {
            $time = $interval->format("%y ans");
        }
    }

    $final = $time;
    if ($textbefore) {
        $final = "il y a ". $time;
    }

    return $final;
}

function dateToFrench($date, $format) {
    $english_days = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $french_days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche');
    $english_months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $french_months = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre');
    return str_replace($english_months, $french_months, str_replace($english_days, $french_days, date($format, strtotime($date) ) ) );
}

function info_error($info) {?>
    <div class="alert alert-danger" role="alert">
        <b>Une erreur s'est produite !</b><br> 
        <?= $info; ?>
    </div>
<?php }