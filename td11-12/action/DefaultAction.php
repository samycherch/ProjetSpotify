<?php
namespace iutnc\deefy\action;

class DefaultAction extends Action {
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
        $html = $menu . '<h1>Bienvenue !</h1>';
        return $html;
    }
    protected function executePost() : string {
        return $this->executeGet();
    }
}
