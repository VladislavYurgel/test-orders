<?php

namespace Tests\Unit\App\Repositories;

use App\Exceptions\AddGoodToTheOrderException;
use App\Exceptions\ChangeOrderStatusException;
use App\Exceptions\OrderIsNotExistsException;
use App\Models\Order;
use App\Models\User;
use App\Repositories\OrderRepository;
use App\Repositories\UserOrderRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\TestConstants;

class UserOrderRepositoryTest extends TestCase
{
    use TestConstants, DatabaseTransactions;

    public function testGetUserOrderWhenThrowAnException()
    {
        $user = $this->getUser1();

        try {
            app(UserOrderRepository::class)->getUserOrder($user);
        } catch (\Throwable $exception) {
            $this->assertTrue($exception instanceof OrderIsNotExistsException);
            $this->assertEquals($exception->getMessage(), OrderIsNotExistsException::getDefaultMessage());
        }
    }

    public function testGetUserOrderWhenOrderIsReceived()
    {
        $user = $this->getUser1();

        $needleOrder = $this->createOrderForUser($user);
        $actualOrder = app(UserOrderRepository::class)->getUserOrder($user);

        $this->assertTrue($actualOrder instanceof Order);
        $this->assertEquals($needleOrder->id, $actualOrder->id);
    }

    public function testGetUserOrderOrCreate()
    {
        $user = $this->getUser1();

        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id,
        ]);

        $createdOrder = app(UserOrderRepository::class)->getUserOrderOrCreate($user);

        $this->assertTrue($createdOrder instanceof Order);
        $this->assertEquals($createdOrder->user_id, $user->id);

        $receivedOrder = app(UserOrderRepository::class)->getUserOrderOrCreate($user);

        $this->assertTrue($receivedOrder instanceof Order);
        $this->assertEquals($receivedOrder->toArray(), $receivedOrder->toArray());
    }

    public function testGoodsToTheUserOrderByIdsCase1()
    {
        list($user, $goods) = [$this->getUser1(), self::$goodsForAdding];

        $result = app(UserOrderRepository::class)->addGoodsToTheUserOrderByIds($user, $goods);

        $this->assertTrue($result instanceof Order);
    }

    public function testGoodsToTheUserOrderByIdsCase2()
    {
        list($user, $goods) = [$this->getUser1(), self::$goodsForAdding];

        $result = app(UserOrderRepository::class)->addGoodsToTheUserOrderByIds($user, $goods);

        $this->assertTrue($result instanceof Order);

        app(OrderRepository::class)->changeOrderStatus($result, Order::STATUS_PROCESSED);

        try {
            $result = app(UserOrderRepository::class)->addGoodsToTheUserOrderByIds($user, $goods);
        } catch (\Throwable $exception) {
            $catchedException = $exception;
        }

        $this->assertTrue(isset($catchedException) && $catchedException instanceof AddGoodToTheOrderException);
    }

    public function testChangeUserOrderStatusCase1()
    {
        $user = $this->getUser1();

        $this->createOrderForUser($user);

        $result = app(UserOrderRepository::class)->changeUserOrderStatus($user, Order::STATUS_PROCESSED);

        $this->assertTrue($result);

        try {
            app(UserOrderRepository::class)->changeUserOrderStatus($user, Order::STATUS_COMPLETED);
        } catch (\Throwable $exception) {
            $catchedException = $exception;
        }

        $this->assertTrue(isset($catchedException) && $catchedException instanceof ChangeOrderStatusException);
    }

    public function testCreateUserOrder()
    {
        $this->createOrderForUser($this->getUser1());
    }

    /**
     * @return User
     */
    private function getUser1(): User
    {
        return \Auth::loginUsingId(self::$user1['id']);
    }

    /**
     * @param User $user
     * @return Order
     */
    private function createOrderForUser(User $user): Order
    {
        $order = app(UserOrderRepository::class)->createUserOrder($user);

        $this->assertTrue($order instanceof Order);
        $this->assertEquals($order->user_id, $user->id);

        return $order;
    }
}
