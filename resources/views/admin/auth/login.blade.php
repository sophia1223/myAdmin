<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台管理</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css')  }}">
{{--    <link rel="stylesheet" href="{{ URL::asset('plugins/gritter/css/jquery.gritter.css') }}">--}}
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('plugins/icheck/all.css')}}">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <![endif]-->
</head>
<body class="hold-transition login-page" style="background: url('../img/bg.jpg')">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>登录</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">请登录</p>
        <form method="POST" action="{{ route('admin.login') }}">
            {!! csrf_field() !!}
            <div class="form-group has-feedback">
                <input  class="form-control" placeholder="用户名" name="username" id="username" value="{{ old('username') }}" required autofocus>
                @if ($errors->has('username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('username') }}</strong>
                    </span>
                @endif
                <span class="fa fa-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" placeholder="密码" name="password" id="password" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
                <span class="fa fa-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input  type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> 记住我
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button class="btn btn-primary btn-block btn-flat" type="submit">登录</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <!-- /.social-auth-links -->
        {{--<a href="{{Url('password/reset')}}">忘记密码</a><br>--}}
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->
<!-- jQuery 2.2.3 -->
<script src="{{ URL::asset('js/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.6 -->
<script  src="{{ asset('js/bootstrap.min.js')  }}"></script>
{{--<script  src="{{ asset('js/auth/login.js')  }}"></script>--}}
<!-- iCheck -->

{{--<script src="{{URL::asset('plugins/gritter/js/jquery.gritter.min.js')}}"></script>--}}
<script src="{{URL::asset('plugins/iCheck/icheck.min.js')}}"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>















