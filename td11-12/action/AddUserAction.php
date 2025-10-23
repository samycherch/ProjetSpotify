<?php
namespace iutnc\deefy\action;

class AddUserAction extends Action {

    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    protected function executeGet() : string {
        $this->safeSessionStart();
        $err = $_SESSION['user_error'] ?? '';
        if ($err) {
            $msg = '<p style="color:red;">' . htmlspecialchars($err) . '</p>';
            unset($_SESSION['user_error']);
        } else {
            $msg = '';
        }

        return $msg . '
            <h2>Inscription/Connexion utilisateur</h2>
            <form method="post" action="?action=add-user">
                <input name="username" placeholder="Votre nom d\'utilisateur">
                <button type="submit">Connexion</button>
            </form>
        ';
    }

    protected function executePost() : string {
        $this->safeSessionStart();
        $username = $_POST['username'] ?? null;
        if ($username && trim($username) !== '') {
            $_SESSION['username'] = $username;
            return '
                <h2>Bienvenue ' . htmlspecialchars($username) . ' !</h2>
                <a href="?action=default">Vers l\'accueil</a>
            ';
        } else {
            $_SESSION['user_error'] = "Veuillez entrer un nom d'utilisateur !";
            // Redirige vers le formulaire avec l'erreur
            return $this->executeGet();
        }
    }
}
