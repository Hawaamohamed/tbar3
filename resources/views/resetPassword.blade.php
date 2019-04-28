


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>TBAR3 | reset Password</title>
    <link rel="icon" href="{{ url("/design/images/1.jpg") }}">
    <link rel="stylesheet" href="{{ url('/design/lte/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('/design/lte/plugins/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ url('/design/lte/plugins/ionicons.css') }}">
    <link rel="stylesheet" href="{{ url('/design/lte/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ url('/design/lte/plugins/iCheck/square/blue.css') }}plugins/iCheck/square/blue.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="{{ url("/design/colo/css/mystyle.css") }}">

</head>
<body class="hold-transition login-page">
@if(count($errors->all())>0)
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $e)
                <li>{{$e}}</li>
            @endforeach
        </ul>
    </div>
@endif


@if(session()->has('email_sent'))
    <div class="alert alert-success">
        <h2>{{session('email_sent')}}</h2>
    </div>
@endif

<div class="login-box">
    <div class="login-logo">
        <a href="#" style=""><b>TBAR3</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p style="color: #2d958b;" class="login-box-msg">تسجيل الدخول</p>

        <form action="{{url('/reset/password')}}" method="post">
            {{csrf_field()}}

            <div class="form-group has-feedback">
                <select name="type" class="form-control">
                    <option value="1" >جمعية</option>
                    <option value="2" >متبرع</option>
                </select>
                <span style="color: #2d958b;" class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="البريد الإلكترونى">
                <span style="color: #2d958b;" class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <a style="color: #2d958b;" href="{{url('/login')}}">تسجيل الدخول</a>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button style="background: #2d958b;color:white" type="submit" class="btn btn-primary btn-block btn-flat">استرجاع</button>
                </div>
                <!-- /.col -->
            </div>
        </form>


    </div>

</div>


<script src="{{ url('/design/lte/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
<script src="{{ url('/design/lte/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ url('/design/lte/plugins/iCheck/icheck.min.js') }}plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%'
        });
    });
</script>
</body>
</html>
