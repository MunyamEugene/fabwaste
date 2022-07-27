<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;



/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="fabwaste api documentation",
 *      description="API Documentation",
 *      @OA\Contact(
 *          email="admin@fabwaste.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * ),
 * @OAS\SecurityScheme(
 *     securitySchema="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     in="header"
 * 
 * ),

 *
 *
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
