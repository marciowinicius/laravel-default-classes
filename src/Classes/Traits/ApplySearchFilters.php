<?php

namespace MarcioWinicius\LaravelDefaultClasses\Traits;

use \Closure;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;

trait ApplySearchFilters {

    private $filters;

    public function applySearchFilters(Collection $data, Closure $fn)
    {
        $this->filters = $this->parseFilters();

        if (! $this->filters) {
            return $data;
        }

        return $data->filter($fn);
    }

    public function parseFilters()
    {
        $filters = Request::capture()->get('search');

        if (empty($filters)) {
            return null;
        }

        if (str_contains($filters, ';')) {
            $filters = explode(';', $filters);
        } else {
            $filters = [$filters];
        }

        $filter = collect($filters)->flatMap(function ($filter) {
            list($key, $value) = explode(':', $filter);
            if ($value == 'true') {
                $value = true;
            } elseif ($value == 'false'){
                $value = false;
            }
            return [$key => $value];
        })->toArray();

        return (object) $filter;
    }
}
