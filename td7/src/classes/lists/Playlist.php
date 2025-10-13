<?php
namespace iutnc\deefy\lists;

require_once 'AudioList.php';



class Playlist extends AudioList {

    public function __construct(string $nom, array $pistes = []) {
        parent::__construct($nom, $pistes);
    }

    // Ajouter une piste
    public function ajouterPiste($piste) {
        $this->pistes[] = $piste;
        $this->nbPistes = count($this->pistes);
        $this->dureeTotale += $piste->duree;
    }

    // Supprimer une piste par index
    public function supprimerPiste(int $index) {
        if (isset($this->pistes[$index])) {
            $this->dureeTotale -= $this->pistes[$index]->duree;
            unset($this->pistes[$index]);
            $this->pistes = array_values($this->pistes); // réindexation
            $this->nbPistes = count($this->pistes);
        } else {
            throw new Exception("Indice de piste invalide : $index");
        }
    }

    // Ajouter une liste de pistes (en évitant doublons)
    public function ajouterPistes(array $listePistes) {
        foreach ($listePistes as $piste) {
            if (!in_array($piste, $this->pistes, true)) {
                $this->ajouterPiste($piste);
            }
        }
    }

    public function __toString() {
        return "Playlist: {$this->nom} ({$this->nbPistes} pistes, {$this->dureeTotale} sec)";
    }
}
