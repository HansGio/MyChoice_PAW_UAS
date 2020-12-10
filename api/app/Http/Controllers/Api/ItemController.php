<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use Validator;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::all();

        if (count($items) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'items' => $items
            ], 200);
        } //return data semua item dalam bentuk json

        return response([
            'message' => 'No item found',
        ], 404); //return message data item kosong
    }

    public function showMan()
    {
        $items = Item::where('gender', 'man')->get();

        if (count($items) > 0) {
            return response([
                'message' => 'Retrieve Man Items Success',
                'items' => $items
            ], 200);
        } //return data semua item dalam bentuk json

        return response([
            'message' => 'No item found',
        ], 404); //return message data item kosong
    }

    public function showWoman()
    {
        $items = Item::where('gender', 'woman')->get();

        if (count($items) > 0) {
            return response([
                'message' => 'Retrieve Woman Items Success',
                'items' => $items
            ], 200);
        } //return data semua item dalam bentuk json

        return response([
            'message' => 'No item found',
        ], 404); //return message data item kosong
    }

    public function showRecommend()
    {
        $items = Item::where('active', 1)->take(8)->get();

        if (count($items) > 0) {
            return response([
                'message' => 'Retrieve Woman Items Success',
                'items' => $items
            ], 200);
        } //return data semua item dalam bentuk json

        return response([
            'message' => 'No item found',
        ], 404); //return message data item kosong
    }

    public function show($id)
    {
        $item = Item::find($id); //mencari data item berdasarkan id

        if (!is_null($item)) {
            return response([
                'message' => 'Retrieve Item Success',
                'item' => $item
            ], 200);
        } //return data item yang ditemukan dalam bentuk json

        return response([
            'message' => 'Item Not Found',
        ], 404); //return message saat data item tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'name' => 'required',
            'gender' => 'required',
            'stock_s' => 'required|numeric',
            'stock_m' => 'required|numeric',
            'stock_l' => 'required|numeric',
            'stock_xl' => 'required|numeric',
            'active' => 'boolean',
            'description' => 'required',
            'price' => 'required|numeric',
            'image64' => 'nullable',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 460); //return error invalid input

        $item = Item::create($storeData); //menambah data item baru

        return response([
            'message' => 'Add Item Success',
            'item' => $item,
        ], 200); //return data item baru dalam bentuk json
    }

    public function destroy($id)
    {
        $item = Item::find($id); //mencari data item berdasarkan id

        if (is_null($item)) {
            return response([
                'message' => 'Item Not Found',
            ], 404);
        } //return message saat data item tidak ditemukan

        if ($item->delete()) {
            return response([
                'message' => 'Delete Item Success',
                'item' => $item,
            ], 200);
        } //return message saat berhasil menghapus data item

        return response([
            'message' => 'Delete Item Failed',
        ], 400); //return message saat gagal menghapus data item
    }

    public function update(Request $request, $id)
    {
        $item = Item::find($id); //mencari data item berdasarkan id

        if (is_null($item)) {
            return response([
                'message' => 'Item Not Found',
            ], 404);
        } //return message saat data item tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required',
            'gender' => 'required',
            'stock_s' => 'required|numeric',
            'stock_m' => 'required|numeric',
            'stock_l' => 'required|numeric',
            'stock_xl' => 'required|numeric',
            'active' => 'required|boolean',
            'description' => 'required',
            'price' => 'required|numeric',
            'image64' => 'nullable',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        if (isset($updateData['image64']))
            $item->image64 = $updateData['image64'];

        $item->name = $updateData['name'];
        $item->gender = $updateData['gender'];
        $item->stock_s = $updateData['stock_s'];
        $item->stock_m = $updateData['stock_m'];
        $item->stock_l = $updateData['stock_l'];
        $item->stock_xl = $updateData['stock_xl'];
        $item->active = $updateData['active'];
        $item->description = $updateData['description'];
        $item->price = $updateData['price'];

        if ($item->save()) {
            return response([
                'message' => 'Update Item Success',
                'item' => $item,
            ], 200);
        } // return data item yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Item Failed',
        ], 400); // return message saat item gagal di edit
    }
}
