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
        $edus = $request->edus ?? [];
        $fams = $request->fams ?? [];
        $trains = $request->trans ?? [];
        $jobexps = $request->jobexps ?? [];
        $orgs = $request->orgs ?? [];
        $reffs = $request->reffs ?? [];

        $candidate = $this->storeCandidate($request);
        $hrcdt_id = $candidate->responseData->dataresponse->hrcdt_id;

        if (count($edus) > 0) {
            $this->storeEdu($edus, $hrcdt_id);
        }

        if (count($fams) > 0) {
            $this->storeFam($fams, $hrcdt_id);
        }

        if (count($trains) > 0) {
            $this->storeTrain($trains, $hrcdt_id);
        }

        if (count($jobexps) > 0) {
            $this->storeJobExp($jobexps, $hrcdt_id);
        }

        if (count($orgs) > 0) {
            $this->storeOrg($orgs, $hrcdt_id);
        }

        if (count($reffs) > 0) {
            $this->storeReff($reffs, $hrcdt_id);
        }
        
        return response()->json('OK', 200);
    }

    public function show($id)
    {
        $endpoint = self::MODULE . '/open';

        $requestParam = [
            'options' =>  [
                'api' => $endpoint,
                'criteria' => [
                    'hrcdt_id' => $id,
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

        $hrcdt_photo = FileHendler::upload($request, 'hrcdt_photo');

        $requestParam = [
            'data' => [
                'gender_id' => $request->gender_id,
                'hrcdt_address' => $request->hrcdt_address,
                'hrcdt_addressdom' => $request->hrcdt_addressdom,
                'hrcdt_birthdate' => $request->hrcdt_birthdate,
                'hrcdt_birthplace' => $request->hrcdt_birthplace,
                'hrcdt_email' => $request->hrcdt_email,
                'hrcdt_handphone' => $request->hrcdt_handphone,
                'hrcdt_id' => $id,
                'hrcdt_ktp' => $request->hrcdt_ktp,
                'hrcdt_name' => $request->hrcdt_name,
                'hrcdt_photo' => $hrcdt_photo->filename,
                'hrcdt_telp' => $request->hrcdt_telp,
                'marital_id' => $request->marital_id,
                'religion_id' => $request->religion_id,
                '_state' => 'MODIFY'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => false,
                'autoid' => true,
                'skipmappingresponse' => [],
            ],
            'files' => [
                'hrcdt_photo' => $hrcdt_photo->data,
            ],
        ];

        $res = BaseApi::getOpen($endpoint, $requestParam);

        return $res;
    }

    public function destroy($id)
    {
        $endpoint = self::MODULE . '/delete';

        $requestParam = [
            'data' => [
                'hrcdt_id' => $id,
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

    protected function storeCandidate($request)
    {
        $endpoint = self::MODULE . '/save';

        $hrcdt_photo = FileHendler::upload($request, 'hrcdt_photo');

        $requestParam = [
            'data' => [
                'gender_id' => $request->gender_id,
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

        $res = BaseApi::getOpen($endpoint, $requestParam);

        return $res;
    }

    protected function storeEdu($edus, $hrcdt_id)
    {
        $endpoint = self::DETAIL_EDUCATION . '-save';

        foreach ($edus as $key => $edu) {
            $requestParam = [
                'data' => [
                    'edu_id' => $edu['edu_id'],
                    'hrcdt_id' => $hrcdt_id,
                    'hrcdtedu_city' => $edu['hrcdtedu_city'],
                    'hrcdtedu_gpa' => $edu['hrcdtedu_gpa'],
                    'hrcdtedu_id' => '',
                    'hrcdtedu_name' => $edu['hrcdtedu_name'],
                    'hrcdtedu_title' => $edu['hrcdtedu_title'],
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
    
            BaseApi::getSave($endpoint, $requestParam);
        }
    }

    protected function storeFam($fams, $hrcdt_id)
    {
        $endpoint = self::DETAIL_FAMILY . '-save';

        foreach ($fams as $key => $fam) {
            $requestParam = [
                'data' => [
                    'gender_id' => $fam['gender_id'],
                    'hrcdt_id' => $hrcdt_id,
                    'hrcdtfam_birthdate' => $fam['hrcdtfam_birthdate'],
                    'hrcdtfam_birthplace' => $fam['hrcdtfam_birthplace'],
                    'hrcdtfam_handphone' => $fam['hrcdtfam_handphone'],
                    'hrcdtfam_id' => '',
                    'hrcdtfam_name' => $fam['hrcdtfam_name'],
                    'hrrel_id' => $fam['hrrel_id'],
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
    
            BaseApi::getSave($endpoint, $requestParam);
        }
    }

    protected function storeTrain($trains, $hrcdt_id)
    {
        $endpoint = self::DETAIL_TRAINING . '-save';

        foreach ($trains as $key => $train) {
            $requestParam = [
                'data' => [
                    'hrcdt_id' => $hrcdt_id,
                    'hrcdttrain_city' => $train['hrcdttrain_city'],
                    'hrcdttrain_descr' => $train['hrcdttrain_descr'],
                    'hrcdttrain_id' => '',
                    'hrcdttrain_name' => $train['hrcdttrain_name'],
                    'hrcdttrain_organizer' => $train['hrcdttrain_organizer'],
                    'hrcdttrain_year' => $train['hrcdttrain_year'],
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
    
            BaseApi::getSave($endpoint, $requestParam);
        }
    }

    protected function storeJobExp($jobexps, $hrcdt_id)
    {
        $endpoint = self::DETAIL_JOBEXPRIENCE . '-save';

        foreach ($jobexps as $key => $jobexp) {
            $requestParam = [
                'data' => [
                    'hrcdt_id' => $hrcdt_id,
                    'hrcdtjobexp_company' => $jobexp['hrcdtjobexp_company'],
                    'hrcdtjobexp_dtjoin' => $jobexp['hrcdtjobexp_dtjoin'],
                    'hrcdtjobexp_dtleave' => $jobexp['hrcdtjobexp_dtleave'],
                    'hrcdtjobexp_id' => '',
                    'hrcdtjobexp_jobdescr' => $jobexp['hrcdtjobexp_jobdescr'],
                    'hrcdtjobexp_position' => $jobexp['hrcdtjobexp_position'],
                    'hrcdtjobexp_reasonleave' => $jobexp['hrcdtjobexp_reasonleave'],
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
    
            BaseApi::getSave($endpoint, $requestParam);
        }
    }

    protected function storeOrg($orgs, $hrcdt_id)
    {
        $endpoint = self::DETAIL_ORGANIZATION . '-save';

        foreach ($orgs as $key => $org) {
            $requestParam = [
                'data' => [
                    'hrcdt_id' => $hrcdt_id,
                    'hrcdtorg_city' => $org['hrcdtorg_city'],
                    'hrcdtorg_descr' => $org['hrcdtorg_descr'],
                    'hrcdtorg_id' => '',
                    'hrcdtorg_name' => $org['hrcdtorg_name'],
                    'hrcdtorg_position' => $org['hrcdtorg_position'],
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
    
            BaseApi::getSave($endpoint, $requestParam);
        }
    }

    protected function storeReff($reffs, $hrcdt_id)
    {
        $endpoint = self::DETAIL_REFERENCE . '-save';

        foreach ($reffs as $key => $reff) {
            $requestParam = [
                'data' => [
                    'hrcdt_id' => $hrcdt_id,
                    'hrcdtreff_handphone' => $reff['hrcdtreff_handphone'],
                    'hrcdtreff_id' => '',
                    'hrcdtreff_name' => $reff['hrcdtreff_name'],
                    'hrcdtreff_relation' => $reff['hrcdtreff_relation'],
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
    
            BaseApi::getSave($endpoint, $requestParam);
        }
    }

    protected function storeAttachment($request)
    {
        $endpoint = self::DETAIL_ATTACHMENT . '-save';

        $hrcdtattch_filename = FileHendler::upload($request, 'hrcdtattch_filename');

        $requestParam = [
            'data' => [
                'hrcdt_id' => $request->hrcdt_id,
                'hrcdtattch_expired' => $request->hrcdtattch_expired,
                'hrcdtattch_filename' => $hrcdtattch_filename->filename,
                'hrcdtattch_id' => '',
                'hrcdtattch_name' => date('d/m/Y', strtotime($request->hrcdtattch_name)),
                'hrcdtattch_validity' => date('d/m/Y', strtotime($request->hrcdtattch_validity)),
                '_state' => 'NEW'
            ],
            'options' => [
                'api' => $endpoint,
                'cancel' => FALSE,
                'autoid' => TRUE,
                'skipmappingresponse' => [],
            ],
            'files' => [
                'hrcdt_photo' => $hrcdtattch_filename->data,
            ],
        ];

        $res = BaseApi::getOpen($endpoint, $requestParam);

        return $res;
    }
}
