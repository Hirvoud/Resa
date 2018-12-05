<?php

namespace App\Tests\Validator\Constraints;

use App\Entity\Commande;
use App\Validator\Constraints\NotAfter14;
use App\Validator\Constraints\NotAfter14Validator;
use Symfony\Bridge\PhpUnit\ClockMock;

/**
 * Class NotAfter14ValidatorTest
 * @package App\Tests\Validator\Constraints
 */
class NotAfter14ValidatorTest extends ValidatorTestAbstract
{
    /**
     * {@inheritdoc}
     */
    protected function getValidatorInstance()
    {
        return new NotAfter14Validator();
    }

    public static function setUpBeforeClass()
    {
        ClockMock::register(NotAfter14::class);
    }

    /**
     * Test de dates valides
     * @throws \Exception
     */
    public function testValidation14Ok()
    {
        ClockMock::withClockMock("2018-12-4 13:00:00");

        $commande = $this->getMockBuilder(Commande::class)
                        ->disableOriginalConstructor()
                        ->getMock();

        $commande->method("getDateVisite")
                ->willReturn(new \DateTime("2018-12-4"));

        $commande->method("getTypeVisite")
                ->willReturn("j");

        $notAfter14Constraint = new NotAfter14();

        $notAfter14Validator = $this->initValidator();

        $notAfter14Validator->validate($commande, $notAfter14Constraint);
    }


    /**
     * Test de dates non valides
     * @throws \Exception
     */
    public function testValidation14Ko()
    {
        ClockMock::withClockMock("2018-12-4 15:00:00");

        $commande = $this->getMockBuilder(Commande::class)
            ->disableOriginalConstructor()
            ->getMock();

        $commande->method("getDateVisite")
            ->willReturn(new \DateTime("2018-12-04"));

        $commande->method("getTypeVisite")
            ->willReturn("j");

        $notAfter14Constraint = new NotAfter14();

        $notAfter14Validator = $this->initValidator($notAfter14Constraint->message);

        $notAfter14Validator->validate($commande, $notAfter14Constraint);
    }
}