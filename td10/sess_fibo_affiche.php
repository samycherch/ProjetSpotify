<?php
session_start();
if (isset($_SESSION['fibo'])) {
    echo "Suite complète : " . implode(', ', $_SESSION['fibo']);
} else {
    echo "Suite Fibonacci non initialisée.";
}
?>
