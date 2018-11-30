<?php
/**
 * Created by PhpStorm.
 * User: Bjilt
 * Date: 26/11/2018
 * Time: 12:02
 */

namespace App\EventListener;


use App\Exception\CommandeNotFoundException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelException(GetResponseForExceptionEvent $event)
    {

        $exception = $event->getException();

        if ($exception instanceof CommandeNotFoundException) {
            $response = new RedirectResponse($this->router->generate('error'));
            $event->setResponse($response);
        }
    }

}