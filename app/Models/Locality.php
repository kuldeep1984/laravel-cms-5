<?php

namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model {

    protected $table = 'locality';
    protected $primaryKey = 'LOCALITY_ID';
    
    public function suburb(){
        return $this->belongsTo('app\Models\Suburb', 'SUBURB_ID');
    }


}
