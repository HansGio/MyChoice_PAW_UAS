<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Order;
use App\OrderDetail;

class OrderController extends Controller
{
    public function index()
    {
        $items = Order::all();

        if (count($items) > 0) {

            foreach ($items as $item) {
                $orderDetails = OrderDetail::where('order_id', $item->id)->get();
                $item->order_details = $orderDetails;
            }

            return response([
                'message' => 'Retrieve All Success',
                'items' => $items
            ], 200);
        } //return data semua order dalam bentuk json

        return response([
            'message' => 'No order found',
        ], 404); //return message data order kosong
    }

    public function show($id)
    {
        $order = Order::find($id); //mencari data order berdasarkan id

        if (!is_null($order)) {
            $orderDetails = OrderDetail::where('order_id', $order->id)->get();
            return response([
                'message' => 'Retrieve Order Success',
                'order' => $order,
                'order_details' => $orderDetails,
            ], 200);
        } //return data order yang ditemukan dalam bentuk json

        return response([
            'message' => 'Order Not Found',
        ], 404); //return message saat data order tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'user_id' => 'required|numeric',
            'recipient_address' => 'required',
            'recipient_name' => 'required',
            'recipient_phone' => 'required|digits_between:10,13',
            'delivery_status' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 460); //return error invalid input

        $order = Order::create($storeData); //menambah data order baru

        return response([
            'message' => 'Add Order Success',
            'order' => $order,
        ], 200); //return data order baru dalam bentuk json
    }

    public function destroy($id)
    {
        $order = Order::find($id); //mencari data order berdasarkan id

        if (is_null($order)) {
            return response([
                'message' => 'Order Not Found',
            ], 404);
        } //return message saat data order tidak ditemukan

        if ($order->delete()) {
            return response([
                'message' => 'Delete Order Success',
                'order' => $order,
            ], 200);
        } //return message saat berhasil menghapus data order

        return response([
            'message' => 'Delete Order Failed',
        ], 400); //return message saat gagal menghapus data order
    }

    public function update(Request $request, $id)
    {
        $order = Order::find($id); //mencari data order berdasarkan id

        if (is_null($order)) {
            return response([
                'message' => 'Order Not Found',
            ], 404);
        } //return message saat data order tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'user_id' => 'required|numeric',
            'recipient_address' => 'required',
            'recipient_name' => 'required',
            'recipient_phone' => 'required|digits_between:10,13',
            'delivery_status' => 'required',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $order->user_id = $updateData['user_id'];
        $order->recipient_address = $updateData['recipient_address'];
        $order->recipient_name = $updateData['recipient_name'];
        $order->recipient_phone = $updateData['recipient_phone'];
        $order->delivery_status = $updateData['delivery_status'];

        if ($order->save()) {
            return response([
                'message' => 'Update Order Success',
                'order' => $order,
            ], 200);
        } // return data order yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Order Failed',
        ], 400); // return message saat order gagal di edit
    }
}
