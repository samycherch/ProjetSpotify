<?php
require_once 'AlbumTrack.php';
require_once 'AudioTrackRenderer.php';

class AlbumTrackRenderer extends AudioTrackRenderer {
    private AlbumTrack $track;

    public function __construct(AlbumTrack $track) {
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