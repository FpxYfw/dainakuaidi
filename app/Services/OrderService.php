<?php

namespace App\Services;

use App\Models\DataUserOrderModel;

class OrderService
{
    public function order_first_or_create($res)
    {
        $data = app(DataUserOrderModel::class);
        $model = $data->user_order($res);

        return $model;
    }
}