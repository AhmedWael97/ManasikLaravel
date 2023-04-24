<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class OrderDetailStep extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['detail_id','service_step_id','start_in','end_in','step_status_id'];

    public function status() {
        return $this->hasOne('\App\Models\Status','id','step_status_id');
    }
}
