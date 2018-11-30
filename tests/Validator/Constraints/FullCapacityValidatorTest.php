<?php

namespace App\Tests\Validator\Constraints;

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
        $cmd = $this->createMock(CommandeRepository::class);
        return new FullCapacityValidator($cmd);
    }

    /**
     * Test de dates valides
     */
    public function testValidationOk()
    {
        $fullCapacityConstraint = new FullCapacity();
        $fullCapacityValidator = $this->initValidator();

        $fullCapacityValidator->validate("6", $fullCapacityConstraint);

    }

    /**
     * Test de dates non valides
     */
    public function testValidationKo()
    {
        $fullCapacityConstraint = new FullCapacity();

        $fullCapacityValidator = $this->initValidator($fullCapacityConstraint->message);
        $fullCapacityValidator->validate("32", $fullCapacityConstraint);
    }
}