<?php

namespace App\Basket;

use App\Coupon\Coupon;
use App\Product\Product;
use Illuminate\Support\Collection;

class Basket
{
    public const string PRODUCT_NOT_FOUND_ERR_MESSAGE = "محصول مورد نظر یافت نشد.";

    private Collection $items;

    private Coupon $appliedCoupon;

    public function __construct()
    {
        $this->items= collect([]);
    }

    public function addProduct(Product $product):void
    {
        if($this->items->has((string)$product->productId))
        {
            $basketItem = $this->items->get((string)$product->productId);
            $basketItem['quantity']++;
            $this->items = $this->items->put((string)$product->productId,$basketItem);
            return;
        }
        $this->items->put((string)$product->productId,['quantity' => 1,'product' => $product]);
    }

    public function itemsCount(): int
    {
        return $this->items->count();
    }

    public function totalPrice():int
    {

        $totalPrice =  $this->items->reduce(fn(int $total,array $basketItem) =>
        $total+= $basketItem['product']->price() * $basketItem['quantity'],0);
        if(empty($this->appliedCoupon))
        {
            return $totalPrice;
        }

        return $totalPrice *  (1 - ($this->appliedCoupon->couponPercent()/100));
    }

    public function removeProduct(Product $product):void
    {
        $this->items = $this->items->forget($product->productId);
    }

    public function decreaseProductQuantity(Product $product):void
    {
        if(!$this->items->has((string)$product->productId))
        {
           throw new \RuntimeException(self::PRODUCT_NOT_FOUND_ERR_MESSAGE);
        }
        $basketItem = $this->items->get((string)$product->productId);
        if($basketItem['quantity'] === 1)
        {
            $this->removeProduct($product);
            return;
        }
        $basketItem['quantity']--;
        $this->items = $this->items->put((string)$product->productId,$basketItem);
    }

    public function delete():void
    {
        $this->items = collect([]);
    }

    public function applyCoupon(Coupon $coupon):void
    {
        $this->appliedCoupon = $coupon;
    }
}
