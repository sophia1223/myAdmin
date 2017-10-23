<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'register', 'login','personal/updatePwd','personal/updateInfo','personal/getInfo', 'activities/getNewList', 'activities/getHistoryList',
        'activities/getMyList','activities/getParticipateInfo','activities/sign','activities/attend','polls/','polls/getInfo/','polls/answer/',
    ];
}
