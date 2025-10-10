<?php

declare(strict_types=1);

require_once 'AudioTrack.php';

class PodcastTrack extends AudioTrack
{
    public string $date;

    public function __construct(string $titre, string $fichier)
    {
        parent::__construct($titre, $fichier);
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
