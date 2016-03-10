<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class UpdationCycle extends Model {

    protected $table = 'updation_cycle';

    static function updationCycleTable() {
        $updationCycleList = UpdationCycle::select(DB::raw("CONCAT(CYCLE_TYPE, 'Cycle - ', LABEL) as label, UPDATION_CYCLE_ID"))->lists('label', 'UPDATION_CYCLE_ID');
                
        return $updationCycleList;
    }

}
