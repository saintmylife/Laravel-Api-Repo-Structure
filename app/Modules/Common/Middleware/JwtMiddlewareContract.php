<?php

namespace App\Modules\Common\Middleware;

use Illuminate\Http\Request;

interface JwtMiddlewareContract
{
    public function checkAndSetToken(Request $request);
    public function returnPayload(string $status);
}
