<?php
$nom_cookie = 'compteur';

$expire = time() + 3600*2; // 2h
$chemin = '/';

if (!isset($_COOKIE[$nom_cookie])) {
    setcookie($nom_cookie, 1, $expire, $chemin);
    echo "Première visite, compteur initialisé à 1.";
} else {
    $compteur = intval($_COOKIE[$nom_cookie]) + 1;
    setcookie($nom_cookie, $compteur, $expire, $chemin);
    echo "Vous avez visité cette page $compteur fois.";
}

?>