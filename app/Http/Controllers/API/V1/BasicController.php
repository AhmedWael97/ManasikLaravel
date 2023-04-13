<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Gender;
use App\Models\Nationality;
use App\Models\Service;
use App\Models\Job;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;

class BasicController extends Controller
{

    public function getMyAccountDetails() {
        return Auth::user();
    }
    public function getMyBalance() {
        return Auth::user()->wallet;
    }
    public function getCountries() {
        return Country::select(['id','name_ar','name_en','code'])->get();
    }
    public function getCurrency() {
        return Currency::select(['id','name_ar','name_en','symbol'])->get();
    }
    public function getGender() {
        return Gender::select(['id','name_ar','name_en'])->get();
    }
    public function getJob() {
        return Job::select(['id','name_ar','name_en'])->get();
    }
    public function getLangs() {
        return Language::select(['id','name_ar','name_en','code'])->get();
    }
    public function getNationality() {
        return Nationality::select(['id','name_ar','name_en'])->get();
    }
    public function getServices() {
        return Service::get();
    }
}
