<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ToDoOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['executer_id','order_detail_id', 'is_confirmed'];

    public function executer () {
        return $this->hasOne('\App\Models\User','id','executer_id');
    }

    public function orderDetails() {
        return $this->hasOne('\App\Model\OrderDetail','id','order_detail_id');
    }
}
