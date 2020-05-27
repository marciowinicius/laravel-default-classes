<?php

namespace MarcioWinicius\LaravelDefaultClasses\Miscellaneous;

use  League\Fractal\Serializer\ArraySerializer;

class FractalSerializer extends ArraySerializer
{
    /**
     * Serialize a collection.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function collection($resourceKey, array $data)
    {
        // return ['data' => $data];
        
        return $data;
    }

    /**
     * Serialize an item.
     *
     * @param string $resourceKey
     * @param array  $data
     *
     * @return array
     */
    public function item($resourceKey, array $data)
    {
        // return ['data' => $data];
        
        return $data;
    }

    /**
     * Serialize null resource.
     *
     * @return array
     */
    public function null()
    {
        // return ['data' => []];
        return null;
    }
}
