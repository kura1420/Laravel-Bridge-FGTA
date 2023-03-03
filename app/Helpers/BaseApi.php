<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class BaseApi 
{
    
    const USERNAME = 'syakur';
    const PASSWORD = '123123';
    const TOKEN_DUMMY = "eyJjaXBoZXJ0ZXh0IjoiZmpWWHducE5PaVg2bWpJWDllXC9LaVpheVFaQjB4VXEwdjVwVlFtczdGVm9BUDVMcjVKXC93eDFxbG1PWnNxMlBKIiwiaXYiOiJkZGIzYzBiYWE5NTRiNTQ3M2E4NzYxZjM5Mjg1ZWZkMiIsInNhbHQiOiJmYTc3YzA1Mjg2ZTZlMTEyZTI1NTMyYmY1NjI4YTIzNjM5MzY4NzQwNjI2NGU3NDY5MDgzOTc0NzE0MDk3ZjUyNzk5NWYzYzUxOTFmNjIyMGNhYWQxZTAxYTA5NjMxNmYwZDNlMjkyN2IzYWYzNzllNGEyZTQzMzIwODk3MjNiMjA5YjhlZjA3ZDBhYTVmNDc5MzNiZjRkMDkwZjM0MDQ4NmJjMjZjODBiODA4OTllN2Y1ZTIzNjU0OThiZTBkY2Q1MDZhY2RhNGRjNDA5ZGQzNDFiMTYwNjM0YmZjMjdmMTc0ZmU4YzZiYWVlM2NmYTU5OGM4OWU3NjQxNjlmMzVmZDkxNGE2YzJjYjU1NTdjZTZlZTNmYmYyMDI2ZjllNzdlMTFiODFhNWZjNWI1ODc2N2EyZjlmNjAwZTZkZGYwZGJlYjI3YWYxMjdiNjQ5ODExNWNmNDY5NDE2Y2QyMDY2Y2U0NzhkYTM3YzQ2NTNkYjY1YmJmN2M3NzllNmVkOGE3NzA2YjRlMGVjNDk2Njc4ZGZkYjJiODdhZWM0NGExMmNiNjJlZDkwN2Q0YmQ4NGUzNTg5N2ZjYmZjMjdjZmM3ZGYwNjg5MmZhZGVmYzA3MDAzMWE3Mjc3Y2Q2ZDcxYzUzNWZiOGM2MjdjNzgwNmE2N2ZkZDI3ZTQxZDQzNGZhYSIsIml0ZXJhdGlvbnMiOjk5OX0=O6oJ7J3ezE3AiEras5xcxS2yLD9gn5";

    protected static $header = [
        'fgta-mode' => 'api',
        'fgta-appid' => 'appid',
        'fgta-secret' => 'secret',
    ];

    public static function getNonce($module, $fgtaHost)
    {
        self::checkTokenID();

        $header = self::$header;

        $res = Http::withOptions([
            'debug' => FALSE,
        ])
            ->withHeaders($header)
            ->get($fgtaHost . "/get/fgta/framework/otp/getnonce/{$module}/getnonce");

        return $res;
    }

    public static function doLogin($module)
    {
        $fgtaHost = config('app.fgta_host', 'http://localhost:8081/project/index.php');

        $responseNonce = self::getNonce($module, $fgtaHost);

        if ($responseNonce->successful()) {
            $obj = $responseNonce->object();

            self::$header['fgta-nonce'] = $obj->responseData->nonce;

            $res = Http::withOptions([
                'debug' => FALSE,
            ])
                ->withHeaders(self::$header)
                ->post($fgtaHost . "/api/" . $module, [
                    'txid' => NULL,
                    'requestParam' => [
                        'username' => self::USERNAME,
                        'password' => self::PASSWORD,
                        'files' => [],
                    ],
                ]);

            $responseData = $res->object();
            $userdata = $responseData->responseData->userdata;

            session()->put('tokenid', $userdata->tokenid);

            return $responseNonce;
        } else {
            return $responseNonce->serverError();
        }
    }

    public static function getList($module, $requestParam)
    {
        $fgtaHost = config('app.fgta_host', 'http://localhost:8081/project/index.php');

        $responseNonce = self::getNonce($module, $fgtaHost);

        if ($responseNonce->successful()) {
            $obj = $responseNonce->object();

            self::$header['fgta-nonce'] = $obj->responseData->nonce;

            $res = Http::withOptions([
                'debug' => FALSE,
            ])
                ->withHeaders(self::$header)
                ->post($fgtaHost . "/api/{$module}", [
                    'txid' => NULL,
                    'requestParam' => $requestParam,
                ]);

            $responseData = $res->object();

            return $responseData;
        } else {
            return $responseNonce->serverError();
        }
    }

    public static function getSave($module, $requestParam)
    {
        $fgtaHost = config('app.fgta_host', 'http://localhost:8081/project/index.php');

        $responseNonce = self::getNonce($module, $fgtaHost);

        if ($responseNonce->successful()) {
            $obj = $responseNonce->object();

            self::$header['fgta-nonce'] = $obj->responseData->nonce;

            $params = [
                'txid' => NULL,
                'requestParam' => $requestParam,
            ];

            $res = Http::withOptions([
                'debug' => FALSE,
            ])
                ->withHeaders(self::$header)
                ->post($fgtaHost . "/api/{$module}", $params);

            $responseData = $res->object();

            return $responseData;
        } else {
            return $responseNonce->serverError();
        }
    }

    public static function getOpen($module, $requestParam)
    {
        $fgtaHost = config('app.fgta_host', 'http://localhost:8081/project/index.php');

        $responseNonce = self::getNonce($module, $fgtaHost);

        if ($responseNonce->successful()) {
            $obj = $responseNonce->object();

            self::$header['fgta-nonce'] = $obj->responseData->nonce;

            $params = [
                'txid' => NULL,
                'requestParam' => $requestParam,
            ];

            $res = Http::withOptions([
                'debug' => FALSE,
            ])
                ->withHeaders(self::$header)
                ->post($fgtaHost . "/api/{$module}", $params);

            $responseData = $res->object();

            return $responseData;
        } else {
            return $responseNonce->serverError();
        }
    }

    public static function getDestroy($module, $requestParam)
    {
        $fgtaHost = config('app.fgta_host', 'http://localhost:8081/project/index.php');

        $responseNonce = self::getNonce($module, $fgtaHost);

        if ($responseNonce->successful()) {
            $obj = $responseNonce->object();

            self::$header['fgta-nonce'] = $obj->responseData->nonce;

            $params = [
                'txid' => NULL,
                'requestParam' => $requestParam,
            ];

            $res = Http::withOptions([
                'debug' => FALSE,
            ])
                ->withHeaders(self::$header)
                ->post($fgtaHost . "/api/{$module}", $params);

            $responseData = $res->object();

            return $responseData;
        } else {
            return $responseNonce->serverError();
        }
    }

    protected static function checkTokenID()
    {
        if (session()->has('tokenid')) {
            self::$header['fgta-tokenid'] = session()->get('tokenid');
        } else {
            self::$header['fgta-tokenid'] = self::TOKEN_DUMMY;
        }
    }

}
