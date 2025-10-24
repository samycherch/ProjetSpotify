<?php
namespace iutnc\deefy\action;

class DisplayPlaylistAction extends Action {

    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    }

    protected function executeGet() : string {
        $this->safeSessionStart();

        // Menu de navigation - exactement même qu'ailleurs (haut de page)
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

        $html = $menu . '<h2>Playlists en session</h2>';
        if (!isset($_SESSION['playlists']) || count($_SESSION['playlists']) == 0) {
            $html .= '<p>Aucune playlist en session.</p>';
        } else {
            foreach ($_SESSION['playlists'] as $i => $pl) {
                $html .= '<div style="margin-bottom:20px;">';
                $html .= '<form method="post" action="?action=playlist" style="display:inline;">
                    <strong>' . htmlspecialchars($pl['nom']) . '</strong>
                    <button type="submit" name="delete" value="'.$i.'" onclick="return confirm(\'Supprimer cette playlist ?\')">Supprimer</button>
                    <input type="text" name="newname" placeholder="Nouveau nom">
                    <button type="submit" name="rename" value="'.$i.'">Modifier</button>
                </form>';
                // Affichage des tracks, support array (upload) ou string (ancien format)
                if (isset($pl['tracks']) && count($pl['tracks']) > 0) {
                    $html .= '<ul>';
                    foreach ($pl['tracks'] as $track) {
                        if (is_array($track)) {
                            $nom = htmlspecialchars($track['nom']);
                            $file = $track['file'] ? htmlspecialchars($track['file']) : '';
                            $audio = $file ? '<audio controls src="audio/'.$file.'"></audio>' : '';
                            $html .= '<li><strong>' . $nom . '</strong> ' . $audio . '</li>';
                        } else {
                            $html .= '<li>' . htmlspecialchars($track) . '</li>';
                        }
                    }
                    $html .= '</ul>';
                } else {
                    $html .= '<br><em>Aucune musique dans cette playlist.</em>';
                }
                $html .= '</div>';
            }
        }

        // Message d'erreur/réussite
        if (isset($_SESSION['playlist_msg'])) {
            $html = '<p style="color:green;">'.htmlspecialchars($_SESSION['playlist_msg']).'</p>' . $html;
            unset($_SESSION['playlist_msg']);
        }
        if (isset($_SESSION['playlist_error'])) {
            $html = '<p style="color:red;">'.htmlspecialchars($_SESSION['playlist_error']).'</p>' . $html;
            unset($_SESSION['playlist_error']);
        }

        return $html;
    }

    protected function executePost() : string {
        $this->safeSessionStart();
        // Suppression
        if (isset($_POST['delete'])) {
            $id = intval($_POST['delete']);
            if (isset($_SESSION['playlists'][$id])) {
                unset($_SESSION['playlists'][$id]);
                $_SESSION['playlists'] = array_values($_SESSION['playlists']);
                $_SESSION['playlist_msg'] = "Playlist supprimée !";
            }
            return $this->executeGet();
        }
        // Modification du nom avec vérif doublons
        if (isset($_POST['rename'], $_POST['newname'])) {
            $id = intval($_POST['rename']);
            $newname = trim($_POST['newname']);
            if ($newname === '') {
                $_SESSION['playlist_error'] = "Indiquez un nouveau nom.";
            } elseif (isset($_SESSION['playlists'][$id])) {
                foreach ($_SESSION['playlists'] as $idx => $plCheck) {
                    if ($idx !== $id && strtolower($plCheck['nom']) === strtolower($newname)) {
                        $_SESSION['playlist_error'] = "Ce nom de playlist existe déjà !";
                        return $this->executeGet();
                    }
                }
                $_SESSION['playlists'][$id]['nom'] = $newname;
                $_SESSION['playlist_msg'] = "Nom modifié !";
            }
            return $this->executeGet();
        }
        return $this->executeGet();
    }
}
