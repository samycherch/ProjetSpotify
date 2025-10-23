<?php
namespace iutnc\deefy\action;

class DefaultAction extends Action {
    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
    }

    protected function executeGet() : string {
        $this->safeSessionStart();
        $html = '<h1>Bienvenue !</h1>';
        $html .= '
            <nav>
                <ul>
                    <li><a href="?action=default">Accueil</a></li>
                    <li><a href="?action=add-playlist">Créer une playlist</a></li>
                    <li><a href="?action=playlist">Voir les playlists</a></li>
                    <li><a href="?action=add-track">Ajouter un track</a></li>
                    <li><a href="?action=add-user">Inscription utilisateur</a></li>
                </ul>
            </nav>
        ';
        return $html;
    }
    protected function executePost() : string {
        return $this->executeGet();
    }
}
