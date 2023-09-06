<?php

namespace App\Enum;

enum RequestStatusEnum: int
{
    use EnumToArray;

    case SENT = 83;

    case ACCEPT = 84;

    case FINANCIAL = 86;

    case REJECT = 88;

    case BLOCK = 89;

    case ASSIGN_TO_BUYER = 94;

    case SUPPLY = 95;

    case INCOMPLETE_SUPPLY = 97;

    case ACCEPT_FINANCIAL = 110;

    case FIRST_ACCEPT = 120;
}
