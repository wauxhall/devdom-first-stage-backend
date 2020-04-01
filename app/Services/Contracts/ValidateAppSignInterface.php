<?php

namespace App\Services\Contracts;

Interface ValidateAppSignInterface
{
    public function validateSign(array $params, string $secret) : bool;
}
