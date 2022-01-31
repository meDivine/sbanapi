<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            if ($request->header('api_token')) {
                //return User::where('token', $request->input('api_token'))->first();
                $get = DB::table('api_keys')
                    ->where('token', $request->header('api_token'))
                    ->join('users', 'api_keys.user_id', '=', 'users.id')
                    ->select('users.name', 'users.email', 'users.balance', 'users.tariff', 'users.tariff_end', 'users.email',
                        'users.created_at', 'users.updated_at', 'api_keys.token', 'api_keys.expiry_date')
                    ->first();
                Log::info($get);
                return $get;
            }
        });
    }
}
