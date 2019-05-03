<!DOCTYPE html>
<html lang="en">
<head>
	<title>TBAR3</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="website help charities">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<link rel="icon" href="{{ url("/design/images/1.jpg") }}">
    <link rel="stylesheet" href="{{ url("/design/dash/style.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("/design/card/font.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("/design/card/bootstrap.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("/design/card/card.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("/design/colo/css/bootstrap4/bootstrap.min.css") }}">
	<link href="{{ url("/design/colo/plugins/font-awesome-4.7.0/css/font-awesome.min.css") }}" rel="stylesheet" type="text/css">
	<link rel="stylesheet" type="text/css" href="{{ url("/design/colo/css/main_styles.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("/design/colo/css/responsive.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("mystyle.css") }}">
	<link rel="stylesheet" type="text/css" href="{{ url("/design/persons.css") }}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<link rel="stylesheet" href="{{ url("/design/lte/dist/css/AdminLTE.min.css") }}">
	<link rel="stylesheet" href="{{ url("/design/lte/dist/css/skins/_all-skins.min.css") }}">
	<link rel="stylesheet" href="{{ url("/design/lte/plugins/iCheck/flat/blue.css") }}">
	<link rel="stylesheet" href="{{ url("/design/lte/plugins/morris/morris.css") }}">
	<link rel="stylesheet" href="{{ url("/design/lte/plugins/jvectormap/jquery-jvectormap-1.2.2.css") }}">
	<link rel="stylesheet" href="{{ url("/design/lte/plugins/datepicker/datepicker3.css") }}">
	<link rel="stylesheet" href="{{ url("/design/lte/plugins/daterangepicker/daterangepicker-bs3.css") }}">
	<link rel="stylesheet" href="{{ url("/design/footer-distributed-with-contact-form.css") }}">
	<link rel="stylesheet" href="{{ url("/design/font_face.css") }}"  type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Cairo" rel="stylesheet">

	<style>
		*:not(.fa)
		{
			font-family: 'Cairo', sans-serif!important;
			font-weight: normal!important;
		}
	</style>
	<script>
		function test()
		{
			alert("search") ;
		}
	</script>

</head>
<body>
<div class="super_container">

	<header class="header trans_300">
		<div class="main_nav_container">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 text-right">
						<div class="logo_container">
							<img src="{{ url("/design/images/1.jpg") }}">
						</div>

						<nav class="navbar" >
							<ul class="navbar_menu">
								<li>
									<i onclick="test()" class="fa fa-search" style="position:absolute;color:white;cursor:pointer;border-right:none;font-size:16px;"></i>
									<input type="email" class="form-control" style="color: darkcyan;font-family: Calibri , arial;font-size: 15px ; display: inline; width: 200px;text-align: right;padding: 0 5px 0 40px" placeholder="... بحث">
								</li>
								<li><a href="{{url('/team/info')}}">من نحن</a></li>

								@if( session()->has('auth') )
									<li><a style="" href="{{url('/logout')}}">تسجيل الخروج</a></li>
								@endif

								@if( ! session()->has('auth') )
								<li><a href="{{url('/register/charity')}}">أنضم كجمعية</a></li>
								@endif

								@if( ! session()->has('auth') )
								<li><a href="{{url('/register/user')}}">أنضم كمتبرع</a></li>
								@endif

								@if( ! session()->has('auth') )
								<li><a href="{{url('/login')}}">تسجيل الدخول</a></li>
								@endif

								<li><a href="{{url('/needy/persons')}}">الحالات</a></li>
								<li><a href="{{url('/home')}}">الرئيسية</a></li>

								@if( session()->has('auth') && session()->has('charity_id'))
								<li><a href="{{url('/profile/' . session()->get('charity_id'))}}">الشخصية</a></li>
								@endif
							</ul>

							<div class="hamburger_container">
								<i style="margin-top: 30%;color: #2d958b;" class="fa fa-bars" aria-hidden="true"></i>
							</div>
						</nav>
					</div>
				</div>
			</div>
		</div>
	</header>

	<div class="fs_menu_overlay"></div>
	<div class="hamburger_menu">
		<div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
		<div class="hamburger_menu_content text-right">
			<ul class="menu_top_nav">
				<li style="padding-right:10px;margin: 10px 0px;margin-top:70px;border-bottom: 1px solid #ccc;"><a style="color:#2d958b;font-size:15px;" href="{{url('/home')}}"> الرئيسية</a></li>
				<li style="padding-right:10px;margin: 10px 0px;border-bottom: 1px solid #ccc;"><a style="color:#2d958b;font-size:15px;" href="{{url('/needy/persons')}}"> الحالات</a></li>
				<li style="padding-right:10px;margin: 10px 0px;border-bottom: 1px solid #ccc;"><a style="color:#2d958b;font-size:15px;" href="{{url('/login')}}"> تسجيل الدخول</a></li>
				<li style="padding-right:10px;margin: 10px 0px;border-bottom: 1px solid #ccc;"><a style="color:#2d958b;font-size:15px;" href="{{url('/register/user')}}">أنضم كمتبرع</a></li>
				<li style="padding-right:10px;margin: 10px 0px;border-bottom: 1px solid #ccc;"><a style="color:#2d958b;font-size:15px;"href="{{url('/register/charity')}}">أنضم كجمعية</a></li>
				<li style="padding-right:10px;margin: 10px 0px;border-bottom: 1px solid #ccc;"><a style="color:#2d958b;font-size:15px;" href="{{url('/team/info')}}">من نحن</a></li>
				<li style="padding-right:10px;margin: 10px 0px;border-bottom: 1px solid #ccc;margin-bottom: 100px">
					<i onclick="test()" class="fa fa-search" style="position:absolute;color:white;top:211px;width:30px;height:32px;background:#28b8b9;padding: 9px 8px 3px 3px;cursor:pointer;border-right:none;font-size:16px;"></i>
					<input type="email" class="form-control" style="color: darkcyan;font-family: Calibri , arial;font-size: 15px ; display: inline; width: 200px;text-align: right;padding: 0 5px 0 40px;margin-bottom: 10px;" placeholder="... بحث">
				</li>
			</ul>

		</div>
	</div>
