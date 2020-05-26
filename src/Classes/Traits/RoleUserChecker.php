<?php

namespace MarcioWinicius\LaravelDefaultClasses\Traits;

use MarcioWinicius\LaravelDefaultClasses\Exceptions\UserNotBelongsToRoleException;
use MarcioWinicius\LaravelDefaultClasses\Entities\User;

trait RoleUserChecker
{
    public function checarGrupoDeUsuario($usuarioId, $role = 'padrão', $exception = true)
    {
        $user = User::find($usuarioId);

        if (!$user->hasRole($role) and !$user->hasRole('superuser')){
            if ($exception) {
                throw new UserNotBelongsToRoleException("User not belongs to the role.");
            }
            return false;
        }
        return true;
    }
}
