<?php

namespace App\Tests\Validator\Constraints;

use App\Validator\Constraints\NoTuesday;
use App\Validator\Constraints\NoTuesdayValidator;

/**
 * Class NoTuesdayValidatorTest
 * @package App\Tests\Validator\Constraints
 */
class NoTuesdayValidatorTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return new NoTuesdayValidator();
    }

    /**
     * Test de dates valides
     */
    public function testValidationOk()
    {
        $noTuesdayConstraint = new NoTuesday();
        $noTuesdayValidator = $this->initValidator();

        $noTuesdayValidator->validate("6", $noTuesdayConstraint);

    }

    /**
     * Test de dates non valides
     */
    public function testValidationKo()
    {
        $noTuesdayConstraint = new NoTuesday();

        $noTuesdayValidator = $this->initValidator($noTuesdayConstraint->message);
        $noTuesdayValidator->validate("32", $noTuesdayConstraint);
    }
}