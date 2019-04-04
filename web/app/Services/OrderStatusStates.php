<?php

namespace App\Services;

use App\Models\Order;

class OrderStatusStates
{
    private static $transitions = [
        Order::STATUS_CREATED => [
            'from' => [null, 0],
            'to' => [Order::STATUS_PROCESSED, Order::STATUS_CANCELED],
        ],
        Order::STATUS_PROCESSED => [
            'from' => [Order::STATUS_CREATED],
            'to' => [Order::STATUS_COURIER, Order::STATUS_CANCELED],
        ],
        Order::STATUS_COURIER => [
            'from' => [Order::STATUS_PROCESSED],
            'to' => [Order::STATUS_COMPLETED, Order::STATUS_CANCELED],
        ],
        Order::STATUS_COMPLETED => [
            'from' => [Order::STATUS_COURIER],
            'to' => [],
        ],
        Order::STATUS_CANCELED => [
            'from' => [Order::STATUS_CREATED, Order::STATUS_PROCESSED, Order::STATUS_COURIER],
            'to' => [],
        ],
    ];

    /**
     * Check for availability the specified statuses
     *
     * @param Order $order
     * @param int $status
     * @return bool
     */
    public static function can(Order $order, int $status): bool
    {
        if (!isset(static::$transitions[$order->status], static::$transitions[$status])) {
            return false;
        }

        return in_array($order->status ?? null, static::$transitions[$status]['from'])
            && in_array($status, static::$transitions[$order->status]['to']);
    }
}
