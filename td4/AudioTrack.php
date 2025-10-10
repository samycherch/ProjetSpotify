<?php

declare(strict_types=1);

class AudioTrack
{
    public string $titre;
    public string $auteur;  // artiste ou auteur selon le cas
    public string $genre;
    public float $duree;
    public string $fichier;

    public function __construct(string $titre, string $fichier)
    {
        $this->titre = $titre;
        $this->fichier = $fichier;
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this), JSON_UNESCAPED_UNICODE);
    }
}
