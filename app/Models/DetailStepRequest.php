<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailStepRequest extends Model
{
    use HasFactory;

    protected $fillable = ['order_detail_step_id', 'type' ,'response'];

}
