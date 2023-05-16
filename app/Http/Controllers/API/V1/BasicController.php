<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\ApplicationResponse;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Service;
use App\Models\Job;
use App\Models\KfaratChoice;
use App\Models\Language;
use App\Models\PaymentType;
use App\Models\HajPurpose;
use Illuminate\Support\Facades\Auth;

class BasicController extends Controller
{

     public $response;

    public function __construct()
    {
        $this->response = new ApplicationResponse();
    }

    public function getMyAccountData(Request $request) {
        if($request->user()) {
            return $this->response->successResponse('User',$request->user());
        } else {
            return $this->response->unAuthroizeResponse();
        }
    }
    public function getMyBalance(Request $request) {
        if($request->user()) {
            return $this->response->successResponse('Wallet',$request->user()->wallet);
        } else {
            return $this->response->unAuthroizeResponse();
        }
    }
    public function getCountries() {
        return $this->response->successResponse('Country',Country::select(['id','name_ar','name_en','code'])->get());
    }
    public function getCurrency() {
        return $this->response->successResponse('Currency',Currency::select(['id','name_ar','name_en','symbol'])->get());
    }
    public function getGender() {
        return $this->response->successResponse('Gender',Gender::select(['id','name_ar','name_en'])->get());
    }
    public function getJob() {
        return $this->response->successResponse('Job',Job::select(['id','name_ar','name_en'])->get());
    }
    public function getLangs() {
        return $this->response->successResponse('Language',Language::select(['id','name_ar','name_en','code'])->get());
    }
    public function getNationality() {
        return $this->response->successResponse('Nationality',Nationality::select(['id','name_ar','name_en'])->get());
    }
    public function getServices(Request $request) {
        $services = Service::select('id','name_en','name_ar','photo','price','max_limit_by_order','parent_id')->where('parent_id','0')
        ->with([
        'childern' => function($query) {
            $query->select('id','name_en','name_ar','photo','price','max_limit_by_order','parent_id')->with([
                'kfaratChoices' => function($query) {
                    $query->select('id','service_id','kfarat_choice_id')->with([
                        'kfaraChoice' => function($query) {
                            $query->select('id','name_ar','name_en','menu_image_path');
                        }
                    ]);
                }
            ]);
        },'kfaratChoices' => function($query) {
            $query->select('id','service_id','kfarat_choice_id')->with([
                'kfaraChoice' => function($query) {
                    $query->select('id','name_ar','name_en','menu_image_path');
                }
            ]);
        }])->get();


        if($request->user()) {
            $wallet = \App\Models\Wallet::where('user_id',$request->user()->id)->first();
            $curreny = \App\Models\Currency::where('id',$wallet->currency_id)->first();
            foreach($services as $service) {
                $service->user_amount = $service->price   * $curreny->convert_value;
            }
        } else {
            foreach($services as $service) {
                $service->user_amount = $service->price;
            }
        }
        return $this->response->successResponse('Service', $services);
    }

    public function getKfaratChoices() {
        return $this->response->successResponse('KfaratChoice',
        KfaratChoice::select('id','name_en','name_ar')->with( 'services.service')->get());
    }

    public function getPaymentTypes() {
        return $this->response->successResponse('PaymentType',PaymentType::select('id','name_en','name_ar')->get());
    }

    public function getHajPurpose() {
        return $this->response->successResponse('HajPurpose',HajPurpose::select('id','name_en','name_ar')->get());
    }
}
