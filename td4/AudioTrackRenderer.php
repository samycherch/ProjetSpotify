<?php
require_once 'Renderer.php';

abstract class AudioTrackRenderer implements Renderer {
    abstract public function getTitre(): string;
    abstract public function getNomFichierAudio(): string;

    public function render(int $selector): string {
        switch ($selector) {
            case Renderer::COMPACT:
                return '<div class="audio-track"><audio controls src="' .
                    $this->getNomFichierAudio() .
                    '" style="height:20px;width:150px;"></audio></div>';
            case Renderer::LONG:
                return '<div class="audio-track"><h3>' .
                    $this->getTitre() .
                    '</h3><audio controls src="' .
                    $this->getNomFichierAudio() .
                    '" style="width:100%;"></audio></div>';
            default:
                return '<div class="audio-track"><h3>' .
                    $this->getTitre() .
                    '</h3><audio controls src="' .
                    $this->getNomFichierAudio() .
                    '"></audio></div>';
        }
    }
}
?>