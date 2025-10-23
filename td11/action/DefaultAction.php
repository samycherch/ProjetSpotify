<?php
namespace iutnc\deefy\action;

class DefaultAction extends Action {

    // Fonction utilitaire pour démarrage session si nécessaire
    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    protected function executeGet() : string {
        $this->safeSessionStart();
        $username = $_SESSION['username'] ?? null;
        $html = '';
        if ($username) {
            $html .= "<h1>Bienvenue, " . htmlspecialchars($username) . " !</h1>";
            $html .= '
                <form method="post" action="?action=default">
                    <input type="hidden" name="logout" value="1">
                    <button type="submit">Déconnexion</button>
                </form>
            ';
        } else {
            $err = $_SESSION['login_error'] ?? '';
            if ($err) {
                $html .= '<p style="color:red;">' . htmlspecialchars($err) . '</p>';
                unset($_SESSION['login_error']);
            }
            $html .= '
                <h1>Bienvenue sur DeefyApp</h1>
                <form method="post" action="?action=default">
                    <input name="username" placeholder="Votre nom d\'utilisateur">
                    <button type="submit">Connexion</button>
                </form>
            ';
        }
        return $html;
    }

    protected function executePost() : string {
        $this->safeSessionStart();
        if (isset($_POST['logout'])) {
            unset($_SESSION['username']);
            return $this->executeGet();
        }

        $username = $_POST['username'] ?? null;
        if ($username && trim($username) !== '') {
            $_SESSION['username'] = $username;
            return $this->executeGet();
        } else {
            $_SESSION['login_error'] = "Veuillez entrer un nom d'utilisateur !";
            return $this->executeGet();
        }
    }
}
