<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Service extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name_en','name_ar','photo','max_limit','price','executer_price','earning_points','max_limit_by_order','parent_id','actual_date'];

    public function steps() {
        return $this->hasMany('\App\Models\ServiceStep','service_id','id');
    }

    public function parent () {
        return $this->hasOne('\App\Models\Service','id','parent_id');
    }

    public function kfaratChoices() {
        return $this->hasMany('\App\Models\ServiceKfaratChoice','service_id','id');
    }
}
