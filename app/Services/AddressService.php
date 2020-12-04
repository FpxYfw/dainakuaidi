<?php

namespace App\Services;

use App\Models\DataCustomerUserModel;

class AddressService
{
    public function create($res)
    {
        try {
            $data = app(DataCustomerUserModel::class);

            $model = $data->createAddress($res);

            return $model;
        } catch (\Exception $e) {
            echo $e->getCode();
            echo $e->getMessage();
        }
    }

    // 如果用户从前端选择修改地址，那么进行 update() 的操作
    public function update($res)
    {
        $data = app(DataCustomerUserModel::class);

        $model = $data->updateAddress($res);

        return $model;
    }

    // 如果用户从前端选择删除地址，那么进行 delete() 的操作。   guid作为唯一标识
    public function delete($res)
    {
        $data = app(DataCustomerUserModel::class);

        $model = $data->deleteAddress($res);

        return $model;
    }
}