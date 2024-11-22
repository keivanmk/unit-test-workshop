<?php

namespace App\Order;

use Illuminate\Support\Collection;

class Order
{
    public const string CANCEL_TO_APPROVED_ERROR = "تایید سفارش کنسل شده امکان پذیر نمی باشد.";

    private OrderStatus $status;

    private function __construct(private Collection $orderItems)
    {
        $this->status = OrderStatus::PENDING;
    }

    public static function place(array $orderItems):Order
    {
        return new Order(collect($orderItems));
    }

    public function totalPrice():int
    {
        return $this->orderItems->reduce(fn($total,OrderItem $item)=>
            $total+= $item->subTotal(),0);
    }

    public function isPending():bool
    {
        return $this->status === OrderStatus::PENDING;
    }

    public function approve():void
    {
        if($this->isCanceled())
        {
            throw new \RuntimeException(self::CANCEL_TO_APPROVED_ERROR);
        }
        $this->status = OrderStatus::APPROVED;
    }

    public function isApproved():bool
    {
        return $this->status===OrderStatus::APPROVED;
    }

    public function cancel():void
    {
        $this->status = OrderStatus::CANCELED;
    }

    public function isCanceled():bool
    {
        return $this->status===OrderStatus::CANCELED;
    }

}
