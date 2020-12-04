<?php

namespace App\Http\Controllers;

use App\Services\AddressService;
use Illuminate\Http\Request;

class UserAddressController extends Controller
{
    protected $location;
    public function __construct(AddressService $location)
    {
        $this->location = $location;
    }
    // 地址操作
    public function add(Request $request)
    {
        try {
            $res = $request->all();
            // 从后端获取数据库里的数据，需要取出的字段要有 guid city....
            $data = $this->location->create($res);
            return response()->json($data);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    public function exit(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->location->update($res);
            return response()->json($data);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    public function del(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->location->delete($res);
            return response()->json($data);
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    // 恢复软删除 -- 管理员方可使用
    public function recovery()
    {
        $this->restore();
    }
}
