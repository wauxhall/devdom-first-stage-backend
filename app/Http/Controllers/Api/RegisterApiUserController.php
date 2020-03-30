<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RegisterApiUserRequest;
use App\Traits\SendResponse;
use App\Models\User;

class RegisterApiUserController
{
    use SendResponse;

    /**
     * Register api user
     *
     * @param RegisterApiUserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterApiUserRequest $request)
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }

        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $token = User::create($input)->createToken('VK_user_token')->accessToken;

        return $this->sendResponse($token, 'Пользователь зарегистрирован.');
    }
}
