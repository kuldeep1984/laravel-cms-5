<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectStage extends Model {

    protected $table = 'master_project_stages';

    static function getProjectStages() {
        $getStages = ProjectStage::lists('name', 'id');
        return $getStages;
    }

    static function getStageByName($stageName) {
        $stageDetail = ProjectStage::where('name', $stageName)->get();
        return $stageDetail;
    }

}
