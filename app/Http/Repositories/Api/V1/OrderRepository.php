<?php

namespace App\Http\Repositories\Api\V1;

use App\Http\Resources\Api\V1\OrderResource;
use App\Traits\ApiFilterTrait;
use Facades\App\Models\Order;
use Facades\App\Models\Vehicle;
use Illuminate\Support\Facades\Log;

class OrderRepository extends BaseRepository
{
    use ApiFilterTrait;

    protected $orderable = [
        'Vehicle' => Vehicle::class,
    ];

    /**
     * Search Orders
     *
     * @param  Illuminate\Http\Request  $request
     * @return App\Http\Resources\Api\V1\OrderResource
     */
    public function searchOrders($request)
    {
        $limit = $request->limit ?? 10;
        $data = Order::whereUserId(auth()->id());
        $filters = [
            [
                'field' => 'name',
                'value' => $request->name,
                'query' => 'like',
            ],
            [
                'field' => 'color',
                'value' => $request->color,
                'query' => 'like',
            ],
            [
                'field' => 'price',
                'value' => $request->price,
                'query' => 'like',
            ],
        ];
        $data = $this->filterFields($data, $filters);
        $data = $this->setOrder($data, ['created_at', '-1']);
        $data = $data->paginate($limit);

        return OrderResource::collection($data);
    }

    /**
     * Check order item vailable
     *
     * @param  array  $data
     * @return array
     */
    public function checkOrderItemAvailable($data)
    {
        try {
            if (! isset($this->orderable[$data['orderable_type']])) {
                return $this->setResponseError(__('Orderable not available'));
            }

            $item = $this->orderable[$data['orderable_type']]::find($data['orderable_id']);
            if (! $item) {
                return $this->setResponseError(__('Item not found'));
            }

            if ($item->stock - $data['quantity'] < 0) {
                return $this->setResponseError(__('Stock not enough'));
            }

            return $this->setResponseSuccess(__('Item available'), $item);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);

            return $this->setResponseError(__('Item not available'), $th->getMessage());
        }
    }

    /**
     * Create Order
     *
     * @param  array  $data
     * @return array
     */
    public function createOrder($data)
    {
        $checkOrder = $this->checkOrderItemAvailable($data);

        if (! $checkOrder['status']) {
            return $this->setResponseError($checkOrder['message'], $checkOrder['data'] ?? null);
        }

        try {
            $item = $checkOrder['data'];

            // Create Order
            $data['total_price'] = $item->price * $data['quantity'];
            $data['user_id'] = auth()->id();
            $order = Order::create($data);

            // Reduce item stock
            $orderable = $order->orderable;
            $orderable->stock -= $order->quantity;
            $orderable->save();

            $data = new OrderResource($order);

            return $this->setResponseSuccess(__('Create order successfully'), $data);
        } catch (\Throwable $th) {
            //throw $th;
            Log::error($th);

            return $this->setResponseError(__('Create order failed'), $th->getMessage());
        }
    }
}
