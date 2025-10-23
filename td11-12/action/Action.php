<?php
namespace iutnc\deefy\action;

abstract class Action {

    protected ?string $http_method = null;
    protected ?string $hostname = null;
    protected ?string $script_name = null;

    public function __construct(){
        $this->http_method = $_SERVER['REQUEST_METHOD'];
        $this->hostname = $_SERVER['HTTP_HOST'];
        $this->script_name = $_SERVER['SCRIPT_NAME'];
    }

    public function execute() : string {
        if ($this->http_method === 'POST') {
            return $this->executePost();
        }
        return $this->executeGet();
    }

    // Optionnel : Permet d'appeler $action() directement
    public function __invoke() : string {
        return $this->execute();
    }

    // Méthodes à spécialiser dans tes enfants  
    protected function executeGet() : string {
        return '';
    }
    protected function executePost() : string {
        return '';
    }
}
