<?php

namespace MarcioWinicius\LaravelDefaultClasses\Transformers;

use League\Fractal\TransformerAbstract;

class ObjectToArrayTransformer extends TransformerAbstract
{
    public function transform(\stdClass $objeto)
    {
        return (array) $objeto;
    }
}
