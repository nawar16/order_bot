<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '1721556079:AAEp4yhGMS98w10B_T1WosoTZhKu5ob8zHo/webhook',
        'api/1721556079:AAEp4yhGMS98w10B_T1WosoTZhKu5ob8zHo/webhook'
    ];
}
