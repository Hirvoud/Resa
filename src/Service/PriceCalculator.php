<?php

namespace App\Service;

use App\Entity\Commande;

class PriceCalculator
{
    const NORMAL = 16;
    const ENFANT = 8;
    const GRATUIT = 0;
    const SENIOR = 12;
    const REDUIT = 10;

    /**
     * @param Commande $commande
     */
    public function priceCheck(Commande $commande)
    {

        $billets = $commande->getBillets();

        $prixTotal = 0;

        foreach ($billets as $billet) {
            $age = $billet->getVisitAge();
            $prixBillet = 0;

            if($age < 4){
                $prixBillet = self::GRATUIT;
            }elseif($age < 12){
                $prixBillet = self::ENFANT;
            }elseif ($age >= 60){
                $prixBillet = self::SENIOR;
            }elseif ($age >= 12){
                $prixBillet = self::NORMAL;
            }

            if($billet->getReduit() === true  && $age > 12) {
                $prixBillet = self::REDUIT;
            }


            if($commande->getTypeVisite() == "dj") {
                $prixBillet = $prixBillet / 2;
            }

            $billet->setTarif($prixBillet);
            $prixTotal += $prixBillet;
        }

        $commande->setPrixTotal($prixTotal);

    }

}