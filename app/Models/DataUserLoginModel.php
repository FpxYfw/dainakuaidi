<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DataUserLoginModel extends BaseModel
{
    protected $table = 'data_user_login';

    protected $fillable = [
        'id',
        'guid',
        'created_at',
        'updated_at',
        'deleted_at',
        'openid',
        'city',
        'nickName',
        'gender',
        'language',
        'province',
        'country',
        'avatarUrl'
    ];
}
