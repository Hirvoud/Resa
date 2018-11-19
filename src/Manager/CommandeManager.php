<?php

namespace App\Manager;


use App\Entity\Billet;
use App\Entity\Commande;

class CommandeManager
{
    public function CreationBillets($nbBillets) {

        $commande = new Commande();

        for ($i = 1; $i <= $nbBillets; $i++) {
            $billet[$i] = new Billet();
            $commande->addBillet($billet[$i]);
        }
    }

    public function NumCommande() {

        return null;
    }

}