<?php

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\exception\InvalidPropertyNameException;



class AudioList {
    protected string $nom;
    protected int $nbPistes;
    protected int $dureeTotale;
    protected array $pistes;

    public function __construct(string $nom, array $pistes = []) {
        $this->nom = $nom;
        $this->pistes = $pistes;
        $this->nbPistes = count($pistes);
        $this->dureeTotale = $this->calculerDureeTotale();
    }

    // Getter magique : lecture seule
    public function __get($name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException($name);
    }

    // Interdire la modification
    public function __set($name, $value) {
        throw new Exception("Modification des propriétés interdite pour AudioList");
    }

    protected function calculerDureeTotale(): int {
        $total = 0;
        foreach ($this->pistes as $p) {
            $total += $p->duree;
        }
        return $total;
    }

    public function __toString() {
        return "AudioList: {$this->nom} ({$this->nbPistes} pistes, {$this->dureeTotale} sec)";
    }
}
