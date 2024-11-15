<?php

namespace App\Product;

class Product
{
    public const  INVALID_PRICE_MESSAGE = "قیمت محصول نمی تواند کمتر از صفر باشد";

    public const  INVALID_QUANTITY_MESSAGE = "موجودی محصول نمی تواند کمتر از صفر باشد";

    public const INVALID_TITLE_MESSAGE = "عنوان محصول نمی تواند خالی باشد";

    public const INVALID_TITLE_LENGTH_MESSAGE = "عنوان محصول نمی تواند کوچکتر از 50 کاراکتر باشد";

    public const MIN_ALLOWED_TITLE_LENGTH = 50;

    public function __construct(
        public ProductId $productId,
        public  string $title,
        public  int $price,
        public  int $quantity,
        public  string $category
    )
    {
        if($this->price < 0)
        {
            throw new \InvalidArgumentException(self::INVALID_PRICE_MESSAGE);
        }
        if($this->quantity < 0)
        {
            throw new \InvalidArgumentException(self::INVALID_QUANTITY_MESSAGE);
        }
    }

    public function changePrice(int $newPrice):void
    {
        if($newPrice < 0)
        {
            throw new \InvalidArgumentException(self::INVALID_PRICE_MESSAGE);
        }
        $this->price = $newPrice;
    }

    public function markAsFree():void
    {
        $this->changePrice(0);
    }

    public function changeQuantity(int $newQuantity):void
    {
        if($newQuantity < 0)
        {
            throw new \InvalidArgumentException(self::INVALID_QUANTITY_MESSAGE);
        }
        $this->quantity = $newQuantity;
    }

    public function decreaseQuantityByOne():void
    {
        $this->changeQuantity($this->quantity - 1);
    }

    public function IncreaseQuantityByOne():void
    {
        $this->changeQuantity($this->quantity + 1);
    }

    public function changeTitle(string $newTitle):void
    {
        if(empty($newTitle))
        {
            throw new \InvalidArgumentException(self::INVALID_TITLE_MESSAGE);
        }
        if(mb_strlen($newTitle) < self::MIN_ALLOWED_TITLE_LENGTH)
        {
            throw new \InvalidArgumentException(self::INVALID_TITLE_LENGTH_MESSAGE);
        }
        $this->title = $newTitle;
    }

    public function soldOut():void
    {
        $this->changeQuantity(0);
    }

    public function price():int
    {
        return $this->price;
    }
}
