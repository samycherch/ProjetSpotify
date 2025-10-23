<?php
require_once 'Playlist.php';
session_start();
if (isset($_SESSION['playlist'])) {
    echo "Playlist :<br>";
    foreach ($_SESSION['playlist']->tracks as $track) {
        echo htmlspecialchars($track) . "<br>";
    }
} else {
    echo "Playlist non initialisée.";
}
?>
