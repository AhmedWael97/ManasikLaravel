<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['main_service_id','payment_type_id','payment_status_id'];

    public function mainService() {
        return $this->hasOne('\App\Models\Service','id','main_service_id');
    }

    public function user() {
        return $this->hasOne('\App\Models\User','id','user_id');
    }

    public function paymentType() {
        return $this->hasOne('\App\Models\PaymentType','id','payment_type_id');
    }

    public function status() {
        return $this->hasOne('\App\Models\Status','id','order_status_id');
    }
}
