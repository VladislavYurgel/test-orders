<?php

namespace App\Helpers\Lists;

use App\Helpers\Lists\Base\TextList;
use App\Models\Order;

class OrderStatusesList extends TextList
{
    /**
     * @return array
     */
    public static function getList(): array
    {
        return [
            Order::STATUS_CREATED => trans('order.statuses.created'),
            Order::STATUS_PROCESSED => trans('order.statuses.processed'),
            Order::STATUS_COURIER => trans('order.statuses.courier'),
            Order::STATUS_COMPLETED => trans('order.statuses.completed'),
            Order::STATUS_CANCELED => trans('order.statuses.canceled'),
        ];
    }
}
