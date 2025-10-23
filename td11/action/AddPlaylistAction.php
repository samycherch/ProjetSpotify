<?php
namespace iutnc\deefy\action;

class AddPlaylistAction extends Action {
    protected function executeGet() : string {
        return '
            <h2>Ajout d\'une playlist (GET)</h2>
            <form method="post" action="?action=add-playlist">
                <input name="nom" placeholder="Nom de la playlist">
                <button type="submit">Ajouter</button>
            </form>
        ';
    }
    protected function executePost() : string {
        session_start();
        $nom = $_POST['nom'] ?? 'Sans nom';

        // On stocke la playlist en session
        if (!isset($_SESSION['playlists'])) $_SESSION['playlists'] = [];
        $_SESSION['playlists'][] = ['nom' => $nom, 'tracks' => []];

        return "<h2>Playlist ajoutée : " . htmlspecialchars($nom) . "</h2>";
    }
}
