<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectPhase extends Model {

    protected $table = 'master_project_phases';

    static function getProjectPhases() {
        $getPhases = ProjectPhase::where('name', '!=' ,'revert')->lists('name', 'id');
        return $getPhases;
    }

    static function getPhaseByName($phaseName) {
        $phaseDetail = ProjectPhase::where('name', $phaseName)->lists('name', 'id');
        return $phaseDetail;
    }

}
