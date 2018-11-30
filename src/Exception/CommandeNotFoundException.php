<?php
/**
 * Created by PhpStorm.
 * User: Bjilt
 * Date: 26/11/2018
 * Time: 12:00
 */

namespace App\Exception;


class CommandeNotFoundException extends \Exception
{

    public $message = "Commande not found";

}