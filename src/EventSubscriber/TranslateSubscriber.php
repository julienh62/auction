<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TranslateSubscriber implements EventSubscriberInterface
{
    private $defaultLocale;

    public function __construct($defaultLocale = 'fr')
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
       $request = $event->getRequest();

       if ($locale = $request->attributes->get('locale')) {
           $request->getSession()->set('locale', $locale);

       } else {
           $request->setLocale($request->getSession()->get('locale', $this->defaultLocale));
       }
    }

    public static function getSubscribedEvents(): array
    {
        // 20 pour la priority
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 20]],
        ];
    }
}
