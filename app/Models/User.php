<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Patient;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PatientUserVerificationNotification;
use App\Notifications\PatientUserResetPasswordNotification;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $connection = "mysql_2";

    protected $table = "users";

    protected $fillable=[
        'name', 'email'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PatientUserResetPasswordNotification($token));
    }

    public function sendEmailVerificationNotification()
    {
        $this->notify(new PatientUserVerificationNotification());
    }

    public function socialProviders()
    {
        return $this->hasMany(SocialProvider::class);
    }
    
    public function getPatientAttribute()
    {
        return Patient::where('user_id',$this->id)->first();
    }

    public function getAgeAttribute()
    {
        return Carbon::parse($this->dob)->diff(Carbon::now())->format('%y Years, %m Months and %d days');
    }

    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id');
    }
}
