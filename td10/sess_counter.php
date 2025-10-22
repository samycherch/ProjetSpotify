<?php
session_start();
$val = isset($_GET['val']) ? intval($_GET['val']) : 1;
if (isset($_SESSION['sesscounter'])) {
    $_SESSION['sesscounter'] += $val;
    echo "Compteur de session : " . $_SESSION['sesscounter'];
} else {
    $_SESSION['sesscounter'] = $val;
    echo "Première visite, valeur initialisée à $val.";
}
?>
