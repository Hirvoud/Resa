<?php

namespace App\Tests\Manager;


use App\Entity\Commande;
use App\Exception\CommandeNotFoundException;
use App\Manager\CommandeManager;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class CommandeManagerTest extends TestCase
{
    /**
     * @var Session
     */
    private $session;
    private $priceCalculator;
    private $payment;
    private $commandeRepository;

    /**
     * @var CommandeManager
     */
    private $commandeManager;

    public function setUp()
    {
        $this->session = new Session(new MockArraySessionStorage());

        $this->priceCalculator = $this->getMockBuilder("App\Service\PriceCalculator")
            ->disableOriginalConstructor()
            ->getMock();

        $this->payment = $this->getMockBuilder("App\Service\Payment")
            ->disableOriginalConstructor()
            ->getMock();

        $this->commandeRepository = $this->getMockBuilder("App\Repository\CommandeRepository")
            ->disableOriginalConstructor()
            ->getMock();


        $this->commandeManager = new CommandeManager($this->session, $this->priceCalculator, $this->payment, $this->commandeRepository);
    }

    /**
     * @throws CommandeNotFoundException
     */
    public function testGetCurrentCommandeReturnCommande()
    {
        $this->session->set(CommandeManager::ID_SESSION_COMMANDE, new Commande());
        $commande = $this->commandeManager->getCurrentCommande();

        $this->assertInstanceOf(Commande::class, $commande);
    }

    /**
     * @throws CommandeNotFoundException
     */
    public function testGetCurrentCommandeThrowException()
    {
        $this->expectException(CommandeNotFoundException::class);

        $this->commandeManager->getCurrentCommande();

    }
}