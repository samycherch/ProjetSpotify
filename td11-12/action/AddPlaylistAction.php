<?php
namespace iutnc\deefy\action;

class AddPlaylistAction extends Action {
    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    }
    protected function executeGet() : string {
        $this->safeSessionStart();
        $menu = '
            <nav style="margin-bottom:15px; background:#eef; padding:10px;">
                <a href="?action=default">Accueil</a> |
                <a href="?action=add-user">Inscription utilisateur</a> |
                <a href="?action=add-playlist">Créer une playlist</a> |
                <a href="?action=playlist">Voir les playlists</a> |
                <a href="?action=add-track">Ajouter un track</a>
            </nav>
        ';
        $err = $_SESSION['playlist_error'] ?? '';
        if ($err) {
            $msg = '<p style="color:red;">' . htmlspecialchars($err) . '</p>';
            unset($_SESSION['playlist_error']);
        } else $msg = '';
        return $menu . $msg . '
            <h2>Créer une playlist</h2>
            <form method="post" action="?action=add-playlist">
                <input name="nom" placeholder="Nom de la playlist">
                <button type="submit">Créer</button>
            </form>
        ';
    }
    protected function executePost() : string {
        $this->safeSessionStart();
        $nom = trim($_POST['nom'] ?? '');
        if ($nom === '') {
            $_SESSION['playlist_error'] = "Veuillez indiquer un nom de playlist !";
            return $this->executeGet();
        }
        if (isset($_SESSION['playlists'])) {
            foreach ($_SESSION['playlists'] as $pl) {
                if (strtolower($pl['nom']) === strtolower($nom)) {
                    $_SESSION['playlist_error'] = "Ce nom de playlist existe déjà !";
                    return $this->executeGet();
                }
            }
        }
        if (!isset($_SESSION['playlists'])) $_SESSION['playlists'] = [];
        $_SESSION['playlists'][] = ['nom' => $nom, 'tracks' => []];
        return $this->executeGet();
    }
}
