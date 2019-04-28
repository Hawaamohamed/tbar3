@component('mail::message')
Reset Account Password
<h3 style="font-size: 20px;">Welcome <b>{{$data['data']->name}}</b></h3>

@if($data['type']=='charity')
@component('mail::button', ['url' => url('reset/password/'.$data['token'])])
Click Here to Reset Your Password
@endcomponent
@endif

@if($data['type']=='donor')
@component('mail::button', ['url' => url('reset/password/donor/'.$data['token'])])
Click Here to Reset Your Password
@endcomponent
@endif
or follow the link below,

@if($data['type']=='charity')
<a href="{{url('reset/password/'.$data['token'])}}">{{url('reset/password/'.$data['token'])}}</a><br>
@endif

@if($data['type']=='donor')
<a href="{{url('reset/password/donor/'.$data['token'])}}">{{url('reset/password/donor/'.$data['token'])}}</a><br>
@endif
Thanks,<br>
TBAR3 Team
@endcomponent
