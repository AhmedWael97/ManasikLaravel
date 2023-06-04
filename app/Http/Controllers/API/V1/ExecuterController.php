<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicationResponse;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ExecuterController extends Controller
{
    public $response;

    public function __construct()
    {
        $this->response = new ApplicationResponse();
    }

    public function getMyInfo(Request $request){
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::where('id',$request->user()->id)->first();
        if(! $user->roles[0]->hasPermissionTo('Executer_Mobile_Application')) {
            return $this->response->noPermission();
        }

        $user->photo_path =  url('/images/photos/')  . $user->photo_path;
        $user->government_id_path = url('images/govs') . $user->government_id_path;
        $user->activity_license_image_path = url('/images/act') . $user->activity_license_image_path;
        $user->certificate_registration_tax = url('images/crt') . $user->certificate_registration_tax;
        $user->government_id_path = url('images/chamber') . $user->chamber_of_commerce_registration;
        $user->commercial_registration_image_path = url('images/comm') . $user->commercial_registration_image_path;


        return $this->response->successResponse('User',$user);
    }

    public function updateMyInfo(Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }


        $errors = [];

        $user = User::findOrFail($request->user()->id);

        if($request->has('name')) {
            $user->name = $request->name;
        }

        if($request->has('name_ar')) {
            $user->name_ar = $request->name_ar;
        }

        if($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        if($request->has('phone')){
            if(User::where(['phone'=>$request->phone, ['id' , '<>' ,$user->id]])->first()) {
                $errors[] = translate('Phone Is Already Taken');
            } else {
                $user->phone = $request->phone;
            }

        }

        if($request->has('email')){
            if(User::where(['email'=>$request->phone, ['id' , '<>' ,$user->id]])->first()) {
                $errors[] = translate('Email Is Already Taken');
            } else {
                $user->email = $request->email;
            }

        }

        if($request->has('id_number')){
            $user->id_number = $request->id_number;
        }

        if($request->has('user_mange_name')){
            $user->user_mange_name = $request->user_mange_name;
        }

        if($request->has('executer_area')){
            $user->executer_area = $request->executer_area;
        }

        if($request->has('commercial_registration_no')){
            $user->commercial_registration_no = $request->commercial_registration_no;
        }

        if($request->has('activity_license_number')){
            $user->activity_license_number = $request->activity_license_number;
        }

        if($request->has('tax_registration_number')){
            $user->tax_registration_number = $request->tax_registration_number;
        }

        if($request->has('instituation_name')){
            $user->instituation_name = $request->instituation_name;
        }

        if($request->has('agency_address')){
            $user->agency_address = $request->agency_address;
        }

        if($request->has('photo_path')) {
            $imageName = 'photo_'.time().'.'.$request->photo_path->extension();
            $request->photo_path->move(public_path('images/photos'), $imageName);
            $user->photo_path = $imageName ;
        }

        if($request->has('government_id_path')) {
            $imageName = 'gov_'.time().'.'.$request->government_id_path->extension();
            $request->government_id_path->move(public_path('images/govs'), $imageName);
            $user->government_id_path = $imageName ;
        }

        if($request->has('activity_license_image_path')) {
            $imageName = 'act_'.time().'.'.$request->activity_license_image_path->extension();
            $request->activity_license_image_path->move(public_path('images/act'), $imageName);
            $user->activity_license_image_path = $imageName ;
        }

        if($request->has('commercial_registration_image_path')) {
            $imageName = 'comm_'.time().'.'.$request->commercial_registration_image_path->extension();
            $request->commercial_registration_image_path->move(public_path('images/comm'), $imageName);
            $user->commercial_registration_image_path = $imageName ;
        }

        if($request->has('chamber_of_commerce_registration')) {
            $imageName = 'chamber_'.time().'.'.$request->chamber_of_commerce_registration->extension();
            $request->chamber_of_commerce_registration->move(public_path('images/chamber'), $imageName);
            $user->chamber_of_commerce_registration = $imageName ;
        }

        if($request->has('certificate_registration_tax')) {
            $imageName = 'crt_'.time().'.'.$request->certificate_registration_tax->extension();
            $request->certificate_registration_tax->move(public_path('images/crt'), $imageName);
            $user->certificate_registration_tax = $imageName ;
        }

        $user->save();
        return $this->successResponse('Info',$errors[]);
    }

    public function updateMyBankInfo (Request $request) {
        if($request->user() == null) {
            return $this->response->unAuthroizeResponse();
        }

        $user = User::findOrFail($request->user()->id);

        if($request->has('bank')) {
            $user->bank = $request->bank;
        }

        if($request->has('iban')) {
            $user->iban = $request->iban;
        }

        if($request->has('bank_branch')) {
            $user->bank_branch = $request->bank_branch;
        }


        $user->save();
        return $this->successResponse('Info', 'Success');
    }
}
