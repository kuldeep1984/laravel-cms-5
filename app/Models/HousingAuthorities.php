<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class HousingAuthorities extends Model {
    
    protected $table = 'housing_authorities';
    
    static function getAllAuthorities() {
        $allAuthorities = HousingAuthorities::lists('authority_name', 'id');
        return $allAuthorities;
    }
}
