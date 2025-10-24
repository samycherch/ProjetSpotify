<?php
namespace iutnc\deefy\action;

require_once __DIR__ . '/Action.php';
require_once __DIR__ . '/DefaultAction.php';
require_once __DIR__ . '/DisplayPlaylistAction.php';
require_once __DIR__ . '/AddPlaylistAction.php';
require_once __DIR__ . '/AddPodcastTrackAction.php';
require_once __DIR__ . '/AddUserAction.php';

class Dispatcher {

    private ?string $action = null;

    public function __construct() {
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'default';
    }

    public function run() : void {
        $html = '';
        switch ($this->action) {
            case 'playlist':
                $act = new DisplayPlaylistAction();
                $html = $act();
                break;
            case 'add-playlist':
                $act = new AddPlaylistAction();
                $html = $act();
                break;
            case 'add-track':
                $act = new AddPodcastTrackAction();
                $html = $act();
                break;
            case 'add-user':
                $act = new AddUserAction();
                $html = $act();
                break;
            case 'default':
            default:
                $act = new DefaultAction();
                $html = $act();
                break;
        }
        $this->renderPage($html);
    }

    private function renderPage(string $html) : void {
        echo "<!DOCTYPE html>";
        echo "<html><head><title>DeefyApp</title></head><body>";
        echo $html;
        echo "</body></html>";
    }
}
