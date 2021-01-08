<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DataActivityModel extends Model
{
    use SoftDeletes;
    protected $table = 'data_activity';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at',
        'act_id','act_name','start_time','end_time','min_money','max_money','act_type','goods','act_status'
    ];

    public function createActivity($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'act_name' => $res['act_name'],
                'start_time' => $res['start_time'],
                'end_time' => $res['end_time'],
                'min_money' => $res['min_money'],
                'max_money' => $res['max_money'],
                'act_type' => $res['act_type'],
                'goods' => $res['goods'],
                'act_status' => $res['act_status']
            ]
        );

        return $data;
    }

    public function updateActivity($res)
    {
        $guid = app(GuidService::class);
        $data = $this->updateOrCreate(
            ['act_name' => $res['act_name']],
            [
                'start_time' => $res['start_time'],
                'end_time' => $res['end_time'],
                'min_money' => $res['min_money'],
                'max_money' => $res['max_money'],
                'act_type' => $res['act_type'],
                'goods' => $res['goods'],
                'act_status' => $res['act_status']
            ]
        );

        return $data;
    }

    public function deleteActivity($res)
    {
        $model = $this->destroy($res['id']);

        return $model;
    }

    public function selectActivity($res)
    {
        $data = DB::table('data_activity')->where('id', '=', $res['activity_id'])->first();
        return $data;
    }
}
