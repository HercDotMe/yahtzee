<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\RouterInterface;

class SecureRequestListener implements EventSubscriberInterface
{
    public const string APP_SECRET_HEADER = 'App-Secret';
    public const string APP_SECRET_REQUIRED = 'app-secret-required';

    private RouterInterface $router;
    private string $secret;

    public function __construct(RouterInterface $router, string $secret)
    {
        $this->router = $router;
        $this->secret = $secret;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $routeName = $request->attributes->get('_route');
        if ($routeName === null) {
            return;
        }

        $route = $this->router->getRouteCollection()->get($routeName);

        if ($route->getOption(self::APP_SECRET_REQUIRED)) {
            $secret = $request->headers->get(self::APP_SECRET_HEADER);

            if ($secret !== $this->secret) {
                throw new UnauthorizedHttpException('', 'Unknown caller, App Secret is not authorized for this API!');
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest'],
        ];
    }
}
