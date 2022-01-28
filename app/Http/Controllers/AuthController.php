<?php

namespace App\Http\Controllers;

use App\Classes\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function index(Request $request) {
        $auth = new Auth($request->input('email'), $request->input('password'));
        return $auth->auth();
    }
}
