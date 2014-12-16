<?php

namespace AppBundle\Listeners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

class ExceptionListener
{    
    public function __construct()
    {
        
    }
            
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception  = $event->getException();
        $request = $event->getRequest();
        
        $response = new JsonResponse(array($exception->getMessage()), 500);
        
        $event->setResponse($response);
    }
}
