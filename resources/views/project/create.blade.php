@extends('app')

@section('content')
<script type="text/javascript" src="{{ asset('/js/suggest_auto.js') }}"></script>
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading h1" ><IMG height=18 hspace=5 src="{{URL::asset('images/arrow.gif')}}" width=18>
                    Add New Project                   
                </div>

                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'files' => true, 'route'=>['projects.store']]) !!}

                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <TABLE cellSpacing=2 cellPadding=4 width="93%" align=center border=0>

                        <tr>
                            <td>
                                &nbsp;&nbsp;
                            </td>
                            <td>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li class="error">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>

                        <tr>
                            <td width="30%" align="right"><font color ="red">*</font><b>Project Name :</b> </td>
                            <td width="30%" align="left">
                                <input type="text" name="txtProjectName" id="txtProjectName" value="{{Request::old('txtProjectName')}}" style="width:357px;" />
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b> Builder Name :</b> </td>
                            <td width="30%" align="left">

                                <input type="text" id="builderName" name="builderName" value="{{Request::old('builderName')}}"/>
                                <input type="hidden" name="builderId" class="builderId" value="{{Request::old('builderId')}}">

                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>City :</b> </td>
                            <td width="30%" align="left">
                                <input type="text" id="cityName" name="cityName" value="{{Request::old('cityName')}}"/>
                                <input type="hidden" id="cityId" name="cityId" value="{{Request::old('cityId')}}"/>

                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>Locality :</b> </td>
                            <td width="30%" align="left">
                                <select onchange='update_suburb(this.value)' name="localityId" class="localityId" style="width:230px;">
                                    <option value="">Select Locality</option>

                                </select>
                            </td>
                        </tr>	
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>Suburbs :</b> </td>
                            <td width="30%" align="left">
                                <select name="suburbId" class="suburbId" style="width:230px;" readonly>
                                    <option value="">Select Suburb</option>

                                </select> 
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top">
                                <font color ="red">*</font><b>Project Description :</b> 
                            </td>
                            <td width="30%" align="left">
                                <textarea name="txtProjectDesc" rows="10" cols="45"  class ="myTextEditor" id = "txtProjectDesc">{{Request::old('txtProjectDescription')}}</textarea>
                                <br/><br/>
                                @if(Auth::user()->DEPARTMENT == 'CONTENT' || Auth::user()->DEPARTMENT == 'ADMINISTRATOR')
                                    <input type="checkbox" name="content_flag" @if(Request::old('contentFlag')) checked @endif/> Reviewed?
                                @endif
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        @if(Auth::user()->DEPARTMENT == 'DATAENTRY' || Auth::user()->DEPARTMENT == 'NEWPROJECTAUDIT' || Auth::user()->DEPARTMENT == 'ADMINISTRATOR')
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Project Entry Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="txtProjectRemark" rows="10" cols="45" id = "txtProjectRemark">{{Request::old('txtProjectRemark')}}</textarea>
                            </td>                           
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b>New Project Audit Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="txtNewProjectAuditRemark" rows="10" cols="45" id = "txtNewProjectAuditRemark">{{Request::old('txtNewProjectAuditRemark')}}</textarea>
                            </td>                            
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        @endif
                        @if(Auth::user()->DEPARTMENT == 'CALLCENTER' || Auth::user()->DEPARTMENT == 'ADMINISTRATOR')
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Calling Team Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="txtCallingRemark" rows="10" cols="45" id = "txtCallingRemark">{{Request::old('txtCallingRemark')}}</textarea>
                            </td>                            
                        </tr>                        
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        @endif
                        @if(Auth::user()->DEPARTMENT == 'AUDIT-1' || Auth::user()->DEPARTMENT == 'ADMINISTRATOR')
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Calling-Audit1 Team Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="txtAuditRemark" rows="10" cols="45" id = "txtAuditRemark">{{Request::old('txtAuditRemark')}}</textarea>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        @endif
                        @if(Auth::user()->DEPARTMENT == 'RESALE-CALLCENTER' || Auth::user()->DEPARTMENT == 'ADMINISTRATOR')
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Resale Listings Team Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="secondaryRemark" rows="10" cols="45" id = "secondaryRemark">{{Request::old('secondaryRemark')}}</textarea>
                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        @endif
                        @if(Auth::user()->DEPARTMENT == 'SURVEY' || Auth::user()->DEPARTMENT == 'ADMINISTRATOR')
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Field Survey Team Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="fieldSurveyRemark" rows="10" cols="45" id = "fieldSurveyRemark">{{Request::old('fieldSurveyRemark')}}</textarea>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        @endif
                        @if(Auth::user()->DEPARTMENT == 'AUDIT-1' || Auth::user()->DEPARTMENT == 'ADMINISTRATOR')
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Project Updation Team Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="txtSecondaryAuditRemark" rows="10" cols="45" id = "txtSecondaryAuditRemark">{{Request::old('txtSecondaryAuditRemark')}}</textarea>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>                        
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Audit-2 Team Remark :</b> </td>
                            <td width="30%" align="left">
                                <textarea name="txtAudit2Remark" rows="10" cols="45" id = "txtSecondaryAuditRemark">{{Request::old('txtAudit2Remark')}}</textarea>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        @endif
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>Project Address :</b> </td>
                            <td width="30%" align="left"><input type="text" name="txtProjectAddress" id="txtProjectAddress" value="{{Request::old('$txtAddress')}}" style="width:360px;" /></td>

                        </tr>	
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><b>Project Comments :</b> </td>
                            <td nowrap width="30%" align="left"><input type="text" name="comments" id="comments" value="{{Request::old('comments')}}" style="width:360px;" /><br><span style = "font-size:10px">Like:1bhk,2bhk etc.</span></td> 
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>Source of Information :</b> </td>
                            <td width="30%" align="left"><input type="text" name="txtProjectSource" id="txtProjectSource" value="{{Request::old('txtSourceofInfo')}}" style="width:360px;" /></td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Residential:</b> </td><td width="30%" align="left">
                                <select onchange="update_project_type(this.value)" name="residential" id="residential" class="residential">
                                    <option value="Residential" @if(Request::old('residential') == 'Residential') selected @endif>Residential </option>
                                    <option value="NonResidential" @if(Request::old('residential') == 'NonResidential') selected @endif>Non Residential </option>
                                </select>

                            </td>

                        </tr>	
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>Project type :</b> </td>
                            <td width="30%" align="left">
                                <select name = "project_type" id = "optionType" class = 'optionType'>
                                    <option value =''>Project Type</option>  
                                    @foreach($projectTypes as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </td>                            
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><b>Project Latitude :</b> </td>
                            <td width="30%" align="left"><input type="text" name="txtProjectLattitude" id="txtProjectLattitude" value="{{Request::old('txtProjectLattitude')}}" style="width:360px;" />
                            </td>                            
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><b>Project Longitude :</b> </td>
                            <td width="30%" align="left"><input type="text" name="txtProjectLongitude" id="txtProjectLongitude" value="{{Request::old('txtProjectLongitude')}}" style="width:360px;" /></td>                           
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>Active :</b> </td>
                            <td width="30%" align="left">
                                <select name="Active" id="Active" class="field">
                                    <option value ="" >Select</option>
                                    <option @if(Request::old('Active') == 'Inactive') selected @endif value="Inactive">Inactive on both Website and IS DB</option>
                                    <option @if(Request::old('Active') == 'Active') selected @endif value="Active">Active on both Website and IS DB</option>
                                    <option @if(Request::old('Active') == 'ActiveInCms') selected @endif  value="ActiveInCms">Active In Cms</option>
                                    <option @if(Request::old('Active') == 'ActiveInProptiger') selected @endif  value="ActiveInProptiger">Active In Proptiger</option>
                                    @if(Request::old('Active') == 'ActiveInMakaan')
                                    <option @if(Request::old('Active') == 'ActiveInMakaan') selected @endif  value="ActiveInMakaan">Active In Makaan</option>
                                    @endif
                                    @if(Request::old('Active') == 'Unverified')
                                    <option @if(Request::old('Active') == 'Unverified') selected @endif  value="Unverified">Unverified</option>
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><font color ="red">*</font><b>Project Status :</b> </td>
                            <td width="30%" align="left" valign = "top">
                                <select name="Status" id="Status" class="fieldState">
                                    <option value="">Select</option>
                                    @foreach($projectStatus as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach

                                </select>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Pre - Launch Date :</b> </td>
                            <td width="30%" align="left">
                                <input name="pre_launch_date" value="{{Request::old('pre_launch_date')}}" type="text" class="formstyle2" id="pre_f_date_c_to" size="10" />  <img src="{{URL::asset('images/cal_1.jpg')}}" id="pre_f_trigger_c_to" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Launch Date :</b> </td>
                            <td width="30%" align="left">
                                <input name="eff_date_to" value="{{Request::old('eff_date_to')}}" type="text" class="formstyle2" id="f_date_c_to" value="" size="10" />  <img src="{{URL::asset('images/cal_1.jpg')}}" id="f_trigger_c_to" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Promised Completion Date:</b> </td><td width="30%" align="left">
                                <input name="eff_date_to_prom" value="{{Request::old('eff_date_to_prom')}}" type="text" class="formstyle2" id="f_date_c_prom" value="" size="10" />  <img src="{{URL::asset('images/cal_1.jpg')}}" id="f_trigger_c_prom" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Expected Supply Date :</b> </td>
                            <td width="30%" align="left">
                                <input name="exp_launch_date" value="{{Request::old('exp_launch_date')}}" type="text" class="formstyle2" id="exp_f_date_c_to" size="10" />  <img src="{{URL::asset('images/cal_1.jpg')}}" id="exp_f_trigger_c_to" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b><b>Bank List:</b> </td><td width="30%" align="left">
                                <select name="bank_list[]" id="bank_list" class="field" multiple>
                                    <option value="">Select Bank</option>
                                    @foreach($bankArr as $key => $value)
                                    <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>

                            <td width="32%" align="right" valign ="top"><b>Application form in pdf:</b> </td><td width="30%" align="left">
                                <input type = "file" name = "app_pdf" id="app_pdf" style="" />
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><b>Approvals:</b> </td>
                            <td width="30%" align="left">
                                <input type = "text" name = "approvals" value = "{{Request::old('approvals')}}" style ="width:360px;">
                            </td>                          
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><b>Project Size:</b> </td><td width="30%" align="left">
                                <input type = "text" name = "project_size" id = "project_size" value = "{{Request::old('project_size')}}" style ="width:360px;"  onkeypress='return isNumberKey(event)'><br>
                                <span style = "font-size:10px">in acres</span>
                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right"><b>Open Space:</b> </td><td width="30%" align="left">
                                <input type = "text" name = "open_space" id = "open_space" value = "{{Request::old('open_space')}}" style ="width:360px;"  onkeypress='return isNumberKey(event)'><br>
                                <span style = "font-size:10px">in percentage</span>
                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right"><b>Number Of Towers:</b> </td><td width="30%" align="left">
                                <input type = "text" name = "numberOfTowers" value = "{{Request::old('numberOfTowers')}}" style ="width:360px;"  onkeypress='return isNumberKey(event)'><br>

                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right"><b>Power Backup:</b> </td><td width="30%" align="left">
                                <select name = "powerBackup">
                                    <option value="">Select Power Backup</option>
                                    @foreach($getPowerBackupTypes as $id => $name)
                                    <option value="{{$id}}">{{$name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right"><b>Power Backup Capacity (KVA) :</b> </td><td width="30%" align="left">
                                <input type = "text" name = "power_backup_capacity" id = "power_backup_capacity" value = "{{Request::old('power_backup_capacity')}}" style ="width:360px;"  onkeypress='return isNumberKey(event)'>

                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right"><b>Architect Name:</b> </td><td width="30%" align="left">
                                <input type = "text" name = "architect" id = "architect" value = "{{Request::old('architect')}}" style ="width:360px;">
                            </td>
                            <td width="50%" align="left"><font color="red"></font></td>
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign ="top"><b>Township:</b> </td><td width="30%" align="left">
                                <input type="text" id="townshipName" name="townshipName" value="{{Request::old('townshipName')}}">
                                <input type="hidden" name="township" id="township" value="{{Request::old('township')}}">

                            </td>                                                    
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right" valign ="top"><b>Housing Authority:</b> </td><td width="30%" align="left">
                                <select name = "authority">
                                    <option value="">Select Options</option>
                                    @foreach($allAuthorities as $key => $value)
                                    <option value="{{$id}}">{{$value}}</option>
                                    @endforeach

                                </select>
                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Show price on website ?</b> </td><td width="30%" align="left">

                                <select name="shouldDisplayPrice">
                                    <option value="" @if(Request::old('shouldDisplayPrice') == 1) selected @endif>Yes</option>
                                    <option value="0" @if(Request::old('shouldDisplayPrice') == 0) selected = selected @endif>No</option>
                                </select>

                            </td>                                                
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Construction Contractor: </b></td>
                            <td width="30%" align="left" valign="top">
                                <input type = "text" name = "ConstructionContractor" id = "ConstructionContractor" value = "" style ="width:360px;" data-id="ConstructionContractorId" class="company-type">                                                   
                            </td>                                             
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Maintenance Contractor: </b></td>
                            <td width="30%" align="left" valign="top">
                                <input type = "text" name = "MaintenanceContractor" id = "MaintenanceContractor" value = "" style ="width:360px;" data-id="MaintenanceContractorId" class="company-type">
                            </td>                                                
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign="top"><b>Landscape Architect: </b></td>
                            <td width="30%" align="left" valign="top">
                                <input type = "text" name = "LandscapeArchitect" id = "LandscapeArchitect" value = "" style ="width:360px;" data-id="LandscapeArchitectId" class="company-type">

                            </td>                                                
                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Redevelopment Project: </b> </td><td width="30%" align="left">
                                <input type="checkbox" name="redevelopmentProject" @if(Request::old('redevelopmentProject')) checked @endif />
                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>                                            
                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Resale Project: </b> </td><td width="30%" align="left">
                                <input type="checkbox" value="yes" name="isResaleProject" @if(Request::old('isResaleProject') == "yes") checked @endif />
                            </td>                                                
                        </tr>                                            
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Is Smoothed ?: </b> </td><td width="30%" align="left">                                                       
                                <select name="is_smoothed">                                                            
                                    <option value="0" @if(Request::old('is_smoothed') == 0) selected @endif >No</option>
                                    <option value="1" @if(Request::old('is_smoothed') == 1) selected @endif >Yes</option>
                                </select>
                            </td>

                        </tr>
                        <tr><td colspan='2'>&nbsp;</td></tr>

                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Is Old Age Compatible ?: </b> </td><td width="30%" align="left">
                                <input type="checkbox" name="isOldAgeCompatible" @if(Request::old('isOldAgeCompatible')) checked @endif />
                            </td>                                                
                        </tr>

                        <tr>
                            <td width="20%" align="right" valign ="top"><b> Is Serving ?: </b> </td><td width="30%" align="left">
                                <input type="checkbox" name="isServing" @if(Request::old('isServing')) checked @endif />
                            </td>
                            <td width="50%" align="left"><font color="red"></font></td>
                        </tr>



                        <tr><td colspan='2'>&nbsp;</td></tr>
                        <tr>
                            <td width="20%" align="left"></td>
                            <td width="30%" align="left">
                                <input class="btn" type="submit" name="btnSave" id="btnSave" value="Save">
                                &nbsp;&nbsp;
                                {!! link_to(url('/projectList'), 'Exit', ['class' => 'btn btn-default']) !!} 

                            </td>
                            <td width="50%" align="left"></td>
                        </tr>


                    </TABLE>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    tinyMCE.init({
        //mode : "textareas",
        mode: "specific_textareas",
        editor_selector: "myTextEditor",
        theme: "advanced"
    });
    function update_locality(ctid) {
        $(".suburbId").html('');
        $.ajax({
            type: "GET",
            url: "/refresh-locality?ctid=" + ctid,
            cache: false,
            success: function (html) {
                $(".localityId").html(html);
            }
        });
    }
    function update_suburb(loc_id) {
        $(".suburbId").html('');        
        $.ajax({
            type: "GET",
            url: "/refresh-suburb?loc_id=" + loc_id,
            cache: false,
            success: function (html) {
                $(".suburbId").html(html);
            }
        });
    }
    function update_project_type(type){
        $("#optionType").html('');        
        $.ajax({
            type: "GET",
            url: "/refresh-projectType?type=" + type,
            cache: false,
            success: function (html) {
                $("#optionType").html(html);
            }
        });
    }

    var cals_dict = {
        "pre_f_trigger_c_to": "pre_f_date_c_to",
        "f_trigger_c_prom": "f_date_c_prom",
        "f_trigger_c_to": "f_date_c_to",
        "exp_f_trigger_c_to": "exp_f_date_c_to"
        
    };
    $.each(cals_dict, function (k, v) {
        Calendar.setup({
            inputField: v, // id of the input field
            //    ifFormat       :    "%Y/%m/%d %l:%M %P",         // format of the input field
            ifFormat: "%Y-%m-%d", // format of the input field
            button: k, // trigger for the calendar (button ID)
            align: "Tl", // alignment (defaults to "Bl")
            singleClick: true,
            showsTime: true
        });
    });
</script>

@endsection

