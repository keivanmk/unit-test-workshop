<?php

namespace Basket;

use App\Basket\Basket;
use RuntimeException;
use Tests\Builder\ProductBuilder;
use Tests\TestCase;

class BasketTest extends TestCase
{
    /** @test */
    public function adding_product(): void
    {

        //arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();

        //act
        $sut->addProduct($product);

        //assert
        $this->assertEquals(1,$sut->itemsCount());

    }

    /** @test */
    public function calculate_total_price(): void
    {

        //arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);

        //act
        $totalPrice = $sut->totalPrice();

        //arrange
        $this->assertEquals($product->price(),$totalPrice);

    }

    /** @test */
    public function remove_product(): void
    {
        //arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);

        //sut
        $sut->removeProduct($product);

        //assert
        $this->assertEquals(0,$sut->itemsCount());

    }

    /** @test */
    public function add_a_duplicate_product_increases_quantity(): void
    {
        //arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);
        $expectedQuantity = 2;

        //act
        $sut->addProduct($product);

        //assert
        $this->assertEquals(1,$sut->itemsCount());
        $this->assertEquals($product->price() * 2,$sut->totalPrice());
    }

    /** @test */
    public function decreasing_product_quantity(): void
    {
        //arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);
        $sut->addProduct($product);

        //act
        $sut->decreaseProductQuantity($product);

        //assert
        $this->assertEquals($product->price(),$sut->totalPrice());

    }

    /** @test */
    public function its_not_possible_to_decrease_product_quantity_when_it_does_not_exists_in_the_basket(): void
    {
        //arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();

        //assert
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(Basket::PRODUCT_NOT_FOUND_ERR_MESSAGE);

        //act
        $sut->decreaseProductQuantity($product);

    }

    /** @test */
    public function deleting_basket(): void
    {
        //arrange
        $product = ProductBuilder::aProduct()->build();
        $sut = new Basket();
        $sut->addProduct($product);

        //act
        $sut->delete();

        //assert
        $this->assertEquals(0,$sut->itemsCount());
    }
}
