<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class KfaratChoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name_en', 'name_ar', 'image', 'menu_image_path'];

    public function services() {
        return $this->hasMany('\App\Models\ServiceKfaratChoice','kfarat_choice_id','id');
    }
}
