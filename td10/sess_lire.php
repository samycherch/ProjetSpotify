<?php
session_start();
if (isset($_SESSION['sesscounter'])) {
    echo "Valeur du compteur de session : " . $_SESSION['sesscounter'];
} else {
    echo "Compteur non initialisé.";
}
?>