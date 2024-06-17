<?php

namespace App\Response;

use DateTime;
use DateTimeInterface;

class JsonResponse extends \Symfony\Component\HttpFoundation\JsonResponse
{
    public function __construct($data, Status $status, $headers = [])
    {
        $data = [
            'status' => $status,
            'data' => $data,
            'time' => (new DateTime())->format(DateTime::RFC3339),
        ];

        $code = null;
        switch ($status)
        {
            case Status::SUCCESS:
                $code = 200;
                break;

            case Status::BAD_REQUEST:
                $code = 400;
                break;

            case Status::UNAUTHORIZED:
                $code = 403;
                break;

            case Status::ERROR:
                $code = 500;
                break;
        }

        parent::__construct($data, $code, $headers);
    }
}