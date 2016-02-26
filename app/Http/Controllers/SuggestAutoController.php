<?php

namespace app\Http\Controllers;

use app\Http\Requests;
use app\Http\Controllers\Controller;
use Illuminate\Http\Request;
use app\Models\City;
use app\Models\Locality;
use app\Models\Suburb;
use app\Models\ResiBuilder;
use app\Models\Township;
use DB;

class SuggestAutoController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request) {
        
        if ($request->ajax()) {

            $data = array();

            if ($request->input('type') == 'city') {
                if ($request->input('term') == 'other') {
                    $data[] = array(
                        'label' => 'Other Cities',
                        'value' => 'Other Cities',
                        'city_id' => 'othercities',
                    );
                }

                $cities = City::select('LABEL', 'CITY_ID')
                                ->where('LABEL', 'like', $request->input('term') . '%')
                                ->where('STATUS', 'Active')
                                ->orderBy('LABEL')
                                ->take(10)->get();

                if ($cities) {
                    foreach ($cities as $row) {
                        $data[] = array(
                            'label' => $row->LABEL,
                            'value' => $row->LABEL,
                            'city_id' => $row->CITY_ID
                        );
                    }
                }
            } else if ($request->input('type') == 'builder') {

                $builders = ResiBuilder::select('BUILDER_ID', 'ENTITY')
                                ->where('ENTITY', 'like', $request->input('term') . '%')
                                ->where('builder_status', 1)
                                ->orderBy('entity')
                                ->take(10)->get();
                
               

                if ($builders) {
                    foreach ($builders as $row) {
                        $data[] = array(
                            'label' => $row->ENTITY,
                            'value' => $row->ENTITY,
                            'builder_id' => $row->BUILDER_ID
                        );
                    }
                }
            } else if ($request->input('type') == 'townships') {
                
                $townships = Township::select('id', 'township_name')
                                ->where('township_name', 'like', $request->input('term') . '%')
                                ->orderBy('township_name')
                                ->take(10)->get();
                
                if ($townships) {
                    
                    foreach($townships as $row) {

                        if ($request->input('id') == true) {
                            $data[] = array(
                                'label' => $row->id . " - " . $row->township_name,
                                'value' => $row->id . " - " . $row->township_name,
                                'id' => $row->id
                            );
                        } else {
                            $data[] = array(
                                'label' => $row->township_name,
                                'value' => $row->township_name
                            );
                        }
                    }
                }
            }

            return json_encode($data);
        }
    }

    public function refreshLocality(Request $request) {

        $alllocalities = array();
        $ctid = $request->input('ctid');

        if ($ctid != '') {

            if ($ctid == 'othercities') {
                $other_cities = array_keys(config('cms_constants.Arr_Other_Cities'));
            } else {
                $other_cities = array($ctid);
            }

            $cityLocalities = City::findMany($other_cities);

            $alllocalities = array();
            foreach ($cityLocalities as $locality) {

                if ($ctid == 'othercities') {
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




                $alllocalities = array_merge($alllocalities, $localityArr);
            }
        }
        $alllocalities = array_flip($alllocalities);
        return view('suggestAuto.refreshLocality')->with('alllocalities', $alllocalities)->render();
    }
    
    public function refreshSuburb(Request $request){
        
        if($request->input('loc_id')){
            
            $suburb = Locality::find($request->input('loc_id'))
                    ->suburb()
                    ->select(DB::raw("suburb.label as label, suburb.suburb_id as suburb_id"))
                    ->lists('label','suburb_id');
                        
            return view('suggestAuto.refreshSuburb')->with('suburb', $suburb)->render();
        }
        
    }
    
    public function refreshProjectType(Request $request){
        
        if($request->input('type')){
            
            return view('suggestAuto.refreshProjectType')->with('values', \app\Models\ResiProjectType::getProjectTypesByType($request->input('type')))->render();
            
        }
        
    }
    
    public function getCompanyNamesByTypeTerm(Request $request){
        
        dd($request);
        
    }

}
