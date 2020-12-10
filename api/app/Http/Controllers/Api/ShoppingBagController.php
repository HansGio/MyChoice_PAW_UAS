<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\ShoppingBag;

class ShoppingBagController extends Controller
{
    public function index()
    {
        $items = ShoppingBag::all();

        if (count($items) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'shopping_bags' => $items
            ], 200);
        } //return data semua shoppingBag dalam bentuk json

        return response([
            'message' => 'No shopping Bag found',
        ], 404); //return message data shoppingBag kosong
    }

    public function show($id)
    {
        $shoppingBag = ShoppingBag::find($id); //mencari data shoppingBag berdasarkan id

        if (!is_null($shoppingBag)) {
            return response([
                'message' => 'Retrieve Shopping Bag Success',
                'shopping_bag' => $shoppingBag
            ], 200);
        } //return data shoppingBag yang ditemukan dalam bentuk json

        return response([
            'message' => 'Shopping Bag Not Found',
        ], 404); //return message saat data shoppingBag tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'user_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'size' => 'required',
            'quantity' => 'required|numeric',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 460); //return error invalid input

        $shoppingBag = ShoppingBag::create($storeData); //menambah data shoppingBag baru

        return response([
            'message' => 'Add Shopping Bag Success',
            'shopping_bag' => $shoppingBag,
        ], 200); //return data shoppingBag baru dalam bentuk json
    }

    public function destroy($id)
    {
        $shoppingBag = ShoppingBag::find($id); //mencari data shoppingBag berdasarkan id

        if (is_null($shoppingBag)) {
            return response([
                'message' => 'Shopping Bag Not Found',
            ], 404);
        } //return message saat data shoppingBag tidak ditemukan

        if ($shoppingBag->delete()) {
            return response([
                'message' => 'Delete Shopping Bag Success',
                'shopping_bag' => $shoppingBag,
            ], 200);
        } //return message saat berhasil menghapus data shoppingBag

        return response([
            'message' => 'Delete Shopping Bag Failed',
        ], 400); //return message saat gagal menghapus data shoppingBag
    }

    public function update(Request $request, $id)
    {
        $shoppingBag = ShoppingBag::find($id); //mencari data shoppingBag berdasarkan id

        if (is_null($shoppingBag)) {
            return response([
                'message' => 'Shopping Bag Not Found',
            ], 404);
        } //return message saat data shoppingBag tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'user_id' => 'required|numeric',
            'item_id' => 'required|numeric',
            'size' => 'required',
            'quantity' => 'required|numeric',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $shoppingBag->user_id = $updateData['user_id'];
        $shoppingBag->item_id = $updateData['item_id'];
        $shoppingBag->size = $updateData['size'];
        $shoppingBag->quantity = $updateData['quantity'];

        if ($shoppingBag->save()) {
            return response([
                'message' => 'Update Shopping Bag Success',
                'shopping_bag' => $shoppingBag,
            ], 200);
        } // return data shoppingBag yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Shopping Bag Failed',
        ], 400); // return message saat shoppingBag gagal di edit
    }
}
