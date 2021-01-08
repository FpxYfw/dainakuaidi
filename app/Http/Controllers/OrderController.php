<?php

namespace App\Http\Controllers;

use App\Models\DataOrderModel;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $order;
    public function __construct(DataOrderModel $order)
    {
        $this->order = $order;
    }

    public function add(Request $request)
    {
        $res = $request->all();
        $data = $this->order->orderCreate($res);
        return response()->json($data);
    }

    public function edit(Request $request)
    {
        $res = $request->all();
        $data = $this->order->orderUpdate($res);
        return response()->json($data);
    }

    public function del(Request $request)
    {
        $res = $request->all();
        $data = $this->order->deleteOrder($res);
        return "删除成功";
    }

    public function query(Request $request)
    {
        $res = $request->all();
        $data = $this->order->selectOrder($res);
        return response()->json($data);
    }
}
