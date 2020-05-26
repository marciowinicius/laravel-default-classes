<?php

namespace MarcioWinicius\LaravelDefaultClasses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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

class User extends Model implements Transformable, AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, HasApiTokens, HasDefender, Notifiable, TransformableTrait, SoftDeletes, Userstamps;

    protected $table = 'usuarios';

    protected $fillable = [
        'nome',
        'email',
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
