<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'name_ar',
        'name_en',
      
    ];

    public function user(){
        return $this->belongsTo('App\Models\User' ,'user_id','id');
    }
}
