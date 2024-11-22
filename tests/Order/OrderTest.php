<?php

namespace Order;

use App\Order\Order;
use App\Order\OrderItem;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Builder\OrderItemBuilder;
use Tests\TestCase;

class OrderTest extends  TestCase
{
    use WithFaker;

    /** @test */
    public function placing_an_order(): void
    {
        //arrange
        $orderItem = OrderItemBuilder::anOrderItem()->build();

        //act
        $sut = Order::place([$orderItem]);

        //assert
        $this->assertInstanceOf(Order::class,$sut);

    }

    /** @test */
    public function calculating_order_total_price(): void
    {
        //arrange
        $firstOrderItem = OrderItemBuilder::anOrderItem()
            ->withQuantity(2)
            ->withPrice(1_500_000)
            ->build();
        $secondOrderItem = OrderItemBuilder::anOrderItem()
            ->withQuantity(3)
            ->withPrice(300_000)
            ->build();
        $sut = Order::place([$firstOrderItem,$secondOrderItem]);
        $expectedTotalPrice = 3_900_000;

        //act
        $totalPrice = $sut->totalPrice();

        //assert
        $this->assertEquals($expectedTotalPrice,$totalPrice);


    }

    /** @test */
    public function order_placed_in_pending_status(): void
    {
        //arrange
        $orderItem = OrderItemBuilder::anOrderItem()->build();

        //act
        $sut = Order::place([$orderItem]);

        //assert
        $this->assertTrue($sut->isPending());
    }

    /** @test */
    public function approving_order(): void
    {
        //arrange
        $orderItem = OrderItemBuilder::anOrderItem()->build();
        $sut = Order::place([$orderItem]);

        //act
        $sut->approve();

        //assert
        $this->assertTrue($sut->isApproved());

    }

    /** @test */
    public function canceling_order(): void
    {
        //arrange
        $orderItem = OrderItemBuilder::anOrderItem()->build();
        $sut = Order::place([$orderItem]);

        //act
        $sut->cancel();

        //assert
        $this->assertTrue($sut->isCanceled());
    }

    /** @test */
    public function its_not_possible_to_approve_a_canceled_order(): void
    {
        //arrange
        $orderItem = OrderItemBuilder::anOrderItem()->build();
        $sut = Order::place([$orderItem]);
        $sut->cancel();

        //assert
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(Order::CANCEL_TO_APPROVED_ERROR);

        //act
        $sut->approve();

    }
}
