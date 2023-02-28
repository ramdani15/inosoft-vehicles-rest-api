<?php

namespace App\Http\Repositories\Api\V1;

use App\Http\Resources\Api\V1\VehicleResource;
use App\Traits\ApiFilterTrait;
use Facades\App\Models\Vehicle;

class VehicleRepository extends BaseRepository
{
    use ApiFilterTrait;

    /**
     * Search Vehicles
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Http\Resources\Api\V1\VehicleResource
     */
    public function searchVehicles($request)
    {
        $limit = $request->limit ?? 10;
        $data = Vehicle::query();
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

        return VehicleResource::collection($data);
    }
}
