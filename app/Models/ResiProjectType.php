<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ResiProjectType extends Model {

    protected $table = 'resi_project_type';
    protected $primaryKey = 'PROJECT_TYPE_ID';

    public static function getProjectTypesByType($type) {
        
        if($type == 'Residential'){//residentials types
            
            $projectTypes = Self::where('PROJECT_TYPE_ID', '<', '7')->lists('TYPE_NAME', 'PROJECT_TYPE_ID');
            
            
        }else{ //non residential types
            
            $projectTypes = Self::where('PROJECT_TYPE_ID', '>', '7')->lists('TYPE_NAME', 'PROJECT_TYPE_ID');
            
        }
        
        return $projectTypes;        
        
    }

}
