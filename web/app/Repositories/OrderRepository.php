<?php

namespace App\Repositories;

use App\Events\ChangeOrderEvent;
use App\Exceptions\AddGoodToTheOrderException;
use App\Exceptions\ChangeOrderStatusException;
use App\Models\Good;
use App\Models\Order;
use App\Models\OrderGood;
use App\Services\OrderStatusStates;

class OrderRepository
{
    /**
     * @param Order $order
     * @param Good $good
     * @param int $quantity
     * @return Order
     */
    public function addGoodToTheOrder(Order $order, Good $good, int $quantity = 1): Order
    {
        // If specified good is already exists in the order
        // then we need to just increment the quantity of the good.
        // Otherwise we need to add a new good to the order with specified quantity
        $existingGoodInOrder = OrderGood::whereOrderId($order->id)->whereGoodId($good->id)->first();

        $existingGoodInOrder
            ? $existingGoodInOrder->increment('quantity', $quantity)
            : $order->goods()->attach($good->id, ['quantity' => $quantity]);

        event(new ChangeOrderEvent($order));

        return $order;
    }

    /**
     * @param Order $order
     * @param array $goods
     * @return Order
     * @throws AddGoodToTheOrderException
     */
    public function addGoodsToTheOrderByArray(Order $order, array $goods): Order
    {
        $this->checkAvailabilityToAddTheGoodToTheOrder($order);

        foreach ($goods as $good) {
            $this->checkValidityOfTheGoodStructure($good);
            $goodInstance = Good::findOrFail($good['id'] ?? $good);
            $this->addGoodToTheOrder($order, $goodInstance, $good['quantity'] ?? 1);
        }

        return $order;
    }

    /**
     * @param Order $order
     * @param int $status
     * @return bool
     * @throws ChangeOrderStatusException
     */
    public function changeOrderStatus(Order $order, int $status): bool
    {
        if (OrderStatusStates::can($order, $status)) {
            return $order->update(['status' => $status]);
        }

        throw new ChangeOrderStatusException();
    }

    /**
     * @param Order $order
     * @return bool
     */
    public function recalculateAmountOfTheOrder(Order $order): bool
    {
        if ($order->status === Order::STATUS_CREATED) {
            $amount = OrderGood::whereOrderId($order->id)->get()->sum(function (OrderGood $orderGood) {
                return $orderGood->good->price * $orderGood->quantity;
            });

            return $order->update(['amount' => $amount]);
        }

        return false;
    }

    /**
     * @param Order $order
     * @return bool
     * @throws AddGoodToTheOrderException
     */
    private function checkAvailabilityToAddTheGoodToTheOrder(Order $order): bool
    {
        if ($order->status !== Order::STATUS_CREATED) {
            throw new AddGoodToTheOrderException(trans('order.error.add_order_error_incorrect_status'));
        }

        return true;
    }

    /**
     * @param $good
     * @return bool
     * @throws AddGoodToTheOrderException
     */
    private function checkValidityOfTheGoodStructure($good): bool
    {
        if (!isset($good['id']) && is_array($good)) {
            throw new AddGoodToTheOrderException(trans('order.error.incorrect_goods_structure'));
        }

        return true;
    }
}
