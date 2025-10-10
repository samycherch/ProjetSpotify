<?php
namespace iutnc\deefy\audio\tracks;

use iutnc\deefy\exception\InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException;

class AudioTrack {
    private string $titre;
    private string $auteur;
    private string $date;
    private string $genre;
    private int $duree;
    private string $nomFichierAudio;

    public function __construct(
        string $titre,
        string $nomFichierAudio,
        string $auteur = '',
        string $date = '',
        string $genre = '',
        int $duree = 0
    ) {
        if ($duree < 0) {
            throw new InvalidPropertyValueException("duree", $duree);
        }

        $this->titre = $titre;
        $this->nomFichierAudio = $nomFichierAudio;
        $this->auteur = $auteur;
        $this->date = $date;
        $this->genre = $genre;
        $this->duree = $duree;
    }

    public function __get(string $name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException($name);
    }

    public function __set(string $name, $value) {
        if (!property_exists($this, $name)) {
            throw new InvalidPropertyNameException($name);
        }

        if ($name === "duree" && $value < 0) {
            throw new InvalidPropertyValueException($name, $value);
        }

        $this->$name = $value;
    }

    public function __toString(): string {
        return json_encode(get_object_vars($this));
    }
}
