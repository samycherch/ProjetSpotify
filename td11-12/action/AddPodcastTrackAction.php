<?php
namespace iutnc\deefy\action;

class AddPodcastTrackAction extends Action {

    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    }

    protected function executeGet() : string {
        $this->safeSessionStart();
        if (!isset($_SESSION['playlists']) || count($_SESSION['playlists']) == 0) {
            return '
                <h2>Ajouter un track</h2>
                <p style="color:red;">Aucune playlist disponible. Créez d\'abord une playlist !</p>
                <a href="?action=add-playlist">Créer une playlist</a>
                | <a href="?action=default">Retour à l\'accueil</a>
            ';
        }
        $options = '';
        foreach ($_SESSION['playlists'] as $i => $playlist) {
            $options .= '<option value="'.$i.'">'.htmlspecialchars($playlist['nom']).'</option>';
        }
        $err = $_SESSION['track_error'] ?? '';
        if ($err) {
            $msg = '<p style="color:red;">' . htmlspecialchars($err) . '</p>';
            unset($_SESSION['track_error']);
        } else {
            $msg = '';
        }
        return $msg . '
            <h2>Ajouter un track/podcast à une playlist</h2>
            <form method="post" action="?action=add-track">
                <input name="track" placeholder="Nom du morceau">
                <select name="playlist">'.$options.'</select>
                <button type="submit">Ajouter Track</button>
            </form>
            <a href="?action=playlist">Voir les playlists</a>
            | <a href="?action=default">Retour à l\'accueil</a>
        ';
    }

    protected function executePost() : string {
        $this->safeSessionStart();
        $track = $_POST['track'] ?? '';
        $playlistIndex = $_POST['playlist'] ?? null;
        if (trim($track) === '') {
            $_SESSION['track_error'] = "Veuillez indiquer le nom du morceau !";
            return $this->executeGet();
        }
        if (!isset($_SESSION['playlists']) || !isset($_SESSION['playlists'][$playlistIndex])) {
            $_SESSION['track_error'] = "Playlist introuvable.";
            return $this->executeGet();
        }
        $_SESSION['playlists'][$playlistIndex]['tracks'][] = $track;

        return '
            <h2>Track ajouté : ' . htmlspecialchars($track) . '</h2>
            <p>Ajouté à la playlist : <strong>' . htmlspecialchars($_SESSION['playlists'][$playlistIndex]['nom']) . '</strong></p>
            <a href="?action=add-track">Ajouter un autre track</a><br>
            <a href="?action=playlist">Voir les playlists</a>
            | <a href="?action=default">Retour à l\'accueil</a>
        ';
    }
}
