<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Doctor extends Authenticatable
{
    use Notifiable;
    
    // User types
    const PATIENT = 1;
    const DOCTOR = 2;
    const ADMIN = 3;
    
    // Salutations
    const MR = 0;
    const MS = 1;
    const DR = 2;
    const PROF = 3;
    
    const DP_PREFIX = "https://s3.ap-south-1.amazonaws.com/meldoc-test/dp/";
    
    // protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function routeNotificationForAwsSnsSms()
    {
        return "+91".$this->phone;
    }
    
    public static function get_salutation($salutation) {
        if(strncasecmp($salutation, "prof", 4) == 0)
            return Doctor::PROF;
        if(strncasecmp($salutation, "dr", 2) == 0)
            return Doctor::DR;
        if(strncasecmp($salutation, "ms", 2) == 0)
            return Doctor::MS;
        return Doctor::MR;
    }
    
    public static function getUser($email, $password = null) {
        if($password == null)
            return Doctor::where('email', $email)->first();
        return Doctor::where('email', $email)->where('password', Hash::make($password))->first();
    }
    
    public static function getUserFromId($meldoc_id) {
        return Doctor::find($meldoc_id);
    }
    
    public function changePassword($password) {
        $this->password = Hash::make($password);
        $this->save();
    }
    
    public static function createUser( $email, $password,
                                      $first_name, $last_name,
                                      $salutation, $phone) {
        $user = new Doctor();
        $user->email = $email;
        $user->phone = trim($phone);
        $user->password = Hash::make($password);
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->picture = null;
        $user->salutation = Doctor::get_salutation($salutation);
        $user->is_deleted = false;
        $user->is_disabled = false;
        $user->is_edited = true;
        $user->is_active = false;
        $user->phone_token = strval(rand(10000,99999));
        $user->email_token = strval(rand(10000, 99999));

        try {
            $user->save();
        } catch(QueryException $ex) {
            //dd($ex);
            return $ex;
        }
        return $user;
        
    }
    
    public static function makeUserLive($user, $live = true) {
        $user->is_active = $live;
        // TODO: Remove this to avoid multiple validations
        // $user->phone_token = null;
        // $user->email_token = null;
        $user->save();
    }
    
    public function updateProfileImage($image) {
        $this->picture = $image;
        $this->save();
    }

    public static function updateDocOtp($user) {
        $user->phone_token = strval(rand(10000,99999));
        $user->email_token = strval(rand(10000,99999));
        $user->save();
        //$this->save();
    }

    public static function updateDocPwd($user,$password) {
        $user->password = Hash::make($password);
        $user->save();
        //$this->save();
    }

    public function email_ph_details($email,$phone){

        return Doctor::where('email', $email)->orWhere('phone', $phone)->first();
    }



}
