<?php

namespace MarcioWinicius\LaravelDefaultClasses\Traits;

use Ramsey\Uuid\Uuid;

trait UuidGenerator {
    public static function boot() {
        parent::boot();
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4();
        });
    }
}
