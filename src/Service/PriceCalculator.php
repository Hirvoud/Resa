<?php
/**
 * Created by PhpStorm.
 * User: Bjilt
 * Date: 2018-10-24
 * Time: 14:38
 */

namespace App\Service;

use App\Entity\Commande;

class PriceCalculator
{
    const NORMAL = 16;
    const ENFANT = 8;
    const GRATUIT = 0;
    const SENIOR = 12;
    const REDUIT = 10;

    public function ageCheck(Commande $commande) {

        $billets = $commande->getBillets();

        $prixTotal = 0;

        foreach ($billets as $billet) {
            $dateNaissance = $billet->getDateNaissance();
            $today = new \DateTime();
            $diff = date_diff($dateNaissance, $today);
            $age = $diff->format("%y");

            switch ($age) {
                case $age <= 4:
                    $billet->setTarif(self::GRATUIT);
                    break;
                case $age < 12:
                    $billet->setTarif(self::ENFANT);
                    break;
                case $age >= 60:
                    $billet->setTarif(self::SENIOR);
                    break;
                case $age > 18:
                    $billet->setTarif(self::NORMAL);
                    break;
            }

            if($billet->getReduit() == true) {
                $billet->setTarif(self::REDUIT);
            }

            $prixTotal += $billet->getTarif();
        }

        if ($commande->getTypeVisite() == "dj") {
            $prixTotal = $prixTotal/2;
        }

        return $prixTotal;

    }

}