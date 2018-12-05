<?php

namespace App\Tests\Validator\Constraints;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Validator\Constraints\FullCapacityValidator;
use App\Validator\Constraints\FullCapacity;

/**
 * Class FullCapacityValidatorTest
 * @package App\Tests\Validator\Constraints
 */
class FullCapacityValidatorTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        $this->cmd = $this->createMock(CommandeRepository::class);
        return new FullCapacityValidator($this->cmd);
    }

    /**
     * Test de dates valides
     */
    public function testValidationFullOk()
    {
        $fullCapacityConstraint = new FullCapacity();
        $fullCapacityValidator = $this->initValidator();

        $commande = new Commande();
        $commande->setDateVisite(new \DateTime('2018-12-1'));
        $commande->setNbBillets(10);


        $this->cmd->method('countBilletsForDate')
            ->willReturn(990);



        $fullCapacityValidator->validate($commande, $fullCapacityConstraint);

    }

    /**
     * Test de dates non valides
     */
    public function testValidationFullKo()
    {
        $fullCapacityConstraint = new FullCapacity();
        $fullCapacityValidator = $this->initValidator($fullCapacityConstraint->message);


        $commande = new Commande();
        $commande->setDateVisite(new \DateTime('2018-12-1'));
        $commande->setNbBillets(6);

        $this->cmd->method('countBilletsForDate')
            ->willReturn(1050);


        $fullCapacityValidator->validate($commande, $fullCapacityConstraint);
    }
}