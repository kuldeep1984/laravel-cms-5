<?php

namespace app\Http\Requests;

use app\Http\Requests\Request;

class CreateUserFormRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'txt_empcode' => "required|unique:proptiger_admin,EMP_CODE",
            'txt_username' => "required|unique:proptiger_admin,USERNAME",
            'txt_name' => "required",
            'txt_email' => 'required|unique:proptiger_admin,ADMINEMAIL',
            'txt_mobile' => 'required',
            'txt_username' => 'required',
            'txt_password' => 'required',
            'region' => 'required',
            'dept' => 'required', //department
            'department' => 'required', //role
            'active' => 'required',
            
            
            
        ];
    }

    public function messages() {
        return [
            'txt_empcode.required' => 'Employee Code is rquired!',
            'txt_username.required' => 'User Name is required!',
            'active.required' => 'Status required',
            'txt_password.required' => 'Password is required!'
            
        ];
    }

}
