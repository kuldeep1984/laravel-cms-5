@extends('app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <div class="panel-body">
                <table>
                    <tr>
                        <td width="7" class="table-lt-top_bg"></td>
                        <td class="table-top_bg"></td>
                        <td width="8" class="table-rt-top_bg"></td>
                    </tr>
                    <tr>
                        <td class="table-lt_bg">&nbsp;</td>
                        <td align="center" height="56" valign="middle"><table border="0" cellpadding="0" cellspacing="0" width="98%">
                                <tbody>
                                    <tr>
                                        <td rowspan="2" align="left" valign="top"><img alt="Admin Panel" src="/images/button1.gif" height="22" hspace="2" width="21"></td>
                                        <td class="blue_heading" align="left" valign="top"><h1>Proptiger.com Offline Project Administration Suite!</h1></td>
                                    </tr>
                                    <tr>
                                        <td class="main_text" align="left" valign="top">Please enter a valid username and password to gain access to the administration console.</td>
                                    </tr>
                                </tbody>
                            </table></td>
                        <td class="table-rt_bg">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="table-lt-bt_bg"></td>
                        <td class="table-bot_bg"></td>
                        <td class="table-rt-bt_bg"></td>
                    </tr>
                </table>
            </div>

            <div class="panel-body login_bg">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/login') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <!--						<div class="form-group">
                                                                            <label class="col-md-4 control-label">E-Mail Address</label>
                                                                            <div class="col-md-6">
                                                                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                                                            </div>
                                                                    </div>-->

                    <div class="form-group">
                        <label class="col-md-4 control-label">Username</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="username" value="{{ old('username') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4 control-label">Password</label>
                        <div class="col-md-6">
                            <input type="password" class="form-control" name="adminpassword">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> Remember Me
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">Login</button>

                            <a class="btn btn-link" href="{{ url('/password/email') }}">Forgot Your Password?</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
