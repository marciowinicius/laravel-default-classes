<?php

namespace MarcioWinicius\LaravelDefaultClasses\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as LaravelCollection;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

use stdClass;

trait Transformable
{
    public function transform($data, $transformer)
    {
        if($data instanceof LaravelCollection) {
            $resource = new Collection($data, new $transformer);
        }

        if ($data instanceof LengthAwarePaginator) {
            $resource = $this->transformPaginator($data, new $transformer);
        }

        if ($data instanceof Model or $data instanceof stdClass) {
            $resource = new Item($data,  new $transformer);
        }

        $manager = new Manager();

        if (isset($_GET['include'])) {
            $manager->parseIncludes($_GET['include']);
        }

        // $manager->setSerializer(new Serializer());

        return $manager->createData($resource)->toArray();


        // return (new Manager())->createData($resource)->toArray();
    }

    protected function transformPaginator($paginator, $transformer)
    {
        $collection = $paginator->getCollection();
        $resource = new Collection($collection, $transformer, null);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return $resource;
    }
}
