<?php

declare(strict_types=1);

require_once 'AlbumTrack.php';
require_once 'AlbumTrackRenderer.php';
require_once 'PodcastTrack.php';
require_once 'PodcastRenderer.php';


$t1 = new AlbumTrack("ZOMBIFIED", "Zombified.mp3", "Popular Monster", 1);
$t1->artiste = "Falling In Reverse";
$t1->annee = 2022;
$t1->genre = "Métal";
$t1->duree = 202.8;

$t2 = new AlbumTrack("Un monde parfait", "un_monde_parfait.mp3", "Un monde parfait", 3);
$t2->artiste = "Ilona Mitrecey";
$t2->annee = 2005;
$t2->genre = "Dance";
$t2->duree = 184.2;


echo "<h1>Exercice 2</h1>";
echo "<h2>Affichage avec echo</h2>";
echo $t1->titre . "<br>";

echo "<h2>Affichage avec print</h2>";
print $t1->artiste . "<br>";

echo "<h2>Affichage avec printf</h2>";
printf("Durée de la piste 1 : %.1f secondes", $t1->duree);

echo "<h2>Affichage avec __toString()</h2>";
echo $t1->__toString() . "<br>";
echo $t2->__toString() . "<br>";

echo "<h2>Affichage de tout avec echo</h2>";
echo $t1 . "<br>";
echo $t2 . "<br>";

echo "<h2>Affichage de tout avec print_r</h2>";
print_r($t1);
echo "<br>";
print_r($t2);
echo "<br>";

echo "<h2>Affichage de tout avec var_dump</h2>";
var_dump($t1);
echo "<br>";
var_dump($t2);

echo "<h1>Exercice 3</h1>";
echo "<h2>Affichage en mode compact</h2>";
$r1 = new AlbumTrackRenderer($t2);
echo $r1->render(1);

echo "<h2>Affichage en mode long</h2>";
$r2 = new AlbumTrackRenderer($t1);
echo $r2->render(2);


echo "<h1>Exercice 4</h1>";
echo "<h2>Création et affichage d'un podcast</h2>";

$p1 = new PodcastTrack("Le Riff de Samy", "riff_samy.mp3");
$p1->auteur = "Samy Kachemir";
$p1->date = "2025-09-25";
$p1->genre = "Discussion";
$p1->duree = 3600.0;
$p1->fichier = "podcast.mp3";

echo $p1 . "<br>";

echo "<h1>Exercice 5</h1>";
echo "<h2>Affichage du podcast en mode compact</h2>";
$pr = new PodcastRenderer($p1);
echo $pr->render(Renderer::COMPACT);

echo "<h2>Affichage du podcast en mode long</h2>";
echo $pr->render(Renderer::LONG);

echo "<h1>Exercice 6</h1>";
$r1 = new AlbumTrackRenderer($t1);
echo $r1->render(Renderer::COMPACT);

$pr = new PodcastRenderer($p1);
echo $pr->render(Renderer::LONG);