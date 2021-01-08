<?php

namespace App\Http\Controllers;

use App\Models\DataUserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;
    public function __construct(DataUserModel $user)
    {
        $this->user = $user;
    }

    public function add(Request $request)
    {
        $res = $request->all();
        $data = $this->user->createUser($res);
        return $data;
    }
    public function edit(Request $request)
    {
        $res = $request->all();
        $data = $this->user->updateUser($res);
        return $data;
    }
    public function del(Request $request)
    {
        $res = $request->all();
        $data = $this->user->deleteUser($res);
        return $data;
    }
    public function query(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->user->selectUser($res);
            return $data;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }
}
