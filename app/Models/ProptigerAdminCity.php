<?php namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ProptigerAdminCity extends Model {

    protected $table = 'proptiger_admin_city';
    public $timestamps = false;
    
    public static function getAdminCitiesIds($adminid){
        
        $adminCities = Self::where('admin_id', '=' ,$adminid)->lists('city_id');
        
        return $adminCities;
        
    }
    
    
}
