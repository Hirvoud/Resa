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
     * @dataProvider notTuesday
     * @param $year
     * @param $month
     * @param $day
     * @throws \Exception
     */
    public function testValidationTuesdayOk($year,$month,$day)
    {
        $noTuesday = new \DateTime();
        $noTuesday->setDate($year, $month, $day);

        $noTuesdayConstraint = new NoTuesday();
        $noTuesdayValidator = $this->initValidator();

        $noTuesdayValidator->validate($noTuesday, $noTuesdayConstraint);

    }


    public function notTuesday()
    {
        return [
            [2018,12,1],
            [2018,12,3],
            [2018,12,5]
        ];

    }

    /**
     * Test de dates non valides
     * @dataProvider isTuesday
     * @param $year
     * @param $month
     * @param $day
     * @throws \Exception
     */
    public function testValidationTuesdayKo($year,$month,$day)
    {

        $tuesday = new \DateTime();
        $tuesday->setDate($year, $month, $day);


        $noTuesdayConstraint = new NoTuesday();

        $noTuesdayValidator = $this->initValidator($noTuesdayConstraint->message);
        $noTuesdayValidator->validate($tuesday, $noTuesdayConstraint);
    }

    public function isTuesday()
    {
        return [
            [2018,12,4],
            [2018,12,11]
        ];

    }
}