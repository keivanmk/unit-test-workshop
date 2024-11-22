<?php

namespace App\Order;

enum OrderStatus
{
    case PENDING;

    case APPROVED;

    case CANCELED;
}
