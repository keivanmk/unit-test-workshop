<?php

namespace Product;

use App\Models\User;
use App\Product\Product;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductTest extends TestCase
{

    use WithFaker;

    /** @test */
    public function define_a_product(): void
    {

        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100000, 20000000);
        $quantity = $this->faker->numberBetween(10, 100);
        $category = $this->faker->word();

        //act
        $sut = new Product($title, $price, $quantity, $category);

        //assert
        $this->assertEquals($title, $sut->title);
        $this->assertEquals($price, $sut->price);
        $this->assertEquals($quantity, $sut->quantity);
        $this->assertEquals($category, $sut->category);

    }

    /** @test */
    public function not_possible_to_define_a_product_with_negative_price(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = -1_000_000;
        $quantity = $this->faker->numberBetween(10, 100);
        $category = $this->faker->word();

        try {
            //act
            $sut = new Product($title, $price, $quantity, $category);
        } catch (\Exception $exception) {
            //assert
            $this->assertInstanceOf(\InvalidArgumentException::class,$exception);
            $this->assertEquals(Product::INVALID_PRICE_MESSAGE,$exception->getMessage());
        }

    }

    /** @test */
    public function not_possible_to_define_a_product_with_negative_quantity(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = 1_000_000;
        $quantity = -10;
        $category = $this->faker->word();

        try {
            //act
            $sut = new Product($title, $price, $quantity, $category);
        } catch (\Exception $exception) {
            //assert
            $this->assertInstanceOf(\InvalidArgumentException::class,$exception);
            $this->assertEquals(Product::INVALID_QUANTITY_MESSAGE,$exception->getMessage());
        }

    }

    /**
     * @test
     * @dataProvider priceList
     */
    public function changing_price(int $newPrice): void
    {
        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000, 500_000);
        $quantity = $this->faker->numberBetween(10, 100);
        $category = $this->faker->word();
        $sut = new Product($title, $price, $quantity, $category);

        //$user = User::factory()->make(); // example

        //act
        $sut->changePrice($newPrice);

        //assert
        $this->assertEquals($newPrice,$sut->price);

    }

    /** @test */
    public function its_not_possible_to_change_price_with_negative_price(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000, 500_000);
        $quantity = $this->faker->numberBetween(10, 100);
        $category = $this->faker->word();
        $sut = new Product($title, $price, $quantity, $category);
        $newPrice = -2_000_000;

        //act
        try {
            $sut->changePrice($newPrice);
        }catch (\Exception $exception)
        {
            //assert
            $this->assertInstanceOf(\InvalidArgumentException::class,$exception);
            $this->assertEquals(Product::INVALID_PRICE_MESSAGE,$exception->getMessage());
        }


    }

    /**
     * @test
     * @dataProvider quantityList
     */
    public function changing_quantity(int $newQuantity): void
    {
        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000, 500_000);
        $quantity = $this->faker->numberBetween(10, 20);
        $category = $this->faker->word();
        $sut = new Product($title, $price, $quantity, $category);

        //act
        $sut->changeQuantity($newQuantity);

        //assert
        $this->assertEquals($newQuantity,$sut->quantity);
    }

    /** @test */
    public function its_not_possible_to_change_quantity_with_negative_value(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000, 500_000);
        $quantity = $this->faker->numberBetween(10, 20);
        $category = $this->faker->word();
        $sut = new Product($title, $price, $quantity, $category);
        $newQuantity = -10;

        //assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_QUANTITY_MESSAGE);

        //act
        $sut->changeQuantity($newQuantity);
    }

    /** @test */
    public function changing_title(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000, 500_000);
        $quantity = $this->faker->numberBetween(10, 20);
        $category = $this->faker->word();
        $sut = new Product($title, $price, $quantity, $category);
        $newTitle = $this->faker->sentence(50);

        //act
        $sut->changeTitle($newTitle);

        //assert
        $this->assertEquals($newTitle,$sut->title);
    }

    /** @test */
    public function empty_title_is_not_allowed(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000, 500_000);
        $quantity = $this->faker->numberBetween(10, 20);
        $category = $this->faker->word();
        $sut = new Product($title, $price, $quantity, $category);
        $newTitle = "";


        //assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_TITLE_MESSAGE);

        //act
        $sut->changeTitle($newTitle);
    }

    /** @test */
    public function title_with_length_lower_than_50_chars_is_not_allowed(): void
    {
        //arrange
        $title = $this->faker->word();
        $price = $this->faker->numberBetween(100_000, 500_000);
        $quantity = $this->faker->numberBetween(10, 20);
        $category = $this->faker->word();
        $sut = new Product($title, $price, $quantity, $category);
        $newTitle = $this->faker->word();


        //assert
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(Product::INVALID_TITLE_LENGTH_MESSAGE);

        //act
        $sut->changeTitle($newTitle);
    }

    /** @return array<int> */
    public static function priceList():array
    {
        return [
            'مقدار یک میلیون تومان' => [1_000_000],
            'مقدار صفر' => [0]
        ];
    }

    /** @return array<int> */
    public static function quantityList():array
    {
        return [
            'تعداد 60' => [60],
            'تعداد صفر' => [0]
        ];
    }
}
