<?php
namespace iutnc\deefy\action;

class Dispatcher {
    public function run() {
        $actionName = $_GET['action'] ?? 'default';
        switch ($actionName) {
            case 'add-playlist': $action = new AddPlaylistAction(); break;
            case 'add-track': $action = new AddPodcastTrackAction(); break;
            case 'add-user': $action = new AddUserAction(); break;
            case 'playlist': $action = new DisplayPlaylistAction(); break;
            case 'add-track-toplaylist': $action = new AddTrackToPlaylistAction(); break;
            default: $action = new DefaultAction(); break;
        }
        echo $action();
    }
}
