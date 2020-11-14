<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes;

    public $data = [
        // 此处填写要填充的数据可为数组
    ];
    // 多条数据插入
    public function addManyDatas(Array $data)
    {
        $rs = DB::table($this->getTable())->insert($data);
        return $rs;
    }
}
