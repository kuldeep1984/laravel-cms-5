<?php namespace app\Models;

use Illuminate\Database\Eloquent\Model;

class ResiProject extends Model {

	protected $table = 'resi_project';
        protected $primary_key = 'project_id';
        
        public $timestamps = false;

}
