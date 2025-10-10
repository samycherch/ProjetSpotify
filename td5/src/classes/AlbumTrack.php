<?php

namespace iutnc\deefy\audio\tracks;

require_once 'AudioTrack.php';

class AlbumTrack extends AudioTrack
{
    private string $album;
    private int $numeroPiste;

    public function __construct(
        string $titre,
        string $nomFichierAudio,
        string $auteur = '',
        string $date = '',
        string $genre = '',
        int $duree = 0,
        string $album = '',
        int $numeroPiste = 0
    ) {
        parent::__construct($titre, $nomFichierAudio, $auteur, $date, $genre, $duree);
        $this->album = $album;
        $this->numeroPiste = $numeroPiste;
    }

    public function __get(string $name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        return parent::__get($name);
    }
}
