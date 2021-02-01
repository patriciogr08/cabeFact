<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function respondWithToken($token)
    {
        $horaSistema = date("Y-m-d (H:i:s)",  time());
        return response()->json([
            'api_token' => $token,
            'token_type' => 'bearer',
            'dateTimeCreate' => $horaSistema,
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
