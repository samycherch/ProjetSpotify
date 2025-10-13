<?php
namespace iutnc\deefy\tracks;

require_once 'AudioTrack.php';



class PodcastTrack extends AudioTrack {
    
    public function __construct(string $titre, string $nomFichierAudio) {
        parent::__construct($titre, $nomFichierAudio);
    }

    public function __toString(): string {
        return parent::__toString() . ", Podcast Titre: " . $this->__get('titre');
    }
}