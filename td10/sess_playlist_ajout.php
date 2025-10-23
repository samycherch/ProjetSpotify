<?php
require_once 'Playlist.php';
session_start();
require_once 'Playlist.php';
if (isset($_SESSION['playlist'])) {
    $track = isset($_GET['track']) ? $_GET['track'] : 'inconnue';
    $_SESSION['playlist']->addTrack($track);
    echo "Track ajouté : $track";
} else {
    echo "Playlist non initialisée.";
}
?>
