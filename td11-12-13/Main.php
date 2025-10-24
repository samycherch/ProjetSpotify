<?php
// Autoload si tu utilises PSR4 ou spl_autoload_register, sinon require_once :
require_once 'action/Dispatcher.php';
require_once 'db/DeefyRepository.php'; // Adapte le chemin si nécessaire

use iutnc\deefy\db\DeefyRepository;

// Charge config BDD pour accès PDO
DeefyRepository::setConfig('bd.ini'); // Met à jour le chemin si le fichier est ailleurs

// Lance le dispatcher pour le routage des actions/pages
$dispatcher = new \iutnc\deefy\action\Dispatcher();
$dispatcher->run();


