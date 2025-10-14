<?php
if (isset($_COOKIE['chocolat'])) {
    echo "Cookie présent : " . $_COOKIE['chocolat'];
} else {
    setcookie('chocolat', 'fondant', time() + 2 * 3600);
    echo "Création cookie";
}
?>