<?php

namespace App\Tests\Validator\Constraints;

use App\Validator\Constraints\NoSunday;
use App\Validator\Constraints\NoSundayValidator;

/**
 * Class NoSundayValidatorTest
 * @package App\Tests\Validator\Constraints
 */
class NoSundayValidatorTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return new NoSundayValidator();
    }

    /**
     * Test de dates valides
     * @throws \Exception
     */
    public function testValidationOk()
    {
        $date = new \DateTime();
        $date->setDate(2018, 12, 01);

        $noSundayConstraint = new NoSunday();
        $noSundayValidator = $this->initValidator();

        $noSundayValidator->validate($date, $noSundayConstraint);

    }

    /**
     * Test de dates non valides
     * @throws \Exception
     */
    public function testValidationKo()
    {
        $date = new \DateTime();
        $date->setDate(2018, 12, 02);

        $noSundayConstraint = new NoSunday();

        $noSundayValidator = $this->initValidator($noSundayConstraint->message);
        $noSundayValidator->validate($date, $noSundayConstraint);
    }
}