<?php

namespace App\Http\Controllers\Api;

use App\Helpers\BaseApi;
use App\Helpers\FileHendler;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    //
    const MODULE = 'hrms/recruit/candidate';
    const DETAIL_EDUCATION = 'hrms/recruit/candidate/hrcdtedu';
    const DETAIL_FAMILY = 'hrms/recruit/candidate/hrcdtfam';
    const DETAIL_TRAINING = 'hrms/recruit/candidate/hrcdttrain';
    const DETAIL_JOBEXPRIENCE = 'hrms/recruit/candidate/hrcdtjobexp';
    const DETAIL_ORGANIZATION = 'hrms/recruit/candidate/hrcdtorg';
    const DETAIL_REFERENCE = 'hrms/recruit/candidate/hrcdtreff';
    const DETAIL_ATTACHMENT = 'hrms/recruit/candidate/hrcdtattch';

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

        $hrcdt_photo = FileHendler::upload($request, 'hrcdt_photo');

        $requestParam = [
            'data' => [
                'gender_id' => $request->gender_id,
                'hrcdt_hiredate' => date('d/m/Y', strtotime($request->hrcdt_hiredate)),
                'hrcdt_address' => $request->hrcdt_address,
                'hrcdt_addressdom' => $request->hrcdt_addressdom,
                'hrcdt_birthdate' => date('d/m/Y', strtotime($request->hrcdt_birthdate)),
                'hrcdt_birthplace' => $request->hrcdt_birthplace,
                'hrcdt_email' => $request->hrcdt_email,
                'hrcdt_handphone' => $request->hrcdt_handphone,
                'hrcdt_id' => '',
                'hrcdt_ktp' => $request->hrcdt_ktp,
                'hrcdt_name' => $request->hrcdt_name,
                'hrcdt_photo' => $hrcdt_photo->filename,
                'hrcdt_telp' => $request->hrcdt_telp,
                'marital_id' => $request->marital_id,
                'religion_id' => $request->religion_id,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [
                'hrcdt_photo' => $hrcdt_photo->data,
            ],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return response()->json($res, 200);
    }

    public function storeEdu(Request $request)
    {
        $endpoint = self::DETAIL_EDUCATION . '-save';

        $requestParam = [
            'data' => [
                'edu_id' => $request->edu_id,
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdtedu_city' => $request->hrcdtedu_city,
                'hrcdtedu_gpa' => $request->hrcdtedu_gpa,
                'hrcdtedu_gradyear' => $request->hrcdtedu_gradyear,
                'hrcdtedu_id' => '',
                'hrcdtedu_name' => $request->hrcdtedu_name,
                'hrcdtedu_title' => $request->hrcdtedu_title,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return response()->json($res, 200);
    }

    public function storeFam(Request $request)
    {
        $endpoint = self::DETAIL_FAMILY . '-save';

        $requestParam = [
            'data' => [
                'gender_id' => $request->gender_id,
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdtfam_birthdate' => date('d/m/Y', strtotime($request->hrcdtfam_birthdate)),
                'hrcdtfam_birthplace' => $request->hrcdtfam_birthplace,
                'hrcdtfam_handphone' => $request->hrcdtfam_handphone,
                'hrcdtfam_id' => '',
                'hrcdtfam_name' => $request->hrcdtfam_name,
                'hrrel_id' => $request->hrrel_id,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return response()->json($res, 200);
    }

    public function storeTrain(Request $request)
    {
        $endpoint = self::DETAIL_TRAINING . '-save';

        $requestParam = [
            'data' => [
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdttrain_city' => $request->hrcdttrain_city,
                'hrcdttrain_descr' => $request->hrcdttrain_descr,
                'hrcdttrain_id' => '',
                'hrcdttrain_name' => $request->hrcdttrain_name,
                'hrcdttrain_organizer' => $request->hrcdttrain_organizer,
                'hrcdttrain_year' => $request->hrcdttrain_year,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return response()->json($res, 200);
    }

    public function storeJobExp(Request $request)
    {
        $endpoint = self::DETAIL_JOBEXPRIENCE . '-save';

        $requestParam = [
            'data' => [
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdtjobexp_company' => $request->hrcdtjobexp_company,
                'hrcdtjobexp_dtjoin' => date('d/m/Y', strtotime($request->hrcdtjobexp_dtjoin)),
                'hrcdtjobexp_dtleave' => date('d/m/Y', strtotime($request->hrcdtjobexp_dtleave)),
                'hrcdtjobexp_id' => '',
                'hrcdtjobexp_jobdescr' => $request->hrcdtjobexp_jobdescr,
                'hrcdtjobexp_position' => $request->hrcdtjobexp_position,
                'hrcdtjobexp_reasonleave' => $request->hrcdtjobexp_reasonleave,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return response()->json($res, 200);
    }

    public function storeOrg(Request $request)
    {
        $endpoint = self::DETAIL_ORGANIZATION . '-save';

        $requestParam = [
            'data' => [
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdtorg_city' => $request->hrcdtorg_city,
                'hrcdtorg_descr' => $request->hrcdtorg_descr,
                'hrcdtorg_id' => '',
                'hrcdtorg_name' => $request->hrcdtorg_name,
                'hrcdtorg_position' => $request->hrcdtorg_position,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return response()->json($res, 200);
    }

    public function storeReff(Request $request)
    {
        $endpoint = self::DETAIL_REFERENCE . '-save';

        $requestParam = [
            'data' => [
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdtreff_handphone' => $request->hrcdtreff_handphone,
                'hrcdtreff_id' => '',
                'hrcdtreff_name' => $request->hrcdtreff_name,
                'hrcdtreff_relation' => $request->hrcdtreff_relation,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [],
        ];

        $res = BaseApi::getSave($endpoint, $requestParam);

        return response()->json($res, 200);
    }

    public function storeAttach(Request $request)
    {
        $endpoint = self::DETAIL_ATTACHMENT . '-save';

        $hrcdtattch_filename = FileHendler::upload($request, 'hrcdtattch_filename');

        $requestParam = [
            'data' => [
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdtattch_filename' => $hrcdtattch_filename->filename,
                'hrcdtattch_id' => '',
                'hrcdtattch_name' => $request->hrcdtattch_name,
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [
                'hrcdtattch_filename' => $hrcdtattch_filename->data,
            ],
        ];

        $res = BaseApi::getOpen($endpoint, $requestParam);

        return $res;
    }
}
