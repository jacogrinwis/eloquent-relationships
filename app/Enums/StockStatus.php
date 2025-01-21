<?php

namespace App\Enums;

enum StockStatus: int
{
    case InStock = 1;
    case OutOfStock = 2;
    case BackOrder = 3;

    public function label(): string
    {
        return match ($this) {
            self::InStock => 'In voorraad',
            self::OutOfStock => 'Uitverkocht',
            self::BackOrder => 'Nabestelling'
        };
    }
}
