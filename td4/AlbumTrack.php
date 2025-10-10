<?php

declare(strict_types=1);

require_once 'AudioTrack.php';

class AlbumTrack extends AudioTrack
{
    public string $album;
    public int $annee;
    public int $numero;

    public function __construct(string $titre, string $fichier, string $album, int $numero)
    {
        parent::__construct($titre, $fichier);
        $this->album = $album;
        $this->numero = $numero;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function getNomFichierAudio(): string
    {
        return $this->fichier;
    }
}
