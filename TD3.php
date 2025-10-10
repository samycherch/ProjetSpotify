<?php

$piste_audio1 = [
    "titre" => "ZOMBIFIED",
    "artiste" => "Falling In Reverse",
    "album" => "Popular Monster",
    "année" => "2022",
    "genre" => "Métal",
    "numéro" => 1,
    "durée" => 202.8,
];

$piste_audio2 = [
    "titre" => "God Is A Weapon",
    "artiste" => "Falling In Reverse",
    "album" => "Popular Monster",
    "année" => "2025",
    "genre" => "Métal",
    "numéro" => 2,
    "durée" => 201,
];

$piste_audio3 = [
    "titre" => "Un monde parfait",
    "artiste" => "Ilona Mitrecey",
    "album" => "Un monde parfait",
    "année" => "2005",
    "genre" => "Dance",
    "numéro" => 3,
    "durée" => 184.2,
];

$playlist = [
    "nom" => "La Cathédrale (Sylvain) du Riff",
    "genre" => "Métal",
    "créateur" => "Samy Kachemir",
    "date" => "04-09-2025",
    "nbPistes" => "3",
    "durée" => 0,
    "pistes" => []
];


function display_track($piste_audio, string $affichage): void{
    if(
        !isset($piste_audio["titre"]) ||
        !isset($piste_audio["artiste"]) ||
        !isset($piste_audio["album"]) ||
        !isset($piste_audio["année"]) ||
        !isset($piste_audio["numéro"]) ||
        !isset($piste_audio["durée"])
    ){
        echo "La playlist n'existe pas !<br>";
        return;
    }
    $titre = $piste_audio["titre"];
    $artiste = $piste_audio["artiste"];
    $album = $piste_audio["album"];
    $annee = $piste_audio["année"];
    $genre = $piste_audio["genre"];
    $num = $piste_audio["numéro"];
    $durée = $piste_audio["durée"];

    switch ($affichage) {
        case "court":
            echo "{$titre} - by {$artiste} (from {$album})<br>";
            break;
        case "complet":
            echo "{$num} - {$titre} - by {$artiste} (from {$album}) - {$durée}s<br>";
            break;
        case "étendu" :
            echo "{$num} - {$titre} - by {$artiste} (from {$album}, {$annee}) - {$durée}s : {$genre}<br>";
            break;
        default :
            echo "Erreur dans le type d'affichage<br>";
            break;
    }
}

function display(array $playlist): void {
    if (
        !isset($playlist["nom"]) ||
        !isset($playlist["genre"]) ||
        !isset($playlist["créateur"]) ||
        !isset($playlist["date"]) ||
        !isset($playlist["nbPistes"]) ||
        !isset($playlist["durée"]) ||
        !isset($playlist["pistes"])
    ) {
        echo "La playlist n'existe pas !<br>";
        return;
    }

    $nom = $playlist["nom"];
    $genre = $playlist["genre"];
    $crea = $playlist["créateur"];
    $date = $playlist["date"];
    $nbPistes = $playlist["nbPistes"];
    $durée = $playlist["durée"];

    echo "playlist : $nom of ($genre) <br>";
    echo "par $crea le $date <br>";
    echo "$nbPistes pistes pour une durée totale de $durée s<br>";
    $compteur = 0;
    foreach($playlist["pistes"] as $piste){
        $compteur++;
        echo "$compteur - ";
        display_track($piste, "court");
    }
}


function play_track($piste_audio): void{
    $titre = $piste_audio["titre"];
    echo "<h5>$titre</h5>";
    $compteur = 1;
    while($compteur <= $piste_audio["durée"]){
        if($compteur % 50 === 0){
            echo "<br>";
        }
        echo "$compteur.";
        $compteur++;
    }
    echo "<br>";
}

function add_track(array &$playlist, array $piste): void {
    // Initialisation du tableau des pistes s'il n'existe pas
 if (empty($playlist["pistes"]) || !is_array($playlist["pistes"])) {
        $playlist["pistes"] = [];
    }

    // Ajout de la piste
    $playlist["pistes"][] = $piste;

    // Mise à jour des métadonnées
    $playlist["nbpistes"] = count($playlist["pistes"]);
    $playlist["durée"] = ($playlist["durée"] ?? 0) + $piste["durée"];
}

function play(array $playlist) : void {
    if(!isset($playlist["pistes"]) || !is_array($playlist["pistes"])) {
        echo "La playlist ne contient pas de pistes";
        return;
    }
    foreach($playlist["pistes"] as $piste){
        play_track($piste);
    }
}

function remove_track(array &$playlist, int $numPiste) : void {
    if(!isset($playlist["pistes"]) || (!is_array($playlist["pistes"]))){
        echo "La playlist ne contient pas de pistes";
        return;
    }
    if($numPiste < 1 || $numPiste > $playlist["nbPistes"]){
        echo "Erreur : la piste n'existe pas";
    }
    $rmPiste = $playlist["pistes"][$numPiste - 1];
    unset($playlist["pistes"][$numPiste - 1]);
    $playlist["pistes"] = array_values($playlist["pistes"]);
    $playlist["nbPistes"] = count($playlist["pistes"]);
    $playlist["durée"] -= $rmPiste["durée"];
    echo "Playlist numéro {$numPiste} supprimée<br>";
    display($playlist);
}

function pl_shuffle(array &$playlist) : void {
    if(!isset($playlist["pistes"]) || (!is_array($playlist["pistes"]))){
        echo "La playlist ne contient pas de pistes";
        return;
    }
    shuffle($playlist["pistes"]);
    display($playlist);
}


add_track($playlist, $piste_audio1);
add_track($playlist, $piste_audio2);
add_track($playlist, $piste_audio3);
echo "<h2>Affichage de la playlist</h2>";
display($playlist);
echo "<br><h2>Affichage d'une piste audio étendu</h2>";
display_track($piste_audio2, "étendu");
echo "<br><h2>Affichage d'une piste audio complet</h2>";
display_track($piste_audio2, "complet");
echo "<br><h2>Affichage d'une piste audio court</h2>";
display_track($piste_audio2, "court");
echo "<br><h2>Affichage de l'interprétation audio d'une piste</h2>";
play_track($piste_audio2);
echo "<br><h2>Affichage d'une playlist entière</h2>";
play($playlist);
echo "<br><h2>Affichage de la playlist après suppression d'une piste</h2>";
remove_track($playlist, 3);
echo "<br><h2>Affichage après mélange de la playlist</h2>";
pl_shuffle($playlist);