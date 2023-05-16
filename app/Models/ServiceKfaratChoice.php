<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceKfaratChoice extends Model
{
    use HasFactory;

    protected $fillable = ['service_id','kfarat_choice_id'];

    public function kfaraChoice() {
        return $this->belongsTo('\App\Models\KfaratChoice','kfarat_choice_id','id');
    }

    public function service() {
        return $this->hasOne('\App\Models\Service','id','service_id')->select('id','name_en','name_ar','photo','price','max_limit_by_order','parent_id');
    }
}
