<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ServiceStep extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['service_id' , 'name_en', 'name_ar' , 'photo', 'min_time_in_minute', 'max_time_in_minute'];
}
