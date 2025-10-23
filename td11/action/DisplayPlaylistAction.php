<?php
namespace iutnc\deefy\action;

class DisplayPlaylistAction extends Action {
    protected function executeGet() : string {
        session_start();
        $html = "<h2>Playlists en session (GET)</h2>";
        if (!isset($_SESSION['playlists']) || count($_SESSION['playlists']) == 0) {
            $html .= "<p>Aucune playlist en session.</p>";
        } else {
            foreach ($_SESSION['playlists'] as $pl) {
                $html .= "<div><strong>" . htmlspecialchars($pl['nom']) . "</strong></div>";
            }
        }
        $html .= '<form method="post" action="?action=playlist"><button type="submit">Tester le POST</button></form>';
        return $html;
    }
    protected function executePost() : string {
        return $this->executeGet();
    }
}
