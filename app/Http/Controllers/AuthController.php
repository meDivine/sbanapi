<?php

namespace App\Http\Controllers;

use App\Classes\Auth;
use App\Models\ApiKeys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index(Request $request) {
        $auth = new Auth($request->input('email'), $request->input('password'));
        return $auth->auth();
    }

    public function info(Request $request) {
        $user = new ApiKeys();
        return $user->getUserByToken($request->header('api_token'));
    }

    public function test(Request $request) {
        return DB::table('api_keys')
            ->where('token', $request->header('api_token'))
            ->join('users', 'api_keys.user_id', '=', 'users.id')
            ->select('users.name', 'users.email', 'users.balance', 'users.tariff', 'users.tariff_end', 'users.email',
                'users.created_at', 'users.updated_at', 'api_keys.token', 'api_keys.expiry_date')
            ->get();
    }
}
