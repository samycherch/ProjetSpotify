<?php
session_start();
if (isset($_SESSION['fibo'])) {
    $n = count($_SESSION['fibo']);
    $next = $_SESSION['fibo'][$n-1] + $_SESSION['fibo'][$n-2];
    $_SESSION['fibo'][] = $next;
    echo "Term ajouté dans Fibonacci : $next";
} else {
    echo "La suite n'est pas initialisée.";
}
?>
