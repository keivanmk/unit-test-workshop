<?php

namespace App\Product;


use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class ProductId
{

    private function __construct(private readonly string $value)
    {
        if (!Str::isUuid($this->value)) {
            throw new \InvalidArgumentException("The Product Id is not valid!");
        }
    }

    public static function fromUUID(string $uuid): self
    {
        return new ProductId(Uuid::fromString($uuid));
    }

    public static function newId():ProductId
    {
        return new ProductId(Str::uuid());
    }

    public function equals(ProductId $productId): bool
    {
        return $this->value === $productId->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
