<?php
namespace iutnc\deefy\action;

class AddPodcastTrackAction extends Action {
    protected function executeGet() : string {
        return '
            <h2>Ajout d\'un track/podcast (GET)</h2>
            <form method="post" action="?action=add-track">
                <input name="track" placeholder="Nom du morceau">
                <button type="submit">Ajouter Track</button>
            </form>
        ';
    }
    protected function executePost() : string {
        session_start();
        $track = $_POST['track'] ?? 'Sans nom';

        if (!isset($_SESSION['playlists']) || count($_SESSION['playlists']) == 0) {
            return "<h2>Aucune playlist pour y ajouter un track.</h2>";
        }

        // Ajoute le track à la dernière playlist
        $last = count($_SESSION['playlists']) - 1;
        $_SESSION['playlists'][$last]['tracks'][] = $track;

        return "<h2>Track ajouté : " . htmlspecialchars($track) . " à la playlist : " . htmlspecialchars($_SESSION['playlists'][$last]['nom']) . "</h2>";
    }
}
