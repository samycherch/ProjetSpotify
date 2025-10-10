<?php
namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\AudioTrack;

interface Renderer {
    public function render(): string;
}

class AudioListRenderer implements Renderer
{
    private AudioList $audioList;

    public function __construct(AudioList $audioList)
    {
        $this->audioList = $audioList;
    }

    public function render(): string
    {
        $html = "<div class='audio-list'>\n";
        $html .= "<h3>{$this->audioList->nom}</h3>\n";
        $html .= "<ul>\n";

        foreach ($this->audioList->pistes as $index => $piste) {
            // mode compact : titre + artiste + durée
            $html .= "<li>" . ($index + 1) . ". {$piste->titre} - {$piste->auteur} ({$piste->duree} sec)</li>\n";
        }

        $html .= "</ul>\n";
        $html .= "<p><strong>Total :</strong> " 
               . count($this->audioList->pistes) 
               . " pistes, {$this->audioList->dureeTotale} sec</p>\n";
        $html .= "</div>\n";

        return $html;
    }
}
