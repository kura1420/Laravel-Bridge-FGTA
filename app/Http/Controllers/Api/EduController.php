<?php

namespace App\Http\Controllers\Api;

use App\Helpers\BaseApi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EduController extends Controller
{
    //
    const MODULE = "hrms/master/edu";

    public function index()
    {
        $endpoint = self::MODULE . '/list';

        $requestParam = [
            'options' =>  [
                'api' => $endpoint,
                'offset' => 0,
                'criteria' => [],
                'loadmask' => TRUE,
            ],
            'files' => [],
        ];

        $res = BaseApi::getList($endpoint, $requestParam);

        return $res;
    }

    public function store(Request $request)
    {
        $endpoint = self::MODULE . '/save';

        $requestParam = [
            'data' => [
                'edu_id' => $request->edu_id,
                'edu_name' => $request->edu_name,
                'edu_descr' => $request->edu_descr,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => false,
                'autoid' => false,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return $res;
    }

    public function show($id)
    {
        $endpoint = self::MODULE . '/open';

        $requestParam = [
            'options' =>  [
                'api' => $endpoint,
                'criteria' => [
                    'edu_id' => $id,
                ],
            ],
            'files' => [],
        ];

        $res = BaseApi::getOpen($endpoint, $requestParam);

        return $res;
    }

    public function update(Request $request, $id)
    {
        $endpoint = self::MODULE . '/save';

        $requestParam = [
            'data' => [
                'edu_id' => $id,
                'edu_name' => $request->edu_name,
                'edu_descr' => $request->edu_descr,
                '_state' => 'MODIFY'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => false,
                'autoid' => false,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getOpen($endpoint, $requestParam);

        return $res;
    }

    public function destroy($id)
    {
        $endpoint = self::MODULE . '/delete';

        $requestParam = [
            'data' => [
                'edu_id' => $id,
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => false,
                'noconfirm' => true,
            ],
            'files' => [],
        ];

        $res = BaseApi::getDestroy($endpoint, $requestParam);

        return $res;
    }
}
