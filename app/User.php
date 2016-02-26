<?php

namespace app;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proptiger_admin';
    protected $primaryKey = 'ADMINID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['FNAME', 'ADMINEMAIL', 'ADMINPASSWORD', 'USERNAME'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['ADMINPASSWORD', 'remember_token'];
    
    private $rules = array(
        
        'USERNAME' => 'required'
        
    );
    
    public function validate($data)
    {
        // make a new validator object
        $v = Validator::make($data, $this->rules);
        // return the result
        return $v->passes();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword() {
        return $this->attributes['ADMINPASSWORD'];
    }

    public static function getAllUsers() {
        return Self::where('status', 'Y')->orderBy('fname')->lists('fname', 'adminid');
    }
    
}
