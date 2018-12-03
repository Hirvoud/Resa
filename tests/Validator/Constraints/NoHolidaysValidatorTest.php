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
        //TODO résoudre problème de date
        return new NoHolidaysValidator($holidays);
    }

    /**
     * Test de dates valides
     */
    public function testValidationHolidaysOk()
    {
        $noHolidaysConstraint = new NoHolidays();
        $noHolidaysValidator = $this->initValidator();

        $noHolidaysValidator->validate(new \DateTime("2018-12-24"), $noHolidaysConstraint);

    }

    /**
     * Test de dates non valides
     */
    public function testValidationHolidaysKo()
    {
        $noHolidaysConstraint = new NoHolidays();

        $noHolidaysValidator = $this->initValidator($noHolidaysConstraint->message);
        $noHolidaysValidator->validate(new \DateTime("2019-12-25"), $noHolidaysConstraint);
    }
}