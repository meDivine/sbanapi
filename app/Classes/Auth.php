<?php

namespace App\Classes;

use App\Models\ApiKeys;
use App\Models\User;
use TheSeer\Tokenizer\Token;

class Auth
{
    public $email;
    public $password;

    /**
     * @param $email
     * @param $password
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Получим ид пользователя при верной паре логин/пароль
     * @return array
     */
    private function getId(): array
    {
        $user = new User();

        $resultCheck = $user->checkPassword($this->email, $this->password);
        if ($resultCheck != null)
            return [
                'auth' => true,
                'message' => 'Успешная авторизация',
                'user_id' => $resultCheck,
                'status' => 200
            ];
        else {
            return [
                'auth' => false,
                'message' => 'Логин или пароль не верен',
                'user_id' => null,
                'status' => 401
            ];
        }
    }

    /**
     * Возьмем токен при успешной авторизации,
     * Если нет - вернем ошибку из метода выше
     * @return array
     */
    private function getToken(): array
    {
        $checkPass = $this->getId();
        if ($checkPass['auth']) {
            $apiToken = new ApiKeys();
            return [
                'auth' => true,
                'message' => 'Успешная авторизация',
                'token' => $apiToken->getToken($checkPass['user_id'])->token,
                'status' => 200
            ];
        }
        else
            return [
                'auth' => false,
                'message' => 'Неуспешная авторизация',
                'token' => null,
                'status' => 401
            ];
    }


    public function auth() {
        $authInfo = $this->getToken();
        return response()->json($authInfo, $authInfo['status']);
    }
}
