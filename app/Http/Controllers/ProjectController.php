<?php

namespace app\Http\Controllers;

use app\Http\Requests;
use app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Models\ProjectStage;
use app\Models\UpdationCycle;
use app\Models\ProjectPhase;
use app\Models\HousingAuthorities;
use app\Models\ProjectStatusMaster;
use app\Models\City;
use DB;
use Session;
use Auth;

class ProjectController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        
        $projects = array();
        $localities = array();
        $errors = '';
        

        if ($request->isMethod('post')) {

            if ($request->input('exp_supply_date_from') && $request->input('exp_supply_date_to')) {
                if (strtotime($request->input('exp_supply_date_from')) > strtotime($request->input('exp_supply_date_to'))) {
                    $errors = 'Expected Supply To Date must be greater than Expected Supply From Date.';
                }
            }
            
            if (!$errors) {

                $projects = DB::table('resi_project')
                        ->select('resi_project.*', 'resi_project_phase.PHASE_ID as no_phase_id', 'resi_builder.builder_name', 'master_project_phases.name as phase_name', 'master_project_stages.name as stage_name', 'updation_cycle.LABEL as updation_cycle', 'taResale.attribute_value as is_resale')
                        ->join('resi_project_phase', function($join) {
                            $join->on('resi_project.project_id', '=', 'resi_project_phase.project_id')
                            ->where('resi_project_phase.version', '=', 'Cms')
                            ->where('resi_project_phase.phase_type', '=', 'Logical');
                        })
                        ->leftJoin('resi_builder', 'resi_project.builder_id', '=', 'resi_builder.builder_id')
                        ->leftJoin('master_project_phases', 'resi_project.project_phase_id', '=', 'master_project_phases.id')
                        ->leftJoin('master_project_stages', 'resi_project.project_stage_id', '=', 'master_project_stages.id')
                        ->leftJoin('locality', 'resi_project.locality_id', '=', 'locality.locality_id')
                        ->leftJoin('suburb', 'locality.suburb_id', '=', 'suburb.suburb_id')
                        ->leftJoin('city', 'suburb.city_id', '=', 'city.city_id')
                        ->leftJoin('updation_cycle', 'resi_project.UPDATION_CYCLE_ID', '=', 'updation_cycle.UPDATION_CYCLE_ID')
                        ->leftJoin('table_attributes as ta', function($join) {
                            $join->on('ta.table_id', '=', 'resi_project.PROJECT_ID')
                            ->where('ta.table_name', '=', 'resi_project')
                            ->where('ta.attribute_name', '=', 'HOUSING_AUTHORITY_ID');
                        })
                        ->leftJoin('table_attributes as taResale', function($join) {
                            $join->on('taResale.table_id', '=', 'resi_project.PROJECT_ID')
                            ->where('taResale.table_name', '=', 'resi_project')
                            ->where('taResale.attribute_name', '=', 'is_resale_project');
                        })
                        ->where('resi_project.version', '=', 'Cms')
                        ->whereNotIn('locality.status', ['Unverified', 'ActiveInMakaan'])
                        ->orderBy('resi_project.project_id', 'DESC');

                if ($request->input('projectId') && $request->input('projectId')) {
                    $projects = $projects->whereNotIn('resi_project.status', ['Unverified', 'Dummy']);
                } else {
                    $projects = $projects->whereNotIn('resi_project.status', ['ActiveInMakaan', 'Unverified', 'Dummy']);
                }

                if ($request->input('projectId')) {
                    $projects = $projects->where('resi_project.project_id', '=', $request->input('projectId'));
                }

                if ($request->input('city')) {
                    $projects = $projects->where('city.city_id', '=', $request->input('city'));

                    if ($request->input('cityName') == 'othercities') {
                        $other_cities = array_keys(config('cms_constants.Arr_Other_Cities'));
                    } else {
                        $other_cities = array($request->input('city'));
                    }
                    $cityLocalities = City::findMany($other_cities);

                    $localities = array();
                    foreach ($cityLocalities as $locality) {

                        if ($request->input('cityName') == 'othercities') {
                            $localityArr = $locality->localities()
                                    ->where('locality.status', 'Active')
                                    ->select(DB::raw("CONCAT(locality.label, ' - ', '" . $locality->LABEL . "') as label, locality_id"))
                                    ->lists('locality_id', 'label');
                        } else {
                            $localityArr = $locality->localities()
                                    ->where('locality.status', 'Active')
                                    ->select(DB::raw("locality.label as label, locality.locality_id as locality_id"))
                                    ->orderBy("label")
                                    ->lists('locality_id', 'label');
                        }

                        $localities = array_merge($localities, $localityArr);
                    }
                    $localities = array_flip($localities);
                }

                if ($request->input('locality')) {
                    $projects = $projects->where('resi_project.locality_id', '=', $request->input('locality'));
                }
                if ($request->input('builder')) {
                    $projects = $projects->where('resi_project.builder_id', '=', $request->input('builder'));
                }
                if ($request->input('stage')) {
                    $projects = $projects->where('resi_project.project_stage_id', '=', $request->input('stage'));
                }
                if ($request->input('updationCycle')) {
                    $projects = $projects->where('resi_project.updation_cycle_id', '=', $request->input('updationCycle'));
                }
                if ($request->input('phase')) {
                    $projects = $projects->where('resi_project.project_phase_id', '=', $request->input('phase'));
                }
                if ($request->input('Availability')) {
                    if (in_array(1, $request->input('Availability')))
                        $projects = $projects->where('resi_project.D_AVAILABILITY', '=', 0);
                    if (in_array(2, $request->input('Availability')))
                        $projects = $projects->where('resi_project.D_AVAILABILITY', '>', 0);
                    if (in_array(3, $request->input('Availability')))
                        $projects = $projects->whereNull('resi_project.D_AVAILABILITY');
                }
                if ($request->input('Residential')) {
                    $projects = $projects->where('resi_project.residential_flag', '=', $request->input('Residential'));
                }
                if ($request->input('townshipId')) {
                    $projects = $projects->where('resi_project.township_id', '=', $request->input('townshipId'));
                }
                if ($request->input('authorityId')) {
                    $projects = $projects->where('ta.attribute_value', 'like', $request->input('authorityId'));
                }
                if ($request->input('Active')) {
                    $projects = $projects->whereIn('resi_project.STATUS', $request->input('Active'));
                }
                if ($request->input('Status')) {
                    $projects = $projects->whereIn('resi_project.project_status_id', $request->input('Status'));
                }
                if ($request->input('exp_supply_date_from') && $request->input('exp_supply_date_to')) {
                    $projects = $projects->whereIn('resi_project.EXPECTED_SUPPLY_DATE', [$request->input('exp_supply_date_from'), $request->input('exp_supply_date_to')]);
                }


                $projects = $projects->paginate(30);
            }
        }

        return view('project.index')
                        ->with('getProjectStages', ProjectStage::getProjectStages())
                        ->with('UpdationArr', UpdationCycle::updationCycleTable())
                        ->with('getProjectPhases', ProjectPhase::getProjectPhases())
                        ->with('arrAuthorityDetail', HousingAuthorities::getAllAuthorities())
                        ->with('projectStatus', ProjectStatusMaster::projectStatusMaster())
                        ->with('localities', $localities)
                        ->with('projects', $projects)
                        ->with('errors', $errors);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('project.create')
                ->with('projectTypes', \app\Models\ResiProjectType::getProjectTypesByType('Residential'))
                ->with('projectStatus', ProjectStatusMaster::projectStatusMaster())
                ->with('bankArr', \app\Models\BankList::lists('BANK_NAME', 'BANK_ID'))
                ->with('getPowerBackupTypes', \app\Models\PowerBackupTypes::lists('name', 'id'))
                ->with('allAuthorities', \app\Models\HousingAuthorities::getAllAuthorities());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request) {
        dd($request->all());
        return ('stroe');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        return ('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
