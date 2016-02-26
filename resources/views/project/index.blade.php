@extends('app')

@section('content')
<script type="text/javascript" src="{{ asset('/js/suggest_auto.js') }}"></script>
<div class="container">
    <div class="row" style='width:115% !important'>
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading h1" ><IMG height=18 hspace=5 src="images/arrow.gif" width=18>
                    Project Search
                    <span style='float:right'>                   
                        <a href="{{url('projects/create')}}" style=" font-size:15px; color:#1B70CA; text-decoration:none; "><b>Add New Project</b></a>                          
                    </span>
                </div>

                <div class="panel-body">
                    @if(session('success'))
                    <p class="success-msg">{{session('success')}}</p>
                    @endif
                    @if($errors)
                    <p class="error">{{$errors}}</p>
                    @endif

                    <form name = "frm" id="frm" method = "post" action="{{ url('/projectList') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table cellSpacing=1 cellPadding=4 width="40%" align="center"  style = "border:1px solid" >



                            <tr  class = "headingrowcolor"><td align = "center" colspan = "2"><font color="#FFFFFF" ><strong>Search</strong></font></td></tr>
                            <tr><td style="padding-top:3px;">&nbsp;</td></tr>

                            <tr>
                                <td height="25" align="center" colspan= "2">                                   
                                    @if(session('error')) 
                                    <p class='error'>
                                        {{session('success')}}
                                    </p>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td align="right" style = "padding-left:20px;" width='35%'><b>City:</b></td>
                                <td align="left" style = "padding-left:20px;" width='65%'>
                                    <input type="text" id="cityName" name="cityName" value="{{Input::get('cityName')}}"/>
                                    <input type="hidden" id="city" name="city" value="{{Input::get('city')}}"/>
                                </td>
                            </tr>                                   
                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td align="right" style = "padding-left:20px;"><b>Locality:</b></td>
                                <td align="left" style = "padding-left:20px;">
                                    <span id = "LocalityList">
                                        <select name = 'locality' id = "locality" onchange="localitySelect(this.value);">
                                            <option value = "">Select Locality</option> 
                                            @foreach($localities as $key => $value)
                                            <option value = "{{$key}}" @if(Input::get('locality'))@if($key == Input::get('locality')) selected @endif @endif >
                                                    {{$value}}
                                            </option>
                                            @endforeach
                                        </select>
                                    </span>
                                </td>
                            <input id="localitySelectText" type="hidden" name="locality" />
                            </tr>
                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td align="right" style = "padding-left:20px;"><b>Builder:</b></td>
                                <td align="left" style = "padding-left:20px;">

                                    <input type="text" id="builderName" name="builderName" value="{{Input::get('builderName')}}"/>
                                    <input type="hidden" name = "builder" value="{{Input::get('builder')}}" class = "builerUPdate">
                                </td>
                            </tr>
                            <tr><td>&nbsp;</td></tr>

                            <tr>
                                <td align="right" style = "padding-left:20px;"><b>Phase</b></td>
                                <td align="left" style = "padding-left:20px;">
                                    <span id = "BuilderList">
                                        <select name = 'stage' id = "stage" >
                                            <option value = "">Select Phase</option>
                                            @foreach($getProjectStages as $id => $stageName)
                                            <option value="{{$id}}" @if(Input::get('stage') == $id) selected @endif>
                                                    {{$stageName}}
                                        </option>
                                        @endforeach}
                                    </select>
                                </span>
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>

                        <tr>
                            <td width="50" align="right" style = "padding-left:20px;" nowrap><b>Updation Cycle:</b></td>
                            <td width="50" align="left" style = "padding-left:20px;">
                                <select name="updationCycle">
                                    <option value="">Select Updation Cycle</option>
                                    @foreach($UpdationArr as $k=>$v)
                                    <option value = "{{$k}}" @if(Input::get('') == $k) selected @endif> {{$v}}
                                </option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr><td>&nbsp;</td></tr>

                    <tr>
                        <td align="right" style = "padding-left:20px;"><b>Stage:</b></td>
                        <td align="left" style = "padding-left:20px;">
                            <span id = "BuilderList">
                                <select name = 'phase' id = "phase" >
                                    <option value=''>Select Stage</option>
                                    @foreach($getProjectPhases as $id => $name)
                                    <option value="{{$id}}" @if(Input::get('phase') == $id) selected @endif>
                                            @if($name == 'NewProject') NewProject Audit @else{{$name}}@endif
                                </option>
                                @endforeach
                            </select>
                        </span>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td width="50" align="right" style = "padding-left:20px;" nowrap><b>Availability:</b></td>
                    <td width="50" align="left" style = "padding-left:20px;">
                        <select name="Availability[]" id="Avail" multiple>
                            <option value="">Select Availability</option>                            
                            <option value="1" @if(Input::get('Availability'))@if(in_array(1,Input::get('Availability')))selected @@endif @endif>Inventory Not Available</option>
                            <option value="2" @if(Input::get('Availability'))@if(in_array(2,Input::get('Availability')))selected @@endif @endif>Inventory Available</option>
                            <option value="3" @if(Input::get('Availability'))@if(in_array(3,Input::get('Availability')))selected @@endif @endif>Data Not Available</option>
                        </select>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td width="50" align="right" style = "padding-left:20px;" nowrap><b>Residential:</b></td>
                    <td width="50" align="left" style = "padding-left:20px;">
                        <select name="Residential" id="Residential" >
                            <option value="">Select</option>
                            <option value="Residential" @if(Input::get('Residential') == 'Residential') selected @endif>Residential</option>
                            <option value="NonResidential" @if(Input::get('Residential') == 'NonResidential') selected @endif>Non Residential</option>
                        </select>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td width="50" align="right" style = "padding-left:20px;" nowrap><b>Township:</b></td>
                    <td width="50" align="left" style = "padding-left:20px;">
                        <input type="text" id="townshipName" name="townshipName" value="{{Input::get('townshipName')}}">
                        <input type="hidden" name="townshipId" id="townshipId" value="{{Input::get('townshipId')}}">                                        
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td width="50" align="right" style = "padding-left:20px;" nowrap><b>Housing Authority:</b></td>
                    <td width="50" align="left" style = "padding-left:20px;">
                        <select name="authorityId" id="authorityId" >
                            <option value="">Select Authority</option>
                            @foreach($arrAuthorityDetail as $key => $value)
                            <option value="{{$key}}" @if($key == Input::get('authorityId')) selected @endif>{{$key}} - {{$value}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td align="right" style = "padding-left:20px;"><b>Active:</b></td>
                    <td align="left" style = "padding-left:20px;">
                        <select name="Active[]" id="Active" class="field" multiple>
                            <option value ="" >Select</option>
                            <option value="Inactive">Inactive on both Website and IS DB</option>
                            <option value="Active">Active on both Website and IS DB</option>
                            <option value="ActiveInCms">Active In Cms</option>
                            <option value="ActiveInProptiger">Active In Proptiger</option>
                        </select>
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td align="right" style = "padding-left:20px;"><b>Project Status:</b></td>
                    <td align="left" style = "padding-left:20px;">
                        <select name="Status[]" id="Status" class="fieldState" multiple>
                            <option value="">Select</option>
                            @foreach($projectStatus as $key => $value)
                            <option value="{{$key}}" >{{$value}}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>      
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td align="right" style = "padding-left:20px;"><b>With Offers:</b></td>
                    <td align="left" style = "padding-left:20px;">
                        <select name="withOffer" id="withOffer"  style="width:100px">
                            <option value="">Select</option>
                            <option value="Yes" @if(Input::get('withOffer') == 'Yes') selected @endif>Yes</option>
                            <option value="No" @if(Input::get('withOffer') == 'No') selected @endif>No</option>
                        </select>
                        &nbsp;Offer ID : <input type="text" name="offerId" id="offerId" value="{{Input::get('offerId')}}" style="width:100px" />
                    </td>
                </tr>    

                <tr><td>&nbsp;</td></tr>		 
                <tr> 
                    <td align="right" style = "padding-left:20px;"><b>Expected Supply Date:</b></td>
                    <td align="left" style = "padding-left:20px;">
                        From:<input name="exp_supply_date_from" value="{{Input::get('exp_supply_date_from')}}" type="text" class="formstyle2" id="f_date_c_from" size="5" />  <img src="{{asset('images/cal_1.jpg')}}" id="f_trigger_c_from" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                        &nbsp; To:<input name="exp_supply_date_to" value="{{Input::get('exp_supply_date_to')}}" type="text" class="formstyle2" id="f_date_c_to" size="5" />  <img src="{{asset('images/cal_1.jpg')}}" id="f_trigger_c_to" style="cursor: pointer; border: 1px solid red;" title="Date selector" onMouseOver="this.style.background = 'red';" onMouseOut="this.style.background = ''" />
                    </td>
                </tr>

                <tr><td>&nbsp;</td></tr>		 
                <tr> 
                    <td align="right" style = "padding-left:20px;"><b>Project Name:</b></td>
                    <td align="left" style = "padding-left:20px;">
                        <input type = "text" name = "project_name" id = "project_name" value = "{{Input::get('project_name')}}">
                    </td>
                </tr>
                <tr><td>&nbsp;</td></tr>

                <tr>
                    <td align="right" style = "padding-left:20px;"><b>Project Id:</b></td>
                    <td align="left" style = "padding-left:20px;">
                        <input type = "text" name = "projectId" id = "projectId" value = "{{Input::get('projectId')}}">
                    </td>
                </tr>

                <tr><td>&nbsp;</td></tr>


                <tr><td style="padding-top:3px;">&nbsp;</td></tr>
                <tr  class = "headingrowcolor">
                    <td align = "center" colspan = "2">
                        <input type = "submit" value = "Search" name = "search" id="search" />

                    </td>
                </tr>

            </table>
        </form>
        <br/><br/>
        <TABLE cellSpacing=1 cellPadding=4 width="97%" align=center border=0 style="padding-top:20px;">
            <TBODY>
                <TR class = "headingrowcolor">
                    <TD class="whiteTxt" width=5%>SNO.</TD>                    
                    <TD class="whiteTxt" width=10% nowrap>Project Id</TD>
                    <TD class="whiteTxt" width=10% nowrap>Project Name</TD>
                    <TD class="whiteTxt" width=20%>Phase, Stage & Label</TD>
                    <TD class="whiteTxt" width=15% nowrap>Builder Name</TD>
                    <TD class="whiteTxt" width=10%>Address</TD>
                    <TD class="whiteTxt" width=10%>Active</TD>
                    <TD class="whiteTxt" width=20% align ="center">Action</TD>
                </TR>

                @if($projects)
                {{--*/ $count = 0 /*--}}
                @foreach($projects as $project)
                {{--*/ $fontColor = '#000'/*--}}
                {{--*/ $count = $count+1 /*--}}
                @if($count%2 == 0)
                {{--*/ $color = "bgcolor = #F7F7F7" /*--}}
                @else
                {{--*/ $color = "bgcolor = #FCFCFC"/*--}}
                @endif

                @if($project->stage_name == 'NewProject')
                {{--*/ $BG = 'green' /*--}}
                {{--*/ $phse = 'newP' /*--}}
                {{--*/ $fontColor = '#fff' /*--}}
                @elseif($project->stage_name=='NoStage')
                {{--*/ $BG = 'white' /*--}}
                {{--*/ $phse = 'noS' /*--}}
                @elseif($project->stage_name=='SecondaryPriceCycle')
                {{--*/$BG = '#A9A9F5' /*--}}
                {{--*/ $phse = 'updation' /*--}}
                {{--*/ $fontColor = '#fff' /*--}}

                @elseif($project->stage_name=='UpdationCycle')
                {{--*/ $BG = 'yellow' /*--}}
                {{--*/ $phse = 'updation' /*--}}
                {{--*/ $fontColor = '#fff' /*--}}
                @endif

                @if(in_array($project->PROJECT_TYPE_ID, array(3,5,6,10)))
                {{--*/$BG = '#800080'/*--}}
                {{--*/$fontColor = '#fff'/*--}}
                @endif

                @if($project->is_resale == "yes")
                {{--*/$BG = 'red'/*--}}
                {{--*/$fontColor = '#fff'/*--}}
                @endif

                <TR {{$color}}>
                    <TD  width=5%>{{$count}}</TD>                    
                    <TD  width=10% nowrap>{{$project->PROJECT_ID}}</TD>
                    <TD  width=10% align=left class=td-border style="background:{{$BG}};">
                        @if($project->stage_name!="")
                        <a style="color:black" href="show_project_details.php?projectId={{$project->PROJECT_ID}}"
                           title='{{$project->stage_name}}' alt='{{$project->stage_name}}'>
                            {{$project->PROJECT_NAME}}
                        </a> 
                        @else
                        {{$project->PROJECT_NAME}}
                        @endif

                    </TD>
                    <TD  width=20%>
                        @if($project->updation_cycle == null)
                        {{$project->phase_name}} - {{$project->stage_name}} - No Label
                        @else
                        {{$project->phase_name}} - {{$project->stage_name}} - {{$project->updation_cycle}}
                        @endif

                    </TD>
                    <TD  align=center width=15% nowrap>{{$project->BUILDER_NAME}}</TD>
                    <TD  width=10%>{{$project->PROJECT_ADDRESS}}</TD>
                    <TD  width=10%>{{$project->STATUS}}</TD>
                    <TD  width=20% align ="center">Action</TD>
                </TR>
                @endforeach
                @endif

            </TBODY>
        </TABLE>
        @if($projects)
        <?php echo $projects->render() ?>
        @endif
    </div>
</div>
</div>
</div>
</div>
<script type="text/javascript">
    var cals_dict = {
        "f_trigger_c_from": "f_date_c_from",
        "f_trigger_c_to": "f_date_c_to",
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
<script language="javascript">

    var selectAllFlag = false;
    function selectAll(event) {
        if (selectAllFlag) {
            selectAllFlag = false;
        }
        else {
            selectAllFlag = true;
        }
        $('.stateSelection').each(function (index) {
            if (selectAllFlag) {
                if (!$(this).attr('checked')) {
                    $(this).click();
                }
                $(event).html('Clear All');
            }
            else {
                if ($(this).attr('checked')) {
                    $(this).click();
                    $(event).html('Select All');
                }
            }
        });
    }

    function chkConfirm()
    {
        return confirm("Are you sure! you want to delete this record.");
    }

    function gotoAddress(link) {
        window.location = link;
    }
    /*************Ajax code************/
    function GetXmlHttpObject()
    {
        var xmlHttp = null;
        try
        {
            // Firefox, Opera 8.0+, Safari
            xmlHttp = new XMLHttpRequest();
        }
        catch (e)
        {
            //Internet Explorer
            try
            {
                xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
            }
            catch (e)
            {
                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
        }
        return xmlHttp;
    }
    var idfordiv = 0;
    function statuschange(projectId)
    {
        idfordiv = projectId;
        xmlHttp = GetXmlHttpObject()
        if (xmlHttp == null)
        {
            alert("Browser does not support HTTP Request")
            return
        }
        var url = "RefreshBanStat.php?projectId=" + projectId;
        xmlHttp.onreadystatechange = stateChanged
        xmlHttp.open("GET", url, true)
        xmlHttp.send(null)
    }
    function stateChanged()
    {
        if (xmlHttp.readyState == 4)
        {
            document.getElementById('statusRefresh' + idfordiv).innerHTML = xmlHttp.responseText;
        }
    }

    function update_locality(ctid)
    {
        $("#localitySelectText").val('');
        xmlHttpLoc = GetXmlHttpObject()
        var url = "refresh-locality?ctid=" + ctid;
        xmlHttpLoc.onreadystatechange = stateChanged
        xmlHttpLoc.open("GET", url, true)
        xmlHttpLoc.send(null)
    }
    function stateChanged()
    {
        if (xmlHttpLoc.readyState == 4)
        {
            //alert(xmlHttpLoc.responseText+"here");
            document.getElementById("LocalityList").innerHTML = xmlHttpLoc.responseText;
        }
    }
    /*******************End Ajax Code*************/

    function updatelink(url)
    {
        window.location = url;
    }

    function labelSelect(label) {

    }

    function getSelectedProps() {
        var selectedProps = [];
        $('.stateSelection').each(function (index) {
            if ($(this).attr('checked')) {
                selectedProps.push($(this).val());
            }
        });
        return selectedProps;
    }
    function checkPhaseValues() {
        var phases = [];
        var flag = true;
        $('.stateSelection').each(function (index) {
            if ($(this).parent().find('.phaseCheck').val() != "dataCollection" && $(this).parent().find('.phaseCheck').val() != "complete" && $(this).attr('checked')) {
                $(this).parent().find('.phaseError').html("In middle of an audit");
                flag = false;
            }
        });
        return flag;
    }
    function changePhase(value) {
        var props = getSelectedProps();
        var checkPhaseFlag = checkPhaseValues();
        if (!checkPhaseFlag) {
            return;
        }
        if (props.length > 0) {
            if (value != '0') {
                if (confirm("Do you want to change label of selected projects?")) {
                    $('#currentPhase').val(value);
                    $('#selections').val(props);
                    $("#returnURLPID").val(document.URL);
                    $('#changePhaseForm').submit();
                }
            }
        }
    }
    function changePhaseSelected(value) {
        var props = getSelectedProps();
        var checkPhaseFlag = checkPhaseValues();
        if (!checkPhaseFlag) {
            console.log("in middle of an audit");
            return;
        }
        if (props.length > 0) {
            if (value != '0') {
                if (confirm("Do you want to change phase of selected projects?")) {
                    $('#changePhase').val(value);
                    $('#selections').val(props);
                    $("#returnURLPID").val(document.URL);
                    $('#changePhaseForm').submit();
                }
            }
        }
    }

    function makeLabel() {
        if ($('#project_tag').val() != '') {
            if (confirm("Do you want to make a new label?")) {
                $('#currentPhase').val('0');
                $('#label').val($('#project_tag').val());
                $("#returnURLPID").val(document.URL);
                $('#changePhaseForm').submit();
            }
        }
        else {
            $('#errmsgLabel').show();
            return false;
        }
    }

    function selectedBuilderValue(builderId) {
        $(".builerUPdate").val(builderId);
    }

    function localitySelect(loclitySelectVal) {
        $("#localitySelectText").val(loclitySelectVal);
    }
    $(function () {
        $("#localitySelectText").val();
        localitySelect("{{Input::get('locality')}}");

        $(".builerUPdate").val(GetParameterValues('builder'));

    });
    function GetParameterValues(param) {
        var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
        for (var i = 0; i < url.length; i++) {
            var urlparam = url[i].split('=');
            if (urlparam[0] == param) {
                return urlparam[1];
            }
        }
    }
</script>
@endsection
