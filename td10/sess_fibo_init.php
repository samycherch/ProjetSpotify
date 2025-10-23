<?php
session_start();
$a = isset($_GET['a']) ? intval($_GET['a']) : 0;
$b = isset($_GET['b']) ? intval($_GET['b']) : 1;
$_SESSION['fibo'] = [$a, $b];
echo "Suite Fibonacci initialisée à [$a, $b].";
?>
