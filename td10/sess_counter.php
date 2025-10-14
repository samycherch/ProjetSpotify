<?php
session_start();
if (isset($_SESSION['sesscounter'])) {
    $_SESSION['sesscounter']++;
    echo "Compteur de session : " . $_SESSION['sesscounter'];
} else {
    $_SESSION['sesscounter'] = 1;
    echo "Première visite de la session (valeur : 1).";
}
?>