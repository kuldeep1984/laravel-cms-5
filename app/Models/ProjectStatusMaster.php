<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStatusMaster extends Model {

    protected $table = 'project_status_master';

    static function projectStatusMaster() {
        
        $arrStatus = ProjectStatusMaster::lists('display_name', 'id');
        
        return $arrStatus;
    }

}
