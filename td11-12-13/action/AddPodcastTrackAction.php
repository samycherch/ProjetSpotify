<?php
namespace iutnc\deefy\action;

class AddPodcastTrackAction extends Action {
    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    }
    protected function executeGet() : string {
        $this->safeSessionStart();
        $menu = '
            <nav style="background:#f3f1fc; padding:8px;">
                <a href="?action=default">Accueil</a> |
                <a href="?action=add-user">Inscription utilisateur</a> |
                <a href="?action=add-playlist">Créer une playlist</a> |
                <a href="?action=playlist">Voir les playlists</a> |
                <a href="?action=add-track">Ajouter une piste</a> |
                <a href="?action=add-track-toplaylist">Associer piste/playlist</a>
            </nav>
        ';
        if (!isset($_SESSION['playlists']) || count($_SESSION['playlists']) == 0) {
            return $menu . '
                <h2>Ajouter un track</h2>
                <p style="color:red;">Aucune playlist disponible. Créez d\'abord une playlist !</p>
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
        } else $msg = '';
        return $menu . $msg . '
            <h2>Ajouter un track à une playlist (avec upload .mp3)</h2>
            <form method="post" action="?action=add-track" enctype="multipart/form-data">
                <input name="track" placeholder="Nom du morceau">
                <select name="playlist">'.$options.'</select>
                <input type="file" name="audiofile" accept=".mp3">
                <button type="submit">Ajouter Track</button>
            </form>
        ';
    }
    protected function executePost() : string {
        $this->safeSessionStart();
        $track = $_POST['track'] ?? '';
        $playlistIndex = $_POST['playlist'] ?? null;
        $audioFileInfo = $_FILES['audiofile'] ?? null;
        if (trim($track) === '') {
            $_SESSION['track_error'] = "Veuillez indiquer le nom du morceau !";
            return $this->executeGet();
        }
        if (!isset($_SESSION['playlists']) || !isset($_SESSION['playlists'][$playlistIndex])) {
            $_SESSION['track_error'] = "Playlist introuvable.";
            return $this->executeGet();
        }
        $filenameOnDisk = null;
        if ($audioFileInfo && $audioFileInfo['error'] === UPLOAD_ERR_OK) {
            $filename = $audioFileInfo['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if ($ext !== 'mp3') {
                $_SESSION['track_error'] = "Seuls les fichiers .mp3 sont acceptés.";
                return $this->executeGet();
            }
            $uploadDir = dirname(__DIR__).DIRECTORY_SEPARATOR.'audio'.DIRECTORY_SEPARATOR;
            $targetName = uniqid("track_").".mp3";
            $targetPath = $uploadDir . $targetName;
            if (!move_uploaded_file($audioFileInfo['tmp_name'], $targetPath)) {
                $_SESSION['track_error'] = "Échec de l'envoi du fichier !";
                return $this->executeGet();
            }
            $filenameOnDisk = $targetName;
        }
        $_SESSION['playlists'][$playlistIndex]['tracks'][] = [
            'nom' => $track,
            'file' => $filenameOnDisk
        ];
        return $this->executeGet();
    }
}
