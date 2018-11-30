<?php

namespace App\Tests\Entity;


use App\Entity\Commande;
use PHPUnit\Framework\TestCase;

class CommandeTest extends TestCase
{
    public function testNbBillets() {
        $commande = new Commande();

        $commande->setNbBillets(32);

        $result = $commande->getNbBillets();

        $this->assertSame(32, $result);
    }
}