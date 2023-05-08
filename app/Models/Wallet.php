<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'amount' ,'currency_id'];

    public function currency() {
        return $this->hasOne('\App\Models\Currency','id','currency_id')->select('id','name_ar','name_en','symbol');
    }

    public function user() {
        return $this->belongsTo('\App\Models\User','user_id','id');
    }
}
