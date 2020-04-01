<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginAppRequest;
use App\Models\User;
use App\Services\ValidateVkSignService;
use App\Traits\SendResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use SendResponse;

    /**
     * Display a listing of the resource.
     *
     * @param LoginAppRequest $request
     * @return JsonResponse
     */
    public function loginByAppSign(LoginAppRequest $request) : JsonResponse
    {
        if(!empty($request->errors)) {
            return $this->sendError('Ошибка валидации данных.', $request->errors, 422);
        }
        /*
        $sign_passed = (new ValidateVkSignService)->validateSign($request->all(), env('VK_APP_SECRET', '')); // TODO: refactor as fabric, app auth

        if(!$sign_passed) {
            return $this->sendError('Авторизация приложения по подписи провалена.', [], 401);
        }
*/
        $email = $request->input('email', 'test@test.com');
        Auth::attempt([
            'email' => $email,
            'password' => env('DEFAULT_USER_APP_PASSWORD', '1234')
        ]);

        $user = User::where('email', $email)->first();
        $tokenResult = $user->createToken('VK_user_token');
        $token = $tokenResult->token;
        $token->save();

        $response = [
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer'
        ];

        return $this->sendResponse($response, 'Пользователь зарегистрирован.');
    }
}
