<?php
require_once 'PodcastTrack.php';
require_once 'AudioTrackRenderer.php';

class PodcastRenderer extends AudioTrackRenderer {
    private PodcastTrack $track;

    public function __construct(PodcastTrack $track) {
        $this->track = $track;
    }

    public function getTitre(): string {
        return $this->track->getTitre();
    }

    public function getNomFichierAudio(): string {
        return $this->track->getNomFichierAudio();
    }
}
?>