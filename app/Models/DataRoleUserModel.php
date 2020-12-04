<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;

class DataRoleUserModel extends Model
{
    protected $table = 'data_user';

    protected $fillable = [
        'id','guid','created_at','updated_at','deleted_at','role_id'
    ];

    public function data_user($res)
    {
        $guid = app(GuidService::class);
        $data = $this->firstOrCreate(
            ['guid' => $guid::create_guid()],
            [
                'role_id' => $res['role_id'],
            s]
        );

        return $data['guid'];
    }
}
