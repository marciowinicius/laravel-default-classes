<?php

namespace MarcioWinicius\LaravelDefaultClasses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Artesaos\Defender\Traits\HasDefender;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Wildside\Userstamps\Userstamps;
use OwenIt\Auditing\Contracts\Auditable as AuditableContract;

class User extends Model implements Transformable, AuthenticatableContract, CanResetPasswordContract, AuditableContract
{
    use Authenticatable, CanResetPassword, HasApiTokens, HasDefender, Notifiable, TransformableTrait, SoftDeletes, Userstamps, Auditable;

    protected $fillable = [
        'username',
        'email',
        'document',
        'password'
    ];

    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    protected $casts = [

    ];

    protected $hidden = ['password'];
}
