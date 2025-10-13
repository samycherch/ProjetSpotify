<?php

namespace iutnc\deefy\lists;

require_once 'AudioList.php';



class Album extends AudioList {
    protected string $artiste;
    protected int $dateSortie;

    public function __construct(string $nom, array $pistes, string $artiste = "", int $dateSortie = 0) {
        if (empty($pistes)) {
            throw new Exception("Un album doit contenir au moins une piste !");
        }
        parent::__construct($nom, $pistes);
        $this->artiste = $artiste;
        $this->dateSortie = $dateSortie;
    }

    // Setter pour artiste
    public function setArtiste(string $artiste) {
        $this->artiste = $artiste;
    }

    // Setter pour date de sortie
    public function setDateSortie(int $dateSortie) {
        $this->dateSortie = $dateSortie;
    }

    public function __toString() {
        return "Album: {$this->nom} ({$this->nbPistes} pistes, {$this->dureeTotale} sec) - Artiste: {$this->artiste}, Date: {$this->dateSortie}";
    }
}
