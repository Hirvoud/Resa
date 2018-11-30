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
        $noSunday1 = new \DateTime();
        $noSunday1->setDate(2018, 12, 1);

        $noSunday2 = new \DateTime();
        $noSunday2->setDate(2018, 12, 3);

        $noSundayConstraint = new NoSunday();
        $noSundayValidator = $this->initValidator();

        $noSundayValidator->validate($noSunday1, $noSundayConstraint);
        $noSundayValidator->validate($noSunday2, $noSundayConstraint);

    }

    /**
     * Test de dates non valides
     * @throws \Exception
     */
    public function testValidationKo()
    {
        $noSunday1 = new \DateTime();
        $noSunday1->setDate(2018, 12, 2);

        $noSunday2 = new \DateTime();
        $noSunday2->setDate(2018, 12, 9);

        $noSundayConstraint = new NoSunday();

        $noSundayValidator = $this->initValidator($noSundayConstraint->message);
        $noSundayValidator->validate($noSunday1, $noSundayConstraint);

        $noSundayValidator = $this->initValidator($noSundayConstraint->message);
        $noSundayValidator->validate($noSunday2, $noSundayConstraint);
    }
}