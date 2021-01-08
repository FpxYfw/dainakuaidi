<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class DataOrderModel extends Model
{
    use SoftDeletes;
    protected $table = 'data_order';
    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at',
        'money','final_money','order_time','user_guid'
    ];

    public function orderCreate($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'money' => $res['money'],
                'order_time' => $res['order_time']
            ]
        );

        return $data;
    }

    public function orderUpdate($res)
    {
        $data = $this->updateOrCreate(
            ['money' => $res['money']],
            [
                'final_money' => $res['final_money']
            ]
        );
        return $data;
    }

    public function deleteOrder($res)
    {
        $model = $this->destroy($res['id']);

        return $model;
    }

    public function selectOrder($res)
    {
        $data = DB::table('data_order')->where('id', '=', $res['order_id'])->first();
        return $data;
    }
}
