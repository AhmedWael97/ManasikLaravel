<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class HajPurpose extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['user_id','name_en','name_ar'];

    public function user() {
        return $this->hasOne('\App\Models\User','id','user_id');
    }
}
