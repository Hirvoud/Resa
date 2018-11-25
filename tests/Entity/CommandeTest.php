<?php

namespace App\Tests\Entity;


use App\Entity\Commande;
use PHPUnit\Framework\TestCase;

class CommandeTest extends TestCase
{
    public function testNbBillets() {
        $commande = new Commande();

        $result = $commande->getNbBillets();

        $this->assertSame(null, $result);
    }
}