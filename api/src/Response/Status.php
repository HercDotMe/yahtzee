<?php

namespace App\Response;

enum Status: string
{
    case SUCCESS = 'success';
    case UNAUTHORIZED = 'unauthorized';
    case BAD_REQUEST = 'bad_request';
    case ERROR = 'error';
}