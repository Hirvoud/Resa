<?php

namespace App\Tests\Service;


use App\Entity\Billet;
use App\Entity\Commande;
use App\Service\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    private $commande;
    /**
     * @var PriceCalculator
     */
    private $priceCalculator;

    public function setUp()
    {
        $this->priceCalculator = new PriceCalculator();
    }


    /**
     * @dataProvider commandeInfos
     *
     * @param string $date
     * @param string $birthDate
     * @param bool $reduce
     * @throws \Exception
     */
    public function testPriceCheck(string $date, string $birthDate, bool $reduce, $expectedPrice)
    {

        $commande = new Commande();
        $commande->setDateVisite(new \DateTime($date));
        $billet = new Billet();
        $billet->setDateNaissance(new \DateTime($birthDate));
        $billet->setReduit($reduce);
        $commande->addBillet($billet);

        $this->priceCalculator->priceCheck($commande);

        $this->assertSame($expectedPrice, $commande->getPrixTotal());


    }

    public function commandeInfos()
    {
        return [
            ['2018-12-1','2010-12-1', true, 8],
            ['2018-12-1','2010-12-1', false, 8],
            ['2018-12-1','2000-12-1', true, 10],
            ['2018-12-1','2000-12-1', false, 16],
        ];
    }
}