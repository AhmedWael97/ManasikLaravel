<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class WalletTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['wallet_id','amount','currency_id','is_transfered','transfer_from','transfer_to','reason','refer_order_id'];

    public function from() {
        return $this->hasOne('\App\Models\User','id','transfer_from')->select('id','name','name_ar');
    }

    public function to() {
        return $this->hasOne('\App\Models\User','id','transfer_to')->select('id','name','name_ar');
    }

    public function currency() {
        return $this->hasOne('\App\Models\Currency','id','currency_id')->select('id','name_ar','name_en');
    }
}
