<?php

namespace App\Enums;

enum Role: int
{
    case Customer = 0;
    case Editor  = 1;
    case Admin = 2;
}
