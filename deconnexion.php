<?php
session_start();
session_destroy();
session_start();
$_SESSION['notification'] = "Aurevoir.";
header('Location: ./');