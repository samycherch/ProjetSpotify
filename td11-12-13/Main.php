<?php
// Inclusion Repository et Dispatcher
require_once __DIR__ . '/db/DeefyRepository.php';
require_once __DIR__ . '/action/Dispatcher.php';

// Inclusion automatique de tous les fichiers d'action
foreach (glob(__DIR__ . '/action/*.php') as $file) require_once $file;

// Chargement config BDD
\iutnc\deefy\db\DeefyRepository::setConfig(__DIR__ . '/db/bd.ini');

// Dispatcher
$dispatcher = new \iutnc\deefy\action\Dispatcher();
$dispatcher->run();
