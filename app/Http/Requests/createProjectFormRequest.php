<?php

namespace app\Http\Requests;

use app\Http\Requests\Request;

class createProjectFormRequest extends Request {

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
            'txtProjectName' => 'required',
            'builderName' => 'required',
            'builderId' => 'required',
            'cityName' => 'required',
            'cityId' => 'required',
            'localityId' => 'required',
            'suburbId' => 'required',
            'txtProjectDesc' => 'required',
            'txtProjectAddress' => 'required',
            'txtProjectSource' => 'required',
            'project_type' => 'required',
            'Active' => 'required',
            'Status' => 'required',
        ];
    }

    // Here we can do more with the validation instance...
    public function moreValidation($validator) {

        // Use an "after validation hook" (see laravel docs)
        $validator->after(function($validator) {
            
            if($this->input('open_space')){
                
                if($this->input('open_space') > 100 && !empty($this->input('open_space'))){
                    $validator->errors()->add('open_space', 'Open Space must be numeric and less than 100.');
                }
                if($this->input('project_size') > 500  && !empty($this->input('project_size'))){
                    $validator->errors()->add('project_size', 'Project size must be numeric and less than 500.');
                }
                 if($this->input('power_backup_capacity') > 10  && !empty($this->input('power_backup_capacity'))){
                    $validator->errors()->add('project_size', 'Power Backup Capacity must be numeric and less than 10.');
                }
                
            }
           
        });
    }

}
