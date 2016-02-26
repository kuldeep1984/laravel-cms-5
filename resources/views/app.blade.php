<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PropTiger.com</title>

        <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/css.css') }}" rel="stylesheet">
        <link href="{{ asset('/jscal/skins/aqua/theme.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('/js/jquery-ui/jquery-ui.min.css')}}" />
        
        <script type="text/javascript" src="{{ asset('/js/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/js/jquery-ui/jquery-ui.min.js') }}"></script>
        
        <script type="text/javascript" src="{{asset('/js/tiny_mce/tiny_mce.js')}}"></script>
        
        <!-- Fonts -->
        <link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
                <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
                <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <script type="text/javascript" src="{{ asset('/jscal/calendar.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/jscal/lang/calendar-en.js') }}"></script>
        <script type="text/javascript" src="{{ asset('/jscal/calendar-setup.js') }}"></script>
        
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">

                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tbody>
                        <tr>
                            <td align="left" valign="top">
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style='border-bottom:1px solid #F17715;border-top:1px solid #c2c2c2;'>
                                    <tr>
                                        <td width = '16%'  bgcolor = '#ffffff' align="center" valign="middle">
                                            <a target="_new"  href = '/'><img border = '0' src='/images/adminlogo.gif' width='150'></a>
                                        </td>
                                        <td width = "41%" bgcolor = '#666666'  height="40" align="right" valign="middle"><font size="4" color="#FFFFFF">Projects Administrator Panel</font></td>
                                        <td width = "41%" bgcolor = '#666666'  height="40" align="right" valign="middle" style ="padding-right:30px;">
                                            <table align = "right">
                                                <tr>
                                                    <td style = "font-size:11px;color:#FFFFFF">


                                                        <font  color="#FFFFFF">
                                                        @if (!Auth::guest()) Welcome <b>{{Auth::User()->getAttribute('FNAME') }}</b> !@endif
                                                        </font> 
                                                        &nbsp;&nbsp;
                                                        <strong>|</strong>
                                                        &nbsp;&nbsp;
                                                        @if (!Auth::guest())
                                                        <A href="changePass.php" style="color:#FFFFFF;font-size:11px;text-decoration:none;font-weight:bold">
                                                            Change Personal Details
                                                        </A> | &nbsp;
                                                        <b>{{Auth::User()->getAttribute('DEPARTMENT') }}</b>
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td  style = "font-size:11px;">
                                                        <font color="#FFFFFF">

                                                        </font>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table> 

            </div>
        </nav>
        <div>
            <table width="100%">
                <tr>
                    <td valign="top">
                        @if (!Auth::guest())
                        <table cellspacing="0" BGCOLOR='#FFFFFF' cellPadding=0 width="202" border="0">
                            <tr>
                                <td height="6"></td>
                            </tr>
                            
                            <tr>
                                <td class="thinline" align="left" colSpan="2"></td>
                            </tr>
                            
                            <tr>
                                    <td class="blue_txt" noWrap align="left" width="2%" height="22">
                                        <img height="9" src="{{asset('images/plus.gif')}}" width="9">&nbsp;</td>
                                      <td align="left" height="22">
                                          <A class="leftnav" href="{{ url('/projectList') }}"><font color = "#f15a22">Projects Management</font></A>
                                     </td>
                            </tr>


                            <tr>
                                <td class="thinline" align="left" colSpan="2"></td>
                            </tr>

                            <tr>
                                <td class="blue_txt" nowrap align="left" width="2%" height="22"><img height="9" src="{{asset('images/plus.gif')}}" width="9">&nbsp;</td>
                                <td align="left" height="22"><a class="leftnav" href="{{ url('/userList') }}"><font color = "#f15a22">User Management</font></a></td>

                            </tr>
                            <tr><td class="thinline" align="left" colspan="2"></td></tr>

                            <tr>
                                <td class="blue_txt" nowrap align="left" width="2%" height="22"><img height="9" src="{{asset('images/plus.gif')}}" width="9">&nbsp;</td>
                                <td align="left" height="22"><a class="leftnav" href="{{ url('/auth/logout') }}"><font color = "#f15a22">Logout</font></a></td>
                            </tr>
                            <tr><td class="thinline" align="left" colspan="2"></td></tr>

                        </table>
                        @endif
                    </td>
                    <td>
                        @yield('content')
                    </td>
                </tr>
            </table>
            <table border="0" cellpadding="0" cellspacing="0" width="100%" style='border-top:1px solid #c2c2c2;border-bottom:1px solid #c2c2c2;'>
                <tr>
                    <td bgcolor = '#666666'  height="28" align="left" valign="middle" style='color:#FFFFFF;font-size:11px;'>&nbsp;Copyrights &copy; 2016. All Rights Reserved.</td>
                </tr>
            </table>
        </div>

    </body>
</html>
