<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'tariff',
        'balance',
        'tariff_end'
    ];

    protected $guarded = [
        'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];


    /**
     * Возьмем данные и сравним пароль
     * @param $email
     * @param $password
     * @return int|null
     */
    public function checkPassword($email, $password): ?int {
        $getUser = DB::table('users')
            ->where('email', $email)
            ->select('id', 'password')
            ->first();
        if (Hash::check($password, $getUser->password)) {
            return $getUser->id;
        }
        else {
            return null;
        }
    }
    public function Api():HasOne {
        return self::hasOne(ApiKey::class);
    }

}
