<?php

namespace App\Exception;


class CommandeNotFoundException extends \Exception
{

    public $message = "Aucune commande n'a été trouvée";

}