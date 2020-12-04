<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DataCustomerUserModel extends Model
{
    use SoftDeletes;
    protected $table = 'data_customer_user';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at',
        'province','city','district','address','is_default','name','phone'
    ];

    public function createAddress($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'province' => $res['province'],
                'city' => $res['city'],
                'district' => $res['district'],
                'address' => $res['address'],
                'is_default' => $res['is_default'],
                'name' => $res['name'],
                'phone' => $res['phone']
            ]
        );

        return $data;
    }

    public function updateAddress($res)
    {
        $data = $this->updateOrCreate(
            ['province' => $res['province'],],
            [
                'city' => $res['city'],
                'district' => $res['district'],
                'address' => $res['address'],
                'is_default' => $res['is_default'],
                'name' => $res['name'],
                'phone' => $res['phone']
            ]
        );
        return $data;
    }

    public function deleteAddress($res)
    {
        $model = $this->destroy($res['id']);
        return $model;
    }
}
