<?php

namespace App\Tests\Validator\Constraints;

use App\Validator\Constraints\NotAfter14;
use App\Validator\Constraints\NotAfter14Validator;

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

    /**
     * Test de dates valides
     */
    public function testValidationOk()
    {
        $notAfter14Constraint = new NotAfter14();
        $notAfter14Validator = $this->initValidator();

        $notAfter14Validator->validate("6", $notAfter14Constraint);

    }

    /**
     * Test de dates non valides
     */
    public function testValidationKo()
    {
        $notAfter14Constraint = new NotAfter14();

        $notAfter14Validator = $this->initValidator($notAfter14Constraint->message);
        $notAfter14Validator->validate("32", $notAfter14Constraint);
    }
}