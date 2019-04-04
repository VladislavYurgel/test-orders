<?php

namespace Tests\TestData;

trait GoodsTestData
{
    public static $good1 = [
        'id' => 1,
        'title' => 'Test title for the first good',
        'description' => 'A little test description for the first good',
        'price' => 15.00,
    ];

    public static $good2 = [
        'id' => 2,
        'title' => 'Test title for the second good',
        'description' => 'A little test description for the second good',
        'price' => 17.50,
    ];

    public static $good3 = [
        'id' => 3,
        'title' => 'Test title for the third good',
        'description' => 'A little test description for the third good',
        'price' => 19.25,
    ];

    public static $good4 = [
        'id' => 4,
        'title' => 'Test title for the fourth good',
        'description' => 'A little test description for the fourth good',
        'price' => 20.25,
    ];

    public static $goodsForAdding = [
        [
            'id' => 1,
            'quantity' => 1,
        ],
        [
            'id' => 2,
            'quantity' => 2,
        ],
        [
            'id' => 3,
            'quantity' => 3,
        ],
    ];

    public static function getGoodsData(): array
    {
        return [
            self::$good1,
            self::$good2,
            self::$good3,
            self::$good4,
        ];
    }
}
