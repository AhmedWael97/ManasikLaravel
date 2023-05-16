<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutoAssignService extends Model
{
    use HasFactory;

    protected $fillable = ['executer_id','service_id','auto_assign','maxCount'];
}
