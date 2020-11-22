<?php

namespace App\Models;

use App\Services\GuidService;
use Illuminate\Database\Eloquent\Model;

class TestTokenModel extends BaseModel
{
    protected $table = 'test_token';
    protected $fillable = [
        'id',
        'client_id',  // guid
        'version',
        'token',
        'token_time',
    ];

    public function TokenSelect()
    {

        $res = $this->get()->where('client_id' , '=' , '7C632103-6A7C-89D0-55FC-35A8F54D4D49')->first();
        $newArr = [
            'client_id' => $res['client_id'],
            'token_time' => $res['token_time'],
            'token' => $res['token'],
        ];
        return $newArr;
    }

}
