<?php

namespace App\Http\Controllers\Api;

use App\Repositories\GoodRepository;
use App\Repositories\UserOrderRepository;
use App\Http\Requests\Api\AddGoodsToTheOrderRequest;
use App\Http\Requests\Api\ChangeOrderStatusRequest;
use App\Services\ResponseApi\Contracts\ResponseApiInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class UserOrderController extends BaseApiController
{
    /**
     * @var UserOrderRepository
     */
    private $userOrderRepository;

    /**
     * @var GoodRepository
     */
    private $goodRepository;

    public function __construct(
        ResponseApiInterface $responseApi,
        UserOrderRepository $userOrderRepository,
        GoodRepository $goodRepository
    ) {
        parent::__construct($responseApi);

        $this->userOrderRepository = $userOrderRepository;
        $this->goodRepository = $goodRepository;
    }

    /**
     * @param AddGoodsToTheOrderRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addGoodsToTheOrder(AddGoodsToTheOrderRequest $request): JsonResponse
    {
        try {
            $this->userOrderRepository->addGoodsToTheUserOrderByIds($this->user(), $request->goods);
        } catch (\Exception $exception) {
            return $this->response->error(Arr::wrap($exception->getMessage()));
        }

        return $this->response->success([trans('order.good_added_success')]);
    }

    /**
     * @param ChangeOrderStatusRequest $request
     * @return JsonResponse
     */
    public function changeOrderStatus(ChangeOrderStatusRequest $request)
    {
        try {
            $this->userOrderRepository->changeUserOrderStatus($this->user(), $request->status);
        } catch (\Throwable $exception) {
            return $this->response->error(Arr::wrap($exception->getMessage()));
        }

        return $this->response->success([trans('order.change_status_success')]);
    }
}
