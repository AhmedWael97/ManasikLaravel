<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','service_id','order_status_id','full_name','no_of_kfara','price','currency_id','price','executer_price','no_of_kfara','kfarat_choice_id','purpose_hag_id'];

    public function service() {
        return $this->hasOne('\App\Models\Service','id','service_id')->select('id','name_en','name_ar','photo','max_limit','price');
    }

    public function hajPurpose() {
        return $this->hasOne('\App\Models\HajPurpose','id','purpose_hag_id');
    }

    public function KfaraChoice() {
        return $this->hasOne('\App\Models\KfaratChoice','id','kfarat_choice_id');
    }

    public function steps() {
        return $this->hasMany('\App\Models\OrderDetailStep','detail_id','id');
    }

    public function order() {
        return $this->belongsTo('\App\Models\Order','order_id','id');
    }
}
