<?php

namespace App\Http\Controllers;

use App\Classes\Auth;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function index(Request $request) {
        $auth = new Auth($request->post('email'), $request->post('password'));
        return $auth->auth();
    }
}
