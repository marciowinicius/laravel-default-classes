<?php

namespace MarcioWinicius\LaravelDefaultClasses\Traits;


trait RelationshipSync
{
    public function sync(string $relacionamento, array $request, $model, $relacionamentoModel = null)
    {
        if (array_key_exists($relacionamento, $request)) {
            $idsRelacionamento = !is_null($request[$relacionamento]) ? $request[$relacionamento] : [];
            if (is_null($relacionamentoModel)) {
                $model->{$relacionamento}()->sync($idsRelacionamento);
            } else {
                $model->{$relacionamentoModel}()->sync($idsRelacionamento);
            }
        }
    }
}
