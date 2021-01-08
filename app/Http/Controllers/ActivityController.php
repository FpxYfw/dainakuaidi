<?php

namespace App\Http\Controllers;

use App\Models\DataActivityModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActivityController extends Controller
{
    protected $act;
    public function __construct(DataActivityModel $act)
    {
        $this->act = $act;
    }

    public function add(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->act->createActivity($res);
            return $data;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    public function edit(Request $request)
    {
        try {
            $res = $request->all();
            $data = $this->act->updateActivity($res);
            return $data;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    public function del(Request $request)
    {
        $res = $request->all();
        $data = $this->act->deleteActivity($res);
        return $data;
    }

   public function query(Request $request)
   {
       try {
           $res = $request->all();
           $data = $this->act->selectActivity($res);
           return $data;
       }catch (\Exception $e) {
           echo $e->getCode();
           echo $e->getMessage();
       }
   }
}
