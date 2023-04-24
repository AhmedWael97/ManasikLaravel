<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;
    protected $fillable = ['order_id','service_id','order_status_id','full_name','no_of_kfara','price','currency_id','price','executer_price','no_of_kfara','kfarat_choice_id','purpose_hag_id'];
}
