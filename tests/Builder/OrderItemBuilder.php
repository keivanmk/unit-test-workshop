<?php

namespace Tests\Builder;

use App\Order\OrderItem;
use Illuminate\Foundation\Testing\WithFaker;

class OrderItemBuilder
{
    use WithFaker;

    private string $title;
    private int $price;
    private int $quantity;

    private function __construct(
        string $title,
               $price,
               $quantity
    )
    {
        $this->title=$title;
        $this->price=$price;
        $this->quantity=$quantity;
    }

    public function withTitle(string $title):OrderItemBuilder
    {
        $this->title = $title;
        return $this;
    }

    public function withPrice(int $price):OrderItemBuilder
    {
        $this->price = $price;
        return $this;
    }

    public function withQuantity(int $quantity):OrderItemBuilder
    {
        $this->quantity = $quantity;
        return $this;
    }

    public static function anOrderItem():OrderItemBuilder
    {
        return new OrderItemBuilder(
            "Order Item 1",
            1_000_000,
            1
        );
    }

    public function build():OrderItem
    {
        return new OrderItem(
            $this->title,
            $this->price,
            $this->quantity);
    }

}
