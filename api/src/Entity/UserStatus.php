<?php

namespace App\Entity;

enum UserStatus: string
{
    case OK = 'ok';
    case LOCKED = 'locked';
    case BANNED = 'banned';
}