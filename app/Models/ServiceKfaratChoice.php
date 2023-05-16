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
}
