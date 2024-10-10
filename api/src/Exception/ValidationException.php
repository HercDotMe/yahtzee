<?php

namespace App\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationException extends Exception
{
    public function __construct(ConstraintViolationListInterface $violations)
    {
        $data = [];

        foreach ($violations as $violation) {
            $message = $violation->getMessage();
            $property = $violation->getPropertyPath();

            $data[$property] = $message;
        }

        parent::__construct(json_encode($data));
    }
}
