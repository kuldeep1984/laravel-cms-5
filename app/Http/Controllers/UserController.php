<?php

namespace app\Http\Controllers;

use app\Http\Requests;
use app\Http\Controllers\Controller;
use app\Models;
//use Illuminate\Http\Request;
use app\User;
use app\Models\City;
use app\Models\ProptigerAdminCity;
use Request;
use Response;
use app\Http\Requests\CreateUserFormRequest;
use app\Http\Requests\UpdateUserRequest;
use GuzzleHttp\Client;

class UserController extends Controller {

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
        
        if (Request::isMethod('post')) {

            $empid = trim(Request::input('empid'));
            $name = Request::input('name');
            $username = Request::input('username');
            $email = Request::input('email');
            $mobile = Request::input('mobile');

            $allUsers = User::query();

            if ($empid) {
                $allUsers = $allUsers->where('EMP_CODE', $empid);
            }
            if ($name) {
                $allUsers = $allUsers->where('fname', 'like', '%' . $name . '%');
            }
            if ($username) {
                $allUsers = $allUsers->where('USERNAME', 'like', '%' . $username . '%');
            }
            if ($email) {
                $allUsers = $allUsers->where('ADMINEMAIL', 'like', '%' . $email . '%');
            }
            if ($mobile) {
                $allUsers = $allUsers->where('MOBILE', 'like', $mobile);
            }

            $allUsers = $allUsers->paginate(30);
        } else {
            $allUsers = User::paginate(30);
        }



        return view('user.index')
                        ->with('users', $allUsers)
                        ->with('regionArray', config('cms_constants.Regions_Office'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {

        return view('user.create')
                        ->with('regionArray', config('cms_constants.Regions_Office'))
                        ->with('departmentArray', config('cms_constants.Department_Array'))
                        ->with('designationArray', config('cms_constants.Designation_Array'))
                        ->with('arrCity', City::getCityArray())
                        ->with('allUsers', User::getAllUsers());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(CreateUserFormRequest $request) {

        if ($request->input('btnSave')) {

            $userID = self::createUser($request->input('txt_email'), $request->input('txt_name'), $request->input('txt_mobile'));

            $user = new User;
            $user->EMP_CODE = $request->input('txt_empcode');
            $user->USER_ID = $userID;
            $user->FNAME = $request->input('txt_name');
            $user->USERNAME = $request->input('txt_username');
            $user->ADMINEMAIL = $request->input('txt_email');
            $user->ADMINPASSWORD = md5($request->input('txt_password'));
            $user->MOBILE = $request->input('txt_mobile');
            $user->REGION = $request->input('region');
            $user->STATUS = $request->input('active');
            $user->DEPARTMENT = $request->input('dept');
            $user->ROLE = $request->input('department');
            $user->JOINING_DATE = $request->input('joiningdate');
            $user->CLOUDAGENT_ID = $request->input('cloudAgentId');
            $user->manager_id = $request->input('manager_id');
            $user->RESIGNATION_DATE = $request->input('resignationdate');

            $user->save();

            //saving admin cities        
            if ($user->DEPARTMENT == 'SURVEY' || $user->DEPARTMENT == 'RESALE' || $user->DEPARTMENT == 'SALES') {
                $cities = $request->input('city');
                $mapped_cities = ProptigerAdminCity::getAdminCitiesIds($user->ADMINID);
                //delete mapped cities
                ProptigerAdminCity::whereIn('CITY_ID', $mapped_cities)->delete();

                //mapp new cities
                if (count($cities) > 0) {
                    foreach ($cities as $mapCity) {
                        if ($mapCity && $mapCity != 'other') {
                            $adminCity = new ProptigerAdminCity;
                            $adminCity->ADMIN_ID = $user->ADMINID;
                            $adminCity->CITY_ID = $mapCity;
                            $adminCity->save();
                        } elseif ($mapCity == 'other') {
                            $other_cities = config('cms_constants.Arr_Other_Cities');
                            foreach ($other_cities as $mapCity) {
                                $adminCity = new ProptigerAdminCity;
                                $adminCity->ADMIN_ID = $id;
                                $adminCity->CITY_ID = $mapCity;
                                $adminCity->save();
                            }
                        }
                    }
                }

                return redirect('/userList')->with('success', 'User ' . $user->FNAME . ' has been created successfully!');
            } else {
                return redirect('/userList');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {

        return view('user.edit')
                        ->with('user', User::find($id))
                        ->with('regionArray', config('cms_constants.Regions_Office'))
                        ->with('departmentArray', config('cms_constants.Department_Array'))
                        ->with('designationArray', config('cms_constants.Designation_Array'))
                        ->with('arrCity', City::getCityArray())
                        ->with('allUsers', User::getAllUsers())
                        ->with('adminCities', ProptigerAdminCity::getAdminCitiesIds($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, UpdateUserRequest $request) {

        if ($request->input('btnSave')) {
            $user = User::find($id);
            $user->EMP_CODE = $request->input('txt_empcode');
            $user->FNAME = $request->input('txt_name');
            $user->USERNAME = $request->input('txt_username');
            $user->ADMINEMAIL = $request->input('txt_email');
            $user->MOBILE = $request->input('txt_mobile');
            $user->REGION = $request->input('region');
            $user->STATUS = $request->input('active');
            $user->DEPARTMENT = $request->input('dept');
            $user->ROLE = $request->input('department');
            $user->JOINING_DATE = $request->input('joiningdate');
            $user->CLOUDAGENT_ID = $request->input('cloudAgentId');
            $user->manager_id = $request->input('manager_id');
            $user->RESIGNATION_DATE = $request->input('resignationdate');

            $user->save();

            //saving admin cities        
            if ($user->DEPARTMENT == 'SURVEY' || $user->DEPARTMENT == 'RESALE' || $user->DEPARTMENT == 'SALES') {
                $cities = $request->input('city');
                $mapped_cities = ProptigerAdminCity::getAdminCitiesIds($id);
                //delete mapped cities
                ProptigerAdminCity::whereIn('CITY_ID', $mapped_cities)->delete();

                //mapp new cities
                if (count($cities) > 0) {
                    foreach ($cities as $mapCity) {
                        if ($mapCity && $mapCity != 'other') {
                            $adminCity = new ProptigerAdminCity;
                            $adminCity->ADMIN_ID = $id;
                            $adminCity->CITY_ID = $mapCity;
                            $adminCity->save();
                        } elseif ($mapCity == 'other') {
                            $other_cities = config('cms_constants.Arr_Other_Cities');
                            foreach ($other_cities as $mapCity) {
                                $adminCity = new ProptigerAdminCity;
                                $adminCity->ADMIN_ID = $id;
                                $adminCity->CITY_ID = $mapCity;
                                $adminCity->save();
                            }
                        }
                    }
                }

                return redirect('/userList')->with('success', 'User ' . $user->FNAME . ' has been updated successfully!');
            } else {
                return redirect('/userList');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public static function createUser($email, $contact_name, $mobile) {

        try {
            $client = new Client();

            $url_register = getenv('USER_API_URL');
            $adminEmail = trim($email);
            $data["fullName"] = trim($contact_name);
            $data["password"] = getenv('RESALE_USER_TOKEN');
            $data["confirmPassword"] = $data["password"];
            $data["email"] = "cms_user_" . $adminEmail;
            $data["countryId"] = "1";
            $data["contactNumbers"] = array(array("contactNumber" => trim($mobile)));

            $response = $client->request('POST', $url_register, [
                'json' => $data
            ]);

            $body = json_decode($response->getBody(), true);

            $user_id = 0;
            if ($body['data']) {
                $user_id = $body['data']['id'];
            }
            return $user_id;
        } catch (Exception $e) {
            return 0;
        }
    }

}
