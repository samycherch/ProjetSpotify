<?php
class Playlist {
    public $tracks = [];
    public function addTrack($track) {
        $this->tracks[] = $track;
    }
}
?>
