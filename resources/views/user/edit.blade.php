@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading h1" ><IMG height=18 hspace=5 src="{{URL::asset('images/arrow.gif')}}" width=18>
                    Edit User                   
                </div>

                <div class="panel-body">
                    {!! Form::open(['method' => 'PATCH','route'=>['users.update',$user->ADMINID]]) !!}
                    <form  id="frmusermgt" name="frmusermgt" action="{{url('/users/'.$user->ADMINID)}}">
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
                                <td width="20%" align="right" >*Employee Code : </td>
                                <td width="30%" align="left" ><input type="text" name="txt_empcode" id="txt_empcode" value="{{$user->EMP_CODE}}" style="width:220px;"></td>

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right" >*Contact Name : </td>
                                <td width="30%" align="left" ><input type="text" name="txt_name" id="txt_name" value="{{$user->FNAME}}" style="width:220px;"></td>

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right" >*Email Address : </td>
                                <td width="30%" align="left"><input type="text" name="txt_email" id="txt_email" value="{{$user->ADMINEMAIL}}" style="width:220px;"></td>
                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right" valign="top">*Mobile No. : </td>
                                <td width="30%" align="left" ><input type="text" name="txt_mobile" id="txt_mobile" value="{{$user->MOBILE}}" style="width:220px;"></td>

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right" >*UserName : </td>
                                <td width="30%" align="left" ><input type="text" name="txt_username" id="txt_username" value="{{$user->USERNAME}}" style="width:220px;"></td>

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>

                            <tr>
                                <td width="20%" align="right">Password: </td>
                                <td width="30%" align="left"><input type="password" name="txt_password" id="txt_password" value="{{$user->ADMINPASSWORD}}" style="width:220px;">

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>

                            <tr>
                                <td width="20%" align="right">*Region : </td>
                                <td width="30%" align="left" >

                                    <select name="region"  id="region" class="field" style="width:222px;" onchange="selectedCityByRegion(this.value)">
                                        <option value="">Select </option>
                                        @foreach($regionArray as $k => $v)
                                        <option value='{{$k}}' @if($user->REGION == $k) selected @endif>{{$v}}</option>
                                        @endforeach

                                    </select>
                                </td>

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right">*Department : </td>
                                <td width="30%" align="left" >

                                    <select name="dept" id="dept" style="width:222px;" onchange="showHideCity(this.value);">
                                        <option value="">Select </option>

                                        @foreach($departmentArray as $k => $v)
                                        <option value ='{{$k}}' @if($user->DEPARTMENT == $k)selected @endif>{{$v}}</option>
                                        @endforeach

                                    </select>

                                </td>

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right">*Role : </td>
                                <td width="30%" align="left" >

                                    <select name="department"  id="department" class="field" style="width:222px;" onchange="showHideCity($('#dept').val());
                                            hideBlockFunc(this.value);">
                                        <option value="">Select </option>

                                        @foreach($designationArray as $k => $v)
                                        <option value ='{{$k}}' @if($user->ROLE == $k) selected @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr id = 'showhide'>
                                <td width="20%" align="right" valign = "top">Mapped City : </td>
                                <td width="30%" align="left" >
                                    <select name="city[]" multiple="" style="width:220px;">
                                        <option value="">Select City</option>
                                        @foreach($arrCity as $key => $item)
                                        <option value="{{$key}}" @if(in_array($key,$adminCities))selected @endif>{{$item}}</option>
                                        @endforeach}
                                        <option value="other" >All Other Cities</option>
                                    </select>
                                </td>
                                <td width="50%" align="left"></td>
                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right">Manager ID :</td>
                                <td width="30%" align="left" >

                                    <select name="manager_id"  id="manager_id" class="field" style="width:222px;">
                                        <option value="">Select </option>

                                        @foreach($allUsers as $k => $v)
                                        <option  value ='{{$k}}' @if($user->MANAGER_ID == $k) selected @endif>{{$v}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="right" >Joining Date : </td>
                                <td width="30%" align="left" >
                                    <input name="joiningdate"  type="text" class="formstyle2" id="joiningdate"  value="{{$user->JOINING_DATE}}" size="8" readonly style="width:200px">  <img src="{{URL::asset('images/cal_1.jpg')}}" id="f_trigger_start" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                                </td>

                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>

                            <tr>
                                <td width="20%" align="right" >Resignation Date : </td>
                                <td width="30%" align="left" ><input name="resignationdate"  type="text" class="formstyle2" id="resignationdate"  value="{{$user->RESIGNATION_DATE}}" size="8" readonly style="width:200px">  <img src="{{URL::asset('images/cal_1.jpg')}}" id="f_trigger_end" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                                </td>
                            </tr>

                            <tr><td colspan='2'>&nbsp;</td></tr>

                            <tr style="dispaly:none" class="pt_changestatus">
                                <td width="20%" align="right">*Status : </td>
                                <td width="30%" align="left">

                                    <input type="radio" name="active" id="activebtn" value="Y" @if($user->STATUS == 'Y') checked @endif >&nbsp;Active &nbsp;&nbsp;
                                           <input type="radio" name="active" id="unactivebtn" value="N" @if($user->STATUS == 'N') checked @endif >&nbsp;Deactive
                                </td>
                            </tr>

                            <tr><td colspan='2'>&nbsp;</td></tr>

                            <tr>
                                <td width="20%" align="right" >Cloud Agent Id : </td>
                                <td width="30%" align="left" >
                                    <input type="text" name="cloudAgentId" id="cloudAgentId" value="{{$user->CLOUDAGENT_ID}}" style="width:220px;"></td>
                                <td width="50%" align="left"></td>
                            </tr>
                            <tr><td colspan='2'>&nbsp;</td></tr>
                            <tr>
                                <td width="20%" align="left"></td>
                                <td width="30%" align="left">
                                    <input type="submit" name="btnSave" id="btnSave" value="Save">
                                    &nbsp;&nbsp;
                                    {!! link_to(url('/userList'), 'Exit', ['class' => 'btn btn-default']) !!}
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

    Calendar.setup({
        inputField: "joiningdate", // id of the input field
        ifFormat: "%Y-%m-%d", // format of the input field
        button: "f_trigger_start", // trigger for the calendar (button ID)
        align: "Tl", // alignment (defaults to "Bl")
        singleClick: true,
        showsTime: true

    });

    Calendar.setup({
        inputField: "resignationdate", // id of the input field
        ifFormat: "%Y-%m-%d", // format of the input field
        button: "f_trigger_end", // trigger for the calendar (button ID)
        align: "Tl", // alignment (defaults to "Bl")
        singleClick: true,
        showsTime: true

    });

</script>
<script type="text/javascript">

//function for show hide department only display city list when department is survey
    $(document).ready(function () {
        var role = "{{$user->ROLE}}";
        var department = "{{$user->DEPARTMENT}}";

        if (department == 'SURVEY' || department == 'RESALE' || (role == 'focusProjects' && department == 'SALES')) {
            jQuery("#showhide").show();
        } else {
            jQuery("#showhide").hide();
        }
    });
    function showHideCity(department) {

        var role = jQuery("#department").val();

        if (department == 'SURVEY' || department == 'RESALE' || (role == 'focusProjects' && department == 'SALES')) {
            jQuery("#showhide").show();
        } else {
            jQuery("#showhide").hide();
        }
    }
    jQuery(document).ready(function () {

        jQuery("#txt_username").blur(function () {

            var username = jQuery("#txt_username").val();
            username = username.trim();

            if (username == '') {
                jQuery("#errmsg").show();
                jQuery("#errmsg").html('<font color = "red">Username cann\'t be left blank.</font>');
                return false;

            }

            jQuery.ajax({
                type: "POST",
                url: 'ajax/checkUserName.php',
                data: "username=" + username,
                success: function (resonsedata) {

                    if (resonsedata > 0) {
                        jQuery("#errmsg").show();
                        jQuery("#errmsg").html('<font color = "red">Username <b>' + username + '</b> already exist.</font>');
                    } else {
                        jQuery("#errmsg").show();
                        jQuery("#errmsg").html('<font color = "green">Username <b>' + username + '</b> available.</font>');
                    }
                }

            });


        });

    });

    function hideBlockFunc(level) {

        if (level == '1' || level == '0') {
            jQuery('.pt_hidemanagers').hide();
        } else {
            jQuery('.pt_hidemanagers').show();
        }
    }

</script>
@endsection

