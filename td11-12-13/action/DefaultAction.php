<?php
namespace iutnc\deefy\action;

use iutnc\deefy\db\DeefyRepository;

class DefaultAction extends Action {
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

        $html = $menu . '<h1>Bienvenue !</h1>';
        // --- Ici, appel Repository pour récupérer toutes les playlists et les afficher
        $playlists = DeefyRepository::getAllPlaylists();
        if ($playlists && count($playlists) > 0) {
            $html .= '<h2>Playlists de la base :</h2><ul>';
            foreach ($playlists as $p) {
                $html .= '<li><strong>' . htmlspecialchars($p['nom']) . '</strong> (id : ' . $p['id'] . ')</li>';
            }
            $html .= '</ul>';
        } else {
            $html .= '<p>Aucune playlist en base.</p>';
        }
        return $html;
    }
    protected function executePost() : string {
        return $this->executeGet();
    }
}
