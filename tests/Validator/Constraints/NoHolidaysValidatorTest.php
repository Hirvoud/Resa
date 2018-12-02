<?php

namespace App\Tests\Validator\Constraints;

use App\Service\Holidays;
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
        $holidays = new Holidays();
        dump($holidays);
        //TODO résoudre problème de date
        return new NoHolidaysValidator($holidays);
    }

    /**
     * Test de dates valides
     */
    public function testValidationOk()
    {
        $noHolidaysConstraint = new NoHolidays();
        $noHolidaysValidator = $this->initValidator();

        $noHolidaysValidator->validate("2018-12-25", $noHolidaysConstraint);

    }

    /**
     * Test de dates non valides
     */
    public function testValidationKo()
    {
        $noHolidaysConstraint = new NoHolidays();

        $noHolidaysValidator = $this->initValidator($noHolidaysConstraint->message);
        $noHolidaysValidator->validate("2019-01-06", $noHolidaysConstraint);
    }
}