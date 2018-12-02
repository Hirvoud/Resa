<?php

namespace App\Tests\Service;


use App\Service\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    private $commande;

    public function setUp()
    {
        $this->commande = $this ->getMockBuilder("App\Entity\Commande")
                                ->disableOriginalConstructor()
                                ->getMock();
    }

    public function testPriceCheck()
    {
        $priceCalculator = new PriceCalculator();

        $priceCalculator->priceCheck($this->commande);


    }
}