<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'name_ar',
        'gender',
        'birthdate',
        'id_number',
        'work_capacity',
        'instituation_name',
        'job_id',
        'country_id',
        'nationality_id',
        'lang_id',
        'place_of_residence_id',
        'is_active',
        'is_confirmed_executer',
        'photo_path',
        'bank_account_no',
        'bank_branch',
        'bank',
        'account_number',
        'friend_account_number',
        'government_id_path',
        'iban',
        'sos_status',
        'sos_start_date',
        'is_allow_notification',
        'known_by',
        'address',
        'activity_license_image_path',
        'activity_license_number',
        'agency_address',
        'certificate_registration_tax',
        'chamber_of_commerce_registration',
        'commercial_registration_image_path',
        'commercial_registration_no',
        'executer_area',
        'tax_registration_number',
        'user_mange_name',
        'reject_reason',
        'phone',
        'phone_verified_at',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function wallet(){
        return $this->hasOne('\App\Models\Wallet','user_id','id');
    }

    public function country() {
        return $this->hasOne('\App\Models\Country','id','country_id')->select('id','name_ar','name_en');
    }

    public function autoAssign() {
        return $this->hasMany('\App\Models\AutoAssignService','executer_id','id');
    }


}
