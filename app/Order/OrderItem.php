<?php

namespace App\Order;

readonly class OrderItem
{

    public function __construct(
        public string $title,
        public int    $price,
        public int    $quantity
    )
    {
    }

    public function subTotal():int
    {
        return $this->price * $this->quantity;
    }


}
