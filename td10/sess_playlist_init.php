<?php
require_once 'Playlist.php';
session_start();
require_once 'Playlist.php';
$_SESSION['playlist'] = new Playlist();
echo "Playlist créée dans la session.";
?>
