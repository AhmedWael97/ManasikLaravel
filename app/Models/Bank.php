<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['name_ar', 'name_en'];

    public function branches() {
        return $this->hasMany(BankBarnch::class,'bank_id','id');
    }
}
