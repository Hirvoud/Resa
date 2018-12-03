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
     * @throws \Exception
     */
    public function testValidationTuesdayOk()
    {
        $noTuesday1 = new \DateTime();
        $noTuesday1->setDate(2018, 12, 1);

        $noTuesday2 = new \DateTime();
        $noTuesday2->setDate(2018, 12, 3);

        $noTuesdayConstraint = new noTuesday();
        $noTuesdayValidator = $this->initValidator();

        $noTuesdayValidator->validate($noTuesday1, $noTuesdayConstraint);
        $noTuesdayValidator->validate($noTuesday2, $noTuesdayConstraint);

    }

    /**
     * Test de dates non valides
     * @throws \Exception
     */
    public function testValidationTuesdayKo()
    {
        $noTuesday1 = new \DateTime();
        $noTuesday1->setDate(2018, 12, 4);

        $noTuesday2 = new \DateTime();
        $noTuesday2->setDate(2018, 12, 11);

        $noTuesdayConstraint = new noTuesday();

        $noTuesdayValidator = $this->initValidator($noTuesdayConstraint->message);
        $noTuesdayValidator->validate($noTuesday1, $noTuesdayConstraint);

        $noTuesdayValidator = $this->initValidator($noTuesdayConstraint->message);
        $noTuesdayValidator->validate($noTuesday2, $noTuesdayConstraint);
    }
}