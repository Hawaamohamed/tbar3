<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>TBAR3 | Register</title>
	<link rel="icon" href="{{ url("/design/images/1.jpg") }}">  
  <link rel="stylesheet" href="{{ url('/design/lte/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('/design/lte/plugins/font-awesome.css') }}">
  <link rel="stylesheet" href="{{ url('/design/lte/plugins/ionicons.css') }}">
  <link rel="stylesheet" href="{{ url('/design/lte/dist/css/AdminLTE.min.css') }}">
  <link rel="stylesheet" href="{{ url('/design/lte/plugins/iCheck/square/blue.css') }}">

  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <link rel="stylesheet" type="text/css" href="{{ url("/design/register.css ") }}">
</head>

<body class="hold-transition login-page">
  @if(count($errors->all())>0)
  <div class="alert alert-danger text-center">
    <ul class="text-center">
      @foreach($errors->all() as $e)
      <li>{{$e}}</li>
      @endforeach
    </ul>
  </div>
  @endif @if(session()->has('added'))
  <div class="alert alert-success">
    <h2>{{session('added')}}</h2>
  </div>
  @endif
  <div class="container">
    <div class="login-box" style="width: auto">
      <div class="login-logo">
        <a href="#" style=""><b>TBAR3</b></a>
      </div>
      <!-- /.login-logo -->
      <div class="col-sm-offset-3 col-sm-7" style="margin-bottom: 20px">
        <div class="col-sm-5 col-xs-4" style="padding: 0">
          <div class="side text-center">
            <h2 class="text-center"> مرحبا بك</h2>
            <p class='lead text-center'>
              عند انشاء حساب يمكنك الوصول لاكبر عدد من المتبرعين ومساعدة الحالات
            </p>
            <span>اذا قمت بالتسجيل من قبل يمكنك الان</span>
            <button class="btn btn-default"><a href="{{url('/login')}}"> تسجيل الدخول </a></button>
          </div>
        </div>
        <div class="col-sm-6 col-xs-8 main" style="padding: 0;">

          <div class="login-box-body" style="height:auto;border-radius: 15px 0 0 15px;">
            <p class="login-box-msg" style="color: ;">إنشاء حساب كجمعية</p>

            <form action="{{url('/register/charity')}}" method="post">
              {{csrf_field()}}
              <div class="form-group has-feedback">
                <input type="text" name="name" class="form-control" placeholder="اسم الجمعية">
                <span style="color: #2d958b;" class="glyphicon glyphicon-briefcase form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <input type="text" name="phone" class="form-control" placeholder="رقم الموبيل">
                <span style="color: #2d958b;" class="glyphicon glyphicon-phone form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <input type="email" name="email" class="form-control" placeholder="البريد الإلكترونى">
                <span style="color: #2d958b;" class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <input type="password" name="password" class="form-control" placeholder="كلمة السر">
                <span style="color: #2d958b;" class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <input type="password" class="form-control" name="confirm" placeholder="تأكيد كلمة السر">
                <span style="color: #2d958b;" class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <input type="text" name="visa" class="form-control" placeholder="Visa Card">
                <span style="color: #2d958b;" class="glyphicon glyphicon-credit-card form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="text" id="address" name="address" class="form-control" placeholder="العنوان">
                <span style="color: #2d958b;" class="glyphicon glyphicon-home form-control-feedback"></span>
              </div>

              <div class="form-group has-feedback">
                <div id="us1" class="form-group has-feedback" style="width:100%; height: 200px;"></div>
                <input type="hidden" name="long" id="long">
                <input type="hidden" name="lat" id="lat">
              </div>


              <div class="row">
                <div class="col-xs-8">

                </div>
                <!-- /.col -->
                <div class="col-xs-offset-3 col-xs-6">
                  <button type="submit" class="btn"> تسجيل</button>
                </div>
                <!-- /.col -->
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="{{ url('/design/lte/plugins/jQuery/jQuery-2.2.0.min.js') }}"></script>
  <script src="{{ url('/design/lte/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ url('/design/lte/plugins/iCheck/icheck.js') }}"></script>
  <script>
    $(function () {
    $(".side").css('height',$(".main").height());
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });

  </script>
  <script type="text/javascript"src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBwxuW2cdXbL38w9dcPOXfGLmi1J7AVVB8'></script>
  <script src="{{ url( "js/location.js ") }}"></script>
  <script>
    $('#us1').locationpicker({
      location: {
          latitude: 27.186534 ,
          longitude: 31.168561
      },
      radius: 300,
      markerIcon: "{{ url("images/marker.png") }}",
      inputBinding: {
          latitudeInput: $('#lat'),
          longitudeInput: $('#long'),
          //radiusInput: $('#us2-radius'),
          locationNameInput: $('#address')
      }
    });
  </script>

</body>

</html>