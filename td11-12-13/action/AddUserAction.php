<?php
namespace iutnc\deefy\action;

class AddUserAction extends Action {
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
        $err = $_SESSION['user_error'] ?? '';
        if ($err) {
            $msg = '<p style="color:red;">' . htmlspecialchars($err) . '</p>';
            unset($_SESSION['user_error']);
        } else $msg = '';

        $html = $menu . $msg . '
            <h2>Inscription utilisateur</h2>
            <form method="post" action="?action=add-user">
                <label>Pseudo :
                    <input name="username" placeholder="Nom d\'utilisateur">
                </label><br>
                <label>E-mail :
                    <input type="email" name="email" placeholder="adresse@email.fr">
                </label><br>
                <label>Âge :
                    <input type="number" name="age" min="0" max="120">
                </label><br>
                <button type="submit">Inscription</button>
            </form>
        ';

        // Ajout de la liste des utilisateurs enregistrés
        if (isset($_SESSION['users']) && count($_SESSION['users']) > 0) {
            $html .= '<h3>Utilisateurs enregistrés :</h3><ul>';
            foreach ($_SESSION['users'] as $user) {
                $html .= '<li><strong>' . htmlspecialchars($user['username']) .
                         '</strong> (mail : ' . htmlspecialchars($user['email']) .
                         ', âge : ' . htmlspecialchars($user['age']) . ')</li>';
            }
            $html .= '</ul>';
        }

        return $html;
    }

    protected function executePost() : string {
        $this->safeSessionStart();
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $age = trim($_POST['age'] ?? '');

        if ($username === '' || $email === '' || $age === '') {
            $_SESSION['user_error'] = "Toutes les informations sont obligatoires !";
            return $this->executeGet();
        }
        if (!isset($_SESSION['users'])) $_SESSION['users'] = [];
        foreach ($_SESSION['users'] as $user) {
            if (strtolower($user['username']) === strtolower($username)) {
                $_SESSION['user_error'] = "Nom d'utilisateur déjà utilisé !";
                return $this->executeGet();
            }
        }
        $_SESSION['users'][] = [
            'username' => $username,
            'email' => $email,
            'age' => $age
        ];
        $_SESSION['username'] = $username;
        return $this->executeGet();
    }
}
