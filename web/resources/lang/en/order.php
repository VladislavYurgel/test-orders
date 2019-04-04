<?php

return [
    'error' => [
        'add_good' => 'An error occurred when adding good',
        'incorrect_goods_structure' => 'Goods structure is incorrect',
        'change_status' => 'An error occurred when changing status',
        'add_order_error_incorrect_status' =>
            'An error occurred when adding the good to the order, order status is incorrect',
        'specified_status_is_not_available' =>
            'Specified status it not available for this order',
        'is_not_exists' => 'Order is not exists',
    ],
    'statuses' => [
        'created' => 'Created',
        'processed' => 'Processed',
        'courier' => 'On courier',
        'completed' => 'Completed',
        'canceled' => 'Canceled',
    ],
    'change_status_success' => 'Order status was successfully changed',
    'good_added_success' => 'Good was successfully added to the order',
];
