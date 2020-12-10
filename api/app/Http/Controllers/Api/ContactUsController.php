<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\ContactUs;

class ContactUsController extends Controller
{
    public function index()
    {
        $contactUs = ContactUs::all();

        if (count($contactUs) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'contact_us' => $contactUs
            ], 200);
        } //return data semua contactUs dalam bentuk json

        return response([
            'message' => 'No contact Us found',
        ], 404); //return message data contactUs kosong
    }

    public function show($id)
    {
        $contactUs = ContactUs::find($id); //mencari data contactUs berdasarkan id

        if (!is_null($contactUs)) {
            return response([
                'message' => 'Retrieve Contact Us Success',
                'contact_us' => $contactUs
            ], 200);
        } //return data contactUs yang ditemukan dalam bentuk json

        return response([
            'message' => 'Contact Us Not Found',
        ], 404); //return message saat data contactUs tidak ditemukan
    }

    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|digits_between:10,13',
            'message' => 'required|max:255',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 460); //return error invalid input

        $contactUs = ContactUs::create($storeData); //menambah data contactUs baru

        return response([
            'message' => 'Add Contact Us Success',
            'contact_us' => $contactUs,
        ], 200); //return data contactUs baru dalam bentuk json
    }

    public function destroy($id)
    {
        $contactUs = ContactUs::find($id); //mencari data contactUs berdasarkan id

        if (is_null($contactUs)) {
            return response([
                'message' => 'Contact Us Not Found',
            ], 404);
        } //return message saat data contactUs tidak ditemukan

        if ($contactUs->delete()) {
            return response([
                'message' => 'Delete Contact Us Success',
                'contact_us' => $contactUs,
            ], 200);
        } //return message saat berhasil menghapus data contactUs

        return response([
            'message' => 'Delete Contact Us Failed',
        ], 400); //return message saat gagal menghapus data contactUs
    }

    public function update(Request $request, $id)
    {
        $contactUs = ContactUs::find($id); //mencari data contactUs berdasarkan id

        if (is_null($contactUs)) {
            return response([
                'message' => 'Contact Us Not Found',
            ], 404);
        } //return message saat data contactUs tidak ditemukan

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'name' => 'required',
            'email' => 'required|email:rfc,dns',
            'phone' => 'required|digits_between:10,13',
            'message' => 'required|max:255',
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400); // return error invalid input

        $contactUs->name = $updateData['name'];
        $contactUs->email = $updateData['email'];
        $contactUs->phone = $updateData['phone'];
        $contactUs->message = $updateData['message'];

        if ($contactUs->save()) {
            return response([
                'message' => 'Update Contact Us Success',
                'contact_us' => $contactUs,
            ], 200);
        } // return data contactUs yang telah di edit dalam bentuk json

        return response([
            'message' => 'Update Contact Us Failed',
        ], 400); // return message saat contactUs gagal di edit
    }
}
