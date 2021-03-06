<?php

namespace MarcioWinicius\LaravelDefaultClasses\Http\Controllers;

use MarcioWinicius\LaravelDefaultClasses\Traits\ApplySearchFilters;
use MarcioWinicius\LaravelDefaultClasses\Traits\Transformable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

/**
 * @OA\Info(
 *  title="API MS Automotor",
 *  version="1.0",
 *  description="Micro serviço de automotor.",
 *  @OA\Contact(name="Datapage",email="suporte@datapage.com.br")
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Transformable, ApplySearchFilters;

    public function defaultReturn($msg, $data, $error = 0)
    {
        $meta = null;
        if (array_key_exists('meta', $data)){
            $meta = $data['meta'];
            unset($data['meta']);
        }
        return ['error' => $error, 'message' => $msg, 'data' => $data, 'meta' => $meta];
    }
}
