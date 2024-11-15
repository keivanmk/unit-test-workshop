<?php

namespace Tests\Builder;

use App\Product\Product;
use App\Product\ProductId;
use Illuminate\Foundation\Testing\WithFaker;

class ProductBuilder
{
    use WithFaker;
    private function __construct(
        public ProductId $productId,
        public  string $title,
        public  int $price,
        public  int $quantity,
        public  string $category
    ){

    }

    public function withTitle(string $title):self
    {
        $this->title=$title;
        return $this;
    }

    public function withPrice(int $price):self
    {
        $this->price= $price;
        return $this;
    }

    public function withCategory(string $category):self
    {
        $this->category= $category;
        return $this;
    }

    public function withQuantity(int $quantity):self
    {
        $this->quantity= $quantity;
        return $this;
    }


    public static function aProduct():ProductBuilder
    {
        return new ProductBuilder(
            ProductId::newId(),
            "Sample Product",
            1_000_000,
            10,
            "Category"
        );
    }

    public function build():Product
    {
        return new Product(
            $this->productId,
            $this->title,
            $this->price,
            $this->quantity,
            $this->category
        );
    }


}
