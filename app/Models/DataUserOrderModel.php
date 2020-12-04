<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;

class DataUserOrderModel extends Model
{
    protected $table = 'data_user_order';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at','order_status'
    ];
    public function user_order($res)
    {
        $guid = app(GuidService::class);

        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'order_status' => $res['order_status']
            ]
        );

        return $data;
    }
}
