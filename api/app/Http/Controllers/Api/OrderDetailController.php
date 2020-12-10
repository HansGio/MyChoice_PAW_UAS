<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\OrderDetail;

class OrderDetailController extends Controller
{
    public function index()
    {
        $orderDetails = OrderDetail::all();

        if (count($orderDetails) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'order_details' => $orderDetails
            ], 200);
        } //return data semua orderDetail dalam bentuk json

        return response([
            'message' => 'No order Detail found',
        ], 404); //return message data orderDetail kosong
    }

    public function show($id)
    {
        $orderDetail = OrderDetail::find($id); //mencari data orderDetail berdasarkan id

        if (!is_null($orderDetail)) {
            return response([
                'message' => 'Retrieve Order Detail Success',
                'order_detail' => $orderDetail
            ], 200);
        } //return data orderDetail yang ditemukan dalam bentuk json

        return response([
            'message' => 'Order Detail Not Found',
        ], 404); //return message saat data orderDetail tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'order_id' => 'required|numeric',
            'item_name' => 'required',
            'item_quantity' => 'required|numeric',
            'item_size' => 'required',
            'buy_price' => 'required|numeric',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 460); //return error invalid input

        $orderDetail = OrderDetail::create($storeData); //menambah data orderDetail baru

        return response([
            'message' => 'Add Order Detail Success',
            'order_detail' => $orderDetail,
        ], 200); //return data orderDetail baru dalam bentuk json
    }

    public function destroy($id)
    {
        $orderDetail = OrderDetail::find($id); //mencari data orderDetail berdasarkan id

        if (is_null($orderDetail)) {
            return response([
                'message' => 'Order Detail Not Found',
            ], 404);
        } //return message saat data orderDetail tidak ditemukan

        if ($orderDetail->delete()) {
            return response([
                'message' => 'Delete Order Detail Success',
                'order_detail' => $orderDetail,
            ], 200);
        } //return message saat berhasil menghapus data orderDetail

        return response([
            'message' => 'Delete Order Detail Failed',
        ], 400); //return message saat gagal menghapus data orderDetail
    }

    public function update(Request $request, $id)
    {
        $orderDetail = OrderDetail::find($id); //mencari data orderDetail berdasarkan id

        if (is_null($orderDetail)) {
            return response([
                'message' => 'Order Detail Not Found',
            ], 404);
        } //return message saat data orderDetail tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'order_id' => 'required|numeric',
            'item_name' => 'required',
            'item_quantity' => 'required|numeric',
            'item_size' => 'required',
            'buy_price' => 'required|numeric',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $orderDetail->order_id = $updateData['order_id'];
        $orderDetail->item_name = $updateData['item_name'];
        $orderDetail->item_quantity = $updateData['item_quantity'];
        $orderDetail->item_size = $updateData['item_size'];
        $orderDetail->buy_price = $updateData['buy_price'];

        if ($orderDetail->save()) {
            return response([
                'message' => 'Update Order Detail Success',
                'order_detail' => $orderDetail,
            ], 200);
        } // return data orderDetail yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Order Detail Failed',
        ], 400); // return message saat orderDetail gagal di edit
    }
}
