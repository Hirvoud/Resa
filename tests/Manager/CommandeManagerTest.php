<?php

namespace App\Tests\Manager;


use App\Entity\Commande;
use App\Exception\CommandeNotFoundException;
use App\Manager\CommandeManager;
use PHPUnit\Framework\TestCase;

class CommandeManagerTest extends TestCase
{
    private $session;
    private $priceCalculator;
    private $payment;
    private $commandeRepository;

    public function setUp()
    {
        $this->session = $this->getMockBuilder("Symfony\Component\HttpFoundation\Session\SessionInterface")
            ->disableOriginalConstructor()
            ->getMock();

        $this->priceCalculator = $this->getMockBuilder("App\Service\PriceCalculator")
            ->disableOriginalConstructor()
            ->getMock();

        $this->payment = $this->getMockBuilder("App\Service\Payment")
            ->disableOriginalConstructor()
            ->getMock();

        $this->commandeRepository = $this ->getMockBuilder("App\Repository\CommandeRepository")
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testGetCurrentCommandeReturnCommande()
    {
        $commandeManager = new CommandeManager($this->session, $this->priceCalculator, $this->payment, $this->commandeRepository);

        $expectedCommande = new Commande();

        $commande = $commandeManager->getCurrentCommande();

        $this->assertEquals($expectedCommande, $commande);
        $this->assertEquals("App\Entity\Commande", get_class($commande));
    }

    public function testGetCurrentCommandeThrowException()
    {
        $this->expectException(CommandeNotFoundException::class);

        $commandeManager = new CommandeManager($this->session, $this->priceCalculator, $this->payment, $this->commandeRepository);

        $commandeManager->getCurrentCommande();


    }
}