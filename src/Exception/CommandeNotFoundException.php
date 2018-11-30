<?php

namespace App\Exception;


class CommandeNotFoundException extends \Exception
{

    public $message = "Commande not found";

}