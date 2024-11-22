<?php

namespace App\Coupon;

readonly class Coupon
{

    public function __construct(
        private string $couponCode,
        private int    $couponPercent
    )
    {
        if($this->couponPercent < 1 && $this->couponPercent > 100)
        {
            throw new \InvalidArgumentException("مقدار درصد کد تخفیف معتبر نمی باشد");
        }
    }

    public function couponPercent():int
    {
        return $this->couponPercent;
    }


}
