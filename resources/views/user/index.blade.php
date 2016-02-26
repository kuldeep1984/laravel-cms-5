@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading h1" ><IMG height=18 hspace=5 src="images/arrow.gif" width=18>
                    User List
                   <span style='float:right'>                   
                             <a href="{{url('users/create')}}" style=" font-size:15px; color:#1B70CA; text-decoration:none; "><b>Add New User</b></a>                          
                         </span>
                </div>

                <div class="panel-body">
                    @if(session('success'))
                        <p class="success-msg">{{session('success')}}</p>
                    @endif
                    
                    <form name = "frm" id="frm" method = "post" action="{{ url('/userList') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <table cellSpacing=1 cellPadding=4 width="40%" align="center"  style = "border:1px solid" >



                            <tr  class = "headingrowcolor"><td align = "center" colspan = "2"><font color="#FFFFFF" ><strong>Search</strong></font></td></tr>
                            <tr><td style="padding-top:3px;">&nbsp;</td></tr>

                            <tr>
                                <td  align="right"><b>Employee Id :</b></td>
                                <td  align="left"><input type="text" id="empid" name="empid" value="{{Input::get('empid')}}"></td>
                            </tr>

                            <tr>
                                <td  align="right"><b>Admin Name :</b></td>
                                <td  align="left"><input type="text" id="name" name="name" value="{{Input::get('name')}}"></td>
                            </tr>	

                            <tr>
                                <td  align="right"><b>UserName :</b></td>
                                <td  align="left"><input type="text" id="username" name="username" value="{{Input::get('username')}}"></td>
                            </tr>

                            <tr>
                                <td  align="right"><b>Email Address:</b></td>  
                                <td  align="left"><input type="text" id="email" name="email" value="{{Input::get('email')}}"></td>
                            </tr>

                            <tr>
                                <td  align="right"><b>Mobile No :</b></td>
                                <td  align="left"><input type="text" id="mobile" name="mobile" value="{{Input::get('mobile')}}"></td>
                            </tr>

                            <tr><td style="padding-top:3px;">&nbsp;</td></tr>
                            <tr  class = "headingrowcolor">
                                <td align = "right" colspan = "2">
                                    <input type = "submit" value = "Search" name = "search" id="search" />

                                </td>
                            </tr>

                        </table>
                    </form>
                    <br/><br/>
                    <TABLE cellSpacing=1 cellPadding=4 width="97%" align=center border=0 style="padding-top:20px;">
                        <TBODY>
                            <TR class = "headingrowcolor">
                                <TD class=whiteTxt width=5% align="center">S No.</TD>
                                <TD class=whiteTxt width=22% align="center">User Details</TD>
                                <TD class=whiteTxt width=13% align="center">Region</TD>
                                <TD class=whiteTxt width=10% align="center">Role / Department</TD>
                                <TD class=whiteTxt width=9% align="center">Created Date</TD>
                                <TD class=whiteTxt width=6% align="center">Status</TD>
                                <TD class=whiteTxt width=12% align="center">Action</TD>
                            </TR>
                            <TR><TD colspan=12 class=td-border>&nbsp;</TD></TR>
                            {{--*/ $count = 0 /*--}}
                            @foreach( $users as $user)
                            {{--*/ $count = $count+1 /*--}}
                            @if($count%2 == 0)
                            {{--*/ $color = "bgcolor = #F7F7F7" /*--}}
                            @else
                            {{--*/ $color = "bgcolor = #FCFCFC" /*--}}	
                            @endif
                            <TR {{$color}}>
                                <TD align=center class=td-border>{{$count}}</TD>
                                <TD align=left class=td-border>@if($user->EMP_CODE != '') <b>Emp. Id : </b> {{$user->EMP_CODE}}<br>@endif
                                    @if($user->FNAME != '')<b>Name : </b>{{$user->FNAME}}&nbsp;&nbsp;<img height="10" width="10" alt="{{$user->ADMINEMAIL}}" title="{{$user->ADMINEMAIL}}" src="images/mailicon.png"><br>@endif

                                    @if($user->MOBILE != '')<b>Mobile : </b>{{$user->MOBILE}}@endif

                                </TD>
                                <TD align=center class=td-border>
                                    {{$regionArray[$user->REGION]}}
                                </TD>
                                <TD align=center class=td-border>
                                    @if($user->ROLE != "")
                                    {{strtoupper($user->ROLE)}}
                                    @else
                                    NA 
                                    @endif
                                    / {{$user->DEPARTMENT}}
                                </TD>
                                <TD align=center class=td-border>                        	
                                    @if($user->ADMINADDDATE == '0000-00-00') 
                                    0000-00-00
                                    @else
                                    {{date('d-m-Y',strtotime($user->ADMINADDDATE))}}
                                    @endif
                                </TD>
                                <TD align=center class=td-border>                        	
                                    @if($user->STATUS == 'Y')
                                    Active
                                    @else
                                    Resigned
                                    @endif	
                                </TD>
                                <TD  class="td-border" align=center  nowrap = 'nowrap'>
                                    <span id="statusRefresh{$userDataArr[data].ADMINID}" >
                                        <a href = "javascript:void(0); onclick= statuschange({$userDataArr[data].ADMINID})">
                                            @if((ucwords($user->STATUS) == 'Y'))
                                            Active
                                            @else
                                            Deactive
                                            @endif
                                        </a>
                                    </span>
                                    |
                                    <a href="{{ url('/users/'.$user->ADMINID.'/edit') }}" title="">Edit</a>
                                </TD>

                            </TR>
                            @endforeach
                        </TBODY>
                    </TABLE>
                    <?php echo $users->render() ?>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
