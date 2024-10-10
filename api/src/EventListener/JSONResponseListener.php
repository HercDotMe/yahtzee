<?php

namespace App\EventListener;

use App\Exception\ValidationException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JSONResponseListener implements EventSubscriberInterface
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException'],
            KernelEvents::RESPONSE => ['onKernelResponse'],
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();
        if ($response->getStatusCode() === JsonResponse::HTTP_OK && $event->getRequest()->getContentTypeFormat() === 'json') {
            $payload = json_decode($response->getContent(), true);

            $event->setResponse(new JsonResponse([
                'status' => 'ok',
                'message' => null,
                'data' => $payload,
                'violations' => null,
            ]));
        }
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        if ($event->getRequest()->getContentTypeFormat() !== 'json') {
            return ;
        }

        $exception = $event->getThrowable();
        $this->logger->error($exception->getMessage());

        switch (get_class($exception)) {
            case ValidationException::class:
                $event->setResponse(new JsonResponse([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'data' => null,
                    'violations' => json_decode($exception->getMessage(), true),
                ], JsonResponse::HTTP_BAD_REQUEST));
                break;

            default:
                $event->setResponse(new JsonResponse([
                    'status' => 'error',
                    'message' => $exception->getMessage(),
                    'data' => null,
                    'violations' => null,
                ]));
        }
    }
}
