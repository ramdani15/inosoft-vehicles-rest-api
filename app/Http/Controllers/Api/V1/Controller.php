<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * @OA\Info(
     *     version="1.0.0",
     *     title="API Swagger Documentation",
     * )
     *
     * @OA\SecurityScheme(
     *   securityScheme="token",
     *   type="http",
     *   scheme="bearer",
     *   bearerFormat="JWT"
     * )
     */
    private function swagger()
    {
        return null;
    }
}
