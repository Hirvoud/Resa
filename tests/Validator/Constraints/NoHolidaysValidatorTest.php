<?php

namespace App\Tests\Validator\Constraints;

use App\Validator\Constraints\NoHolidays;
use App\Validator\Constraints\NoHolidaysValidator;

/**
 * Class NoHolidaysValidatorTest
 * @package App\Tests\Validator\Constraints
 */
class NoHolidaysValidatorTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return new NoHolidaysValidator();
    }

    /**
     * Test de dates valides
     */
    public function testValidationOk()
    {
        $noHolidaysConstraint = new NoHolidays();
        $noHolidaysValidator = $this->initValidator();

        $noHolidaysValidator->validate("Good", $noHolidaysConstraint);
    }

    /**
     * Test de dates non valides
     */
    public function testValidationKo()
    {
        $noHolidaysConstraint = new NoHolidays();

        $noHolidaysValidator = $this->initValidator($noHolidaysConstraint->message);
        $noHolidaysValidator->validate("Bad", $noHolidaysConstraint);
    }
}