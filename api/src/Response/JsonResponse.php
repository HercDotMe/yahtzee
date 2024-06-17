<?php

namespace App\Response;

use DateTime;
use DateTimeInterface;

class JsonResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
    public function __construct($data, $status, $headers = [])
    {
        $data = [
            'status' => $status,
            'data' => $data,
            'time' => (new DateTime())->format(DateTimeInterface::RFC3339),
        ];

        parent::__construct($data, $status, $headers);
    }
}