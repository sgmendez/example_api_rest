<?php

namespace AppBundle\Listeners;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use AppBundle\Exceptions\NoResultException;
use AppBundle\Exceptions\InvalidParameterException;

class ExceptionListener
{    
    public function __construct()
    {
        
    }
            
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception  = $event->getException();
        //$request = $event->getRequest();
        
        switch (true) {
            case $exception instanceof NoResultException:
                $codeHttp = 404;                
                break;
            case $exception instanceof InvalidParameterException:
                $codeHttp = 400;
                break;
            default:
                $codeHttp = 500;
        }
        
        $response = new JsonResponse(array($exception->getMessage()), $codeHttp);
        
        $event->setResponse($response);
    }
}
