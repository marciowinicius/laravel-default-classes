<?php
/**
 * Created by PhpStorm.
 * User: MarcioWinicius
 * Date: 26/11/2018
 * Time: 14:33
 */

namespace MarcioWinicius\LaravelDefaultClasses\Traits;

use Illuminate\Http\Request;
use League\Fractal\Manager;

trait ParseIncludeForTransformer
{
    public function parseIncludes()
    {
        (new Manager())->parseIncludes(Request::capture()->get('include'));
    }
}

