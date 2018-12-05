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
     * @dataProvider notSunday
     * @param $year
     * @param $month
     * @param $day
     * @throws \Exception
     */
    public function testValidationSundayOk($year,$month,$day)
    {
        $noSunday = new \DateTime();
        $noSunday->setDate($year, $month, $day);

        $noSundayConstraint = new NoSunday();
        $noSundayValidator = $this->initValidator();

        $noSundayValidator->validate($noSunday, $noSundayConstraint);

    }


    public function notSunday()
    {
        return [
            [2018,12,1],
            [2018,12,3],
            [2018,12,4]
        ];

    }

    /**
     * Test de dates non valides
     * @dataProvider isSunday
     * @param $year
     * @param $month
     * @param $day
     * @throws \Exception
     */
    public function testValidationSundayKo($year,$month,$day)
    {

        $sunday = new \DateTime();
        $sunday->setDate($year, $month, $day);


        $noSundayConstraint = new NoSunday();

        $noSundayValidator = $this->initValidator($noSundayConstraint->message);
        $noSundayValidator->validate($sunday, $noSundayConstraint);
    }

    public function isSunday()
    {
        return [
            [2018,12,2],
            [2018,12,9]
        ];

    }
}