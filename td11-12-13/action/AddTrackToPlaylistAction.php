<?php
namespace iutnc\deefy\action;
use iutnc\deefy\db\DeefyRepository;

class AddTrackToPlaylistAction extends Action {
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

        $playlists = DeefyRepository::getAllPlaylists();
        $tracks = DeefyRepository::getAllTracks();

        $selectPlaylists = '<select name="playlist">';
        foreach ($playlists as $pl)
            $selectPlaylists .= '<option value="'.$pl['id'].'">'.htmlspecialchars($pl['nom']).'</option>';
        $selectPlaylists .= '</select>';

        $selectTracks = '<select name="track">';
        foreach ($tracks as $tr)
            $selectTracks .= '<option value="'.$tr['id'].'">'.htmlspecialchars($tr['titre']).'</option>';
        $selectTracks .= '</select>';

        return $menu . '
            <h2>Lier une piste à une playlist</h2>
            <form method="post" action="?action=add-track-toplaylist">
                Playlist : '.$selectPlaylists.'<br>
                Piste : '.$selectTracks.'<br>
                <button type="submit">Lier</button>
            </form>
        ';
    }

    protected function executePost() : string {
        $this->safeSessionStart();
        $playlistId = intval($_POST['playlist'] ?? 0);
        $trackId = intval($_POST['track'] ?? 0);

        try {
            if ($playlistId && $trackId) {
                DeefyRepository::addTrackToPlaylist($trackId, $playlistId);
                return '<p>Piste liée à la playlist !</p>
                        <a href="?action=add-track-toplaylist">Associer une autre piste</a>
                        <br><a href="?action=default">Retour accueil</a>';
            }
        } catch (\Exception $e) {
            return '<p>'.$e->getMessage().'</p>
                    <a href="?action=add-track-toplaylist">Réessayer</a>';
        }
        return '<p>Erreur : sélection incorrecte.</p>';
    }
}
