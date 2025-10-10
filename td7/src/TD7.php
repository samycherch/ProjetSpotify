<?php
require_once  './classes/tracks/AlbumTrack.php';
require_once  './classes/tracks/PodcastTrack.php';
// require_once  './classes/exception/InvalidPropertyNameException.php';
// require_once  './classes/exception/InvalidPropertyValueException.php';
require_once  './classes/lists/Album.php';
require_once  './classes/lists/Playlist.php';
require_once  './classes/render/AudioListRenderer.php';
require_once './classes/Autoloader.php';


use iutnc\deefy\audio\tracks\AlbumTrack;
use iutnc\deefy\audio\tracks\PodcastTrack;
use iutnc\deefy\audio\lists\Album;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\render\AudioListRenderer;

$autoloader = new \iutnc\deefy\Autoloader('iutnc\deefy', __DIR__ . '/classes');
$autoloader->register();

echo "<h1>TD7</h1>";

try {
    $piste1 = new AlbumTrack(
        "Watch the World Burn",
        "WTWB.mp3",
        "Falling in Reverse",
        2023,
        "Metal",
        250,
        "Popular Monster",
        1
    );

    $piste2 = new AlbumTrack(
        "ZOMBIFIED",
        "Zombified.mp3",
        "Falling in Reverse",
        2023,
        "Metal",
        300, 
        "Popular Monster",
        2
    );

    $podcast1 = new PodcastTrack("Podcast", "podcast.mp3");


    echo "<h2>Affichage des attributs individuellement :</h2>\n";

    echo "Piste 1 :\n";
    echo "Titre : " . $piste1->titre . "\n";
    echo "Fichier : " . $piste1->nomFichierAudio . "\n";
    echo "Album : " . $piste1->album . "\n";
    echo "Numéro : " . $piste1->numeroPiste . "\n\n";
    echo "Artiste : " . $piste1->auteur . "\n";
    echo "Année : " . $piste1->date . "\n";
    echo "Genre : " . $piste1->genre . "\n";
    echo "Durée : " . $piste1->duree . "\n";
    echo "<br>\n";

    echo "Piste 2 :\n";
    print "Titre : " . $piste2->titre . "\n";
    print "Fichier : " . $piste2->nomFichierAudio . "\n";
    print "Album : " . $piste2->album . "\n";
    print "Numéro : " . $piste2->numeroPiste . "\n\n";
    print "Artiste : " . $piste2->auteur . "\n";
    print "Année : " . $piste2->date . "\n";
    print "Genre : " . $piste2->genre . "\n";
    print "Durée : " . $piste2->duree . "\n\n";
    echo "<br>\n";

    echo "<h2>Affichage des attributs avec Printf :</h2>\n";

    
    printf(
        "Piste 1 : %s (%s) - Album : %s [#%d] - Artiste : %s - Année : %d - Genre : %s - Durée : %d\n",
        $piste1->titre,
        $piste1->nomFichierAudio,
        $piste1->album,
        $piste1->numeroPiste,
        $piste1->auteur,
        $piste1->date,
        $piste1->genre,
        $piste1->duree
    );
    echo "<br>";

    printf(
        "Piste 2 : %s (%s) - Album : %s [#%d] - Artiste : %s - Année : %d - Genre : %s - Durée : %d\n",
        $piste2->titre,
        $piste2->nomFichierAudio,
        $piste2->album,
        $piste2->numeroPiste,
        $piste2->auteur,
        $piste2->date,
        $piste2->genre,
        $piste2->duree
    );
    echo "<br>";


    echo "<h2>Affichage avec __toString() :</h2>\n";
    echo $piste1->__toString() . "\n";
    echo "<br>";
    echo $piste2->__toString() . "\n";
    echo "<br>";


    echo "<h2>Affichage avec echo (sans __toString explicite) :</h2>\n";
    echo $piste1 . "\n";
    echo "<br>";
    echo $piste2 . "\n\n";
    echo "<br>";

    echo "<h2>Affichage avec print_r :</h2>\n";
    print_r($piste1);
    echo "<br>";
    print_r($piste2);
    echo "<br>";

    echo "\n<h2>Affichage avec var_dump :</h2>\n";
    var_dump($piste1);
    echo "<br>";
    var_dump($piste2);
    echo "<br>";



} catch (Exception $e) {
    echo "<h3>Autre erreur : " . $e->getMessage() . "</h3>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}


echo "<h1>Exercice 3 : AudioList / Album / Playlist</h1>";


echo "<h2>Album</h2>";
$album = new Album("Best of FIR", [$piste1, $piste2], "Falling in Reverse", 2023);
echo $album . "<br>";


echo "<h2>Playlist</h2>";
$playlist = new Playlist("Ma Playlist");
$playlist->ajouterPiste($piste1);
$playlist->ajouterPistes([$piste2, $podcast1, $piste1]);
echo $playlist . "<br>";


echo "<h2>Après suppression d'une piste</h2>";
$playlist->supprimerPiste(1);
echo $playlist . "<br>";



echo "<h2>Affichage HTML avec AudioListRenderer</h2>";

$albumRenderer = new AudioListRenderer($album);
echo $albumRenderer->render();

$playlistRenderer = new AudioListRenderer($playlist);
echo $playlistRenderer->render();

?>
