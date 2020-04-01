<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\RegisterAppRequest;
use App\Traits\SendResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegisterController
{
    use SendResponse;

    /**
     * Register api user
     *
     * @param RegisterAppRequest $request
     * @return JsonResponse
     */
    public function registerAppUser(RegisterAppRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $input = [
            'name' => 'side_app_user',
            'email' => $request->input('email'),
            'password' => env('DEFAULT_USER_APP_PASSWORD', '1234')
        ];

        $token = User::create($input)->createToken('VK_user_token')->accessToken;

        return $this->sendResponse($token, 'Пользователь зарегистрирован.');
    }
}
