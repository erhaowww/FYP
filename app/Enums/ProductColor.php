<?php

namespace App\Enums;

enum ProductColor: string
{
    case Black = 'black';
    case White = 'white';
    case Green = 'green';
    case Blue = 'blue';
    case Red = 'red';
    case Other = 'other';

    public function colorCode(): string
    {
        return match($this) {
            self::Black => '#000000',
            self::White => '#FFFFFF',
            self::Green => '#008000',
            self::Blue => '#0000FF',
            self::Red => '#FF0000',
            self::Other => 'linear-gradient(90deg, #FFFF00, #EE82EE)', // Assuming 'Other' is a gradient.
        };
    }

    public function label(): string {
        return ucwords($this->value);
    }
    
}
