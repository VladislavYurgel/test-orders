<?php

namespace App\Repositories;

use App\Exceptions\OrderIsNotExistsException;
use App\Models\Order;
use App\Models\User;

class UserOrderRepository
{
    /**
     * @param User $user
     * @return Order
     * @throws \Throwable|OrderIsNotExistsException
     */
    public function getUserOrder(User $user): Order
    {
        throw_if(!$order = $user->orders()->active()->first(), new OrderIsNotExistsException());

        return $order;
    }

    /**
     * @param User $user
     * @return Order
     */
    public function createUserOrder(User $user): Order
    {
        return $user->orders()->create(['status' => Order::STATUS_CREATED]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Model|Order
     */
    public function getUserOrderOrCreate(User $user): Order
    {
        try {
            return $this->getUserOrder($user);
        } catch (\Throwable|OrderIsNotExistsException $exception) {
            return $this->createUserOrder($user);
        }
    }

    /**
     * @param User $user
     * @param array $goods
     * @return Order
     * @throws \App\Exceptions\AddGoodToTheOrderException
     */
    public function addGoodsToTheUserOrderByIds(User $user, array $goods): Order
    {
        $order = $this->getUserOrderOrCreate($user);

        return app(OrderRepository::class)->addGoodsToTheOrderByArray($order, $goods);
    }

    /**
     * @param User $user
     * @param int $status
     * @return bool
     * @throws \Throwable|\App\Exceptions\ChangeOrderStatusException
     */
    public function changeUserOrderStatus(User $user, int $status): bool
    {
        $order = $this->getUserOrder($user);

        return app(OrderRepository::class)->changeOrderStatus($order, $status);
    }
}
