<?php namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model {

	protected $table = 'city';
        
        protected $primaryKey = 'CITY_ID';
        
        public function suburb(){
            return $this->hasMany('app\Models\Suburb');
        }
        
        public function localities(){
            return $this->hasManyThrough('app\Models\Locality', 'app\Models\Suburb');
        }
        
        static public function getCityArray(){
            $cities = Self::Where('status', 'active')->orderBy('LABEL')->lists('LABEL', 'CITY_ID');
            
            return $cities;
        }
        
        

}
