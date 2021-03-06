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
        return ApiKeys::where('token', $request->header('api_token'))->first()->user;
    }
}
