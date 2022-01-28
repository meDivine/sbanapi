<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ApiKeys extends Model
{
    /**
     * Получим токен по id пользователя
     * @param $id
     * @return Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getToken($id) {
        return DB::table('api')
            ->where('user_id', $id)
            ->select('api_keys.token')
            ->first();
    }
}
