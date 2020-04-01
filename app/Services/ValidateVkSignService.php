<?php

namespace App\Services;

use App\Services\Contracts\ValidateAppSignInterface;

class ValidateVkSignService implements ValidateAppSignInterface
{
    public function validateSign(array $query_params, string $client_secret): bool
    {
        if(!isset($query_params['sign'])) {
            return false;
        }

        $sign_params = [];

        foreach ($query_params as $name => $value) {
            if (strpos($name, 'vk_') !== 0) { // Получаем только vk параметры из query
                continue;
            }

            $sign_params[$name] = $value;
        }

        if(empty($sign_params)) {
            return false;
        }

        ksort($sign_params); // Сортируем массив по ключам

        $sign_params_query = http_build_query($sign_params); // Формируем строку вида "param_name1=value&param_name2=value"

        $sign = rtrim(strtr(base64_encode(hash_hmac('sha256', $sign_params_query, $client_secret, true)), '+/', '-_'), '='); // Получаем хеш-код от строки, используя защищеный ключ приложения. Генерация на основе метода HMAC.

        return $sign === $query_params['sign']; // Сравниваем полученную подпись со значением параметра 'sign'
    }
}
