<?php
namespace iutnc\deefy\action;

class AddUserAction extends Action {
    private function safeSessionStart() {
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
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
            <h2>Inscription utilisateur</h2>
            <form method="post" action="?action=add-user">
                <input name="username" placeholder="Nom d\'utilisateur">
                <button type="submit">Inscription</button>
            </form>
            <a href="?action=default">Retour à l\'accueil</a>
        ';
    }
    protected function executePost() : string {
        $this->safeSessionStart();
        $username = $_POST['username'] ?? '';
        $username = trim($username);
        if ($username === '') {
            $_SESSION['user_error'] = "Veuillez entrer un nom d'utilisateur !";
            return $this->executeGet();
        }
        if (!isset($_SESSION['users'])) $_SESSION['users'] = [];
        if (in_array($username, $_SESSION['users'], true)) {
            $_SESSION['user_error'] = "Nom d'utilisateur déjà utilisé !";
            return $this->executeGet();
        }
        $_SESSION['users'][] = $username;
        $_SESSION['username'] = $username;
        return '
            <h2>Inscription réussie et connexion : ' . htmlspecialchars($username) . '</h2>
            <a href="?action=default">Retour à l\'accueil</a>
        ';
    }
}
