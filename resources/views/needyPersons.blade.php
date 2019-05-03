@include('navbar')

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
<style>

.fa-search{
  top: 7px;
  height: 33px;
  left: 1px;
}
.modal {
  background: rgba(3,3,3,.1);
}
.name{
  margin: 5px auto;
}
  @media(max-width: 575px) {
    .charity {
      margin-left: 50%;
    }
    .charity_icon {
      margin-left: -13px;
    }
  }
  .donation:hover
  {
    background: rgb(40, 184, 185)
  }
}
</style>

<div style="background: #ccc;margin-top:60px;min-height:474px;">
  <div class="row">
    <div class="col-xs-offset-2 col-xs-6 hidden-sm hidden-md hidden-lg" style="padding:0;margin:0">
    @if(session()->has('donor_id') || session()->has('charity_id'))
      <button class="btn btn-flat charity_chat charity_chat_xs" aria-hidden="true" href="#charities_model" type="" data-id="PostId" data-toggle="modal" style="color:#fff;background:#cdd20a;padding-left: 7px;cursor: pointer;margin-left: 10px;font-size:20px;position:fixed">Chating</button>
    @else
      <a  href="{{url('/login')}}" class="btn btn-info btn-block btn-flat" style="color:#fff">Chat</a>
    @endif
    </div></div>

  <div class="row" style="background: #ccc;margin-top:60px;min-height:474px;">
  <!--*****************Start his Followings****************-->
    <div class="col-md-3 col-sm-3 hidden-xs" style=" padding:0">
     <div class="panel panel-default chat" style="overflow:auto;padding:0;position: fixed;width: 25%;border-radius:20px;left: 5px;">

      <div class="panel-body chat_body" style="margin-bottom:0px;top:0px;">
     @if(session()->has('donor_id') || session()->has('charity_id'))
      @if(empty($followings[0]))
         <div class="alert alert-primary text-center">يمكنك متابعة الجمعيات والتواصل معهم لمساعدة الحالات</div>
      @else
       @foreach($followings as $charity)
          <div class="row">
          <div class="col-sm-1" style="padding:0;margin:0"><i class="fa fa-comment charity_chat" aria-hidden="true" href="#charities_model" type="" data-id="PostId" data-toggle="modal" style="color:#cdd20a;padding-left: 7px;cursor: pointer;margin-left: 5px;font-size:20px"></i></div>
          <div class="col-sm-8 name"  style=" text-align: center;padding-right: 5px;">
           <a href="{{ url('/profile/'. $charity->id )}}">
            <span class="chat_charity_name pull-right" style="font-size:11px"><b>{{$charity->name}}</b></span>
           </a>
          </div>
          <div class="col-sm-3 img" style="padding-left: 5px;">
            <a href="{{ url('/profile/'. $charity->id )}}">
            <img src="{{asset('avatar/'.$charity->profile)}}" style="height:35px;width:100%">
            </a>
          </div>
        </div>
      <hr>
      @endforeach
     @endif
    @else
     <a  href="{{url('/login')}}" class="" style="color:#fff"><div class="alert alert-primary text-center">يمكنك متابعة الجمعيات والتواصل معهم لمساعدة الحالات</div></a>
    @endif

      </div>

      <!--end hidden-->
     </div>
    </div>

    <!--*************Start Posts******************************-->
    <div style="height:auto" class='col-md-6 col-sm-12 col-xs-12 div1'>

        @if( session()->has('success') )
        <div class="alert alert-success">
          <h5 style="text-align: right" >تم التبرع بنجاح</h5>
          {{ session()->forget('price') }}
          {{ session()->forget('donate') }}
        </div>
        @endif
        @if( session()->has('fail') )
            <div class="alert alert-danger">
                <h5 style="text-align: right" >تم التبرع بنجاح</h5>
                {{ session()->forget('price') }}
                {{ session()->forget('donate') }}
            </div>
         @endif

        <section style="margin-left: 10px;" class="oldPosts">
            @foreach($posts as $post)
            <div class="panel panel-default opost" dir='ltr' style="border-radius:20px">

                <div class="panel-body">
                    <div class="head">
                        <div class='row' dir='rtl'>
                            <div class='col-sm-2 col-xs-4'>
                                <img src="{{ asset('/avatar/'. $post->charity->profile) }}" class="img-responsive display-inline pull-right" style="width:100%;height:100%;border-radius:50%;">
                            </div>
                            <div class='col-sm-8 col-xs-5' style="">
                                <h4 class="name name_pro pull-right" style="text-align: center;">{{ $post->charity->name }}</h4>
                            </div>
                            <div class='col-sm-2  col-xs-3'>
                                <span class='date pull-left'>
                          <?php

                            $timestemp = $post->created_at;
                            $day = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->day;
                            $month = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->month;
                            $year = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $timestemp)->year;
                            echo "<span style='color:#999'>" . $day ."/". $month ."/".$year."</span>";
                                ?>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="" dir="auto" style="text-align:right;font-size:20px;margin-top:20px;padding:15px">
                                <p style="text-align: right;font-size: 20px;padding: 15px;"> {{ $post->story }} </p>
                            </div>
                        </div>
                        @if($post->images)
                        <div class="col-sm-12">
                            @foreach($post->images as $image)
                            <div class="col-sm-6" style="height:300px;margin-bottom:5px">
                                <img style="height: 100% ; width: 100%" src="{{asset('images/'.$image->image)}}" class="img-responsive" title="image" alt="{{$image->image}}">
                            </div>
                            @endforeach
                        </div>
                        @endif
                        <div class="col-sm-12">
                            <span id="uploaded_image"></span>
                        </div>
                    </div>

                    <div class='row' style="margin:10px 0">
                        <div class='col-sm-3 hidden-xs span2' style="height: 20px;">
                            <span class="pull-right">{{$post->payment}}</span>
                        </div>
                        <div class='col-sm-6 col-xs-12' style="height: 20px;">
                            <div class="progress" style="height:20px;border-radius:8px">
                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="border-radius:8px;height: 20px;font-size: 10px;width:<?php $i = ($post->payment/$post->required)*100 ;
                                echo $i ;?>%">{{$i}}%</div>
                            </div>
                        </div>
                        <div class='col-sm-3  hidden-xs' style="height: 20px;">
                            <span class="pull-left" >{{$post->required}}</span>
                        </div>
                    </div>

                </div>

                <div class='panel-footer' style="border-radius:0 0 20px 20px">
                    <div class="row">
                        <div class='col-md-offset-10 col-md-2 col-sm-offset-9 col-sm-2  col-xs-offset-9 col-xs-3'>
                          <span style="font-size: 15px;padding:5px 20px;z-index:{{$post->id}}" class='btn btn-flat donation' id="donation" aria-hidden="true" href="#myModalll" data-id="" data-toggle="modal" >
                             تبرع
                          </span>
                        </div>
                    </div>
                </div>
            </div>

            @endforeach
        </section>

    </div>
    <!--************************End Post********************-->

    <!--*****************Start All Charities****************-->
    <div class="col-md-3 col-sm-3 hidden-xs">
     <div class="panel panel-default " style="position: fixed;width: 24.2%;border-radius:20px;right: 5px;">
      <div class="panel-body charities" style="margin-bottom:0px;top:0px;overflow:auto;">
       @if(session()->has('charity_id'))
          @foreach( $charities as $ch )
          @if($ch->id != session()->get("charity_id") && !App\Charity_charity::where(['followingid'=>session('charity_id'),'charityid'=>$ch->id])->exists())
          <div class="row" style="margin-bottom:15px">
            <div class="col-sm-1" style="padding:0;margin:0"><form method="post" id="form_follow" action="{{url('/needy/persons/follow/')}}">{{csrf_field()}}
              <input type="hidden" class="charityid" name='charityid' value="{{$ch->id}}"><input type="hidden" name="sessionid" class='sessionid' value=''><input type="hidden" name="status" class='status' value=''>
              <i type="submit" class="fa fa-plus" style="color:rgb(40, 184, 185);padding: 7px;cursor: pointer;border-radius: 2px;margin-left: 5px;background:#ddd"></i>
            </form></div>
            <div class="col-sm-8 name" style=" text-align: center;">
             <a href="{{ url('/profile/'. $ch->id )}}">
              <span class="chat_charity_name pull-right" style="font-size:11px"><b>{{$ch->name}}</b></span>
             </a>
            </div>
            <div class="col-sm-3 img" style="padding-left: 5px;">
              <a href="{{ url('/profile/'. $ch->id )}}">
                <img src="{{asset('avatar/'.$ch->profile)}}" style="height:40px;width:100%">
              </a>
           </div>
          </div>
          @endif
          @endforeach
        @elseif(session()->has('donor_id'))
           @foreach($charities as $ch)
           @if(!App\donors_charities::where('charityid', $ch->id)->exists())
           <div class="row" style="margin-bottom:15px">
             <div class="col-sm-1" style="padding:0;margin:0"><form method="post" id="form_follow" action="{{url('/needy/persons/follow/')}}">{{csrf_field()}}
               <input type="hidden" class="charityid" name='charityid' value="{{$ch->id}}"><input type="hidden" name="sessionid" class='sessionid' value=''><input type="hidden" name="status" class='status' value=''>
               <i type="submit" class="fa fa-plus" style="color:rgb(40, 184, 185);padding: 7px;cursor: pointer;border-radius: 2px;margin-left: 5px;background:#ddd"></i>
             </form></div>
             <div class="col-sm-8 name" style=" text-align: center;">
              <a href="{{ url('/profile/'. $ch->id )}}">
               <span class="chat_charity_name pull-right" style="font-size:11px"><b>{{$ch->name}}</b></span>
              </a>
             </div>
             <div class="col-sm-3 img" style="padding-left: 5px;">
               <a href="{{ url('/profile/'. $ch->id )}}">
                 <img src="{{asset('avatar/'.$ch->profile)}}" style="height:40px;width:100%">
               </a>
            </div>
           </div>
           @endif
           @endforeach
        @else
          @foreach( $charities as $ch )
          <div class="row" style="margin-bottom:15px">
            <div class="col-sm-1" style="padding:0;margin:0"><form method="post" id="form_follow" action="{{url('/needy/persons/follow/')}}">{{csrf_field()}}
              <input type="hidden" class="charityid" name='charityid' value="{{$ch->id}}"><input type="hidden" name="sessionid" class='sessionid' value=''><input type="hidden" name="status" class='status' value=''>
              <i type="submit" class="fa fa-plus" style="color:rgb(40, 184, 185);padding: 7px;cursor: pointer;border-radius: 2px;margin-left: 5px;background:#ddd"></i>
            </form></div>
            <div class="col-sm-8 name" style=" text-align: center;">
             <a href="{{ url('/profile/'. $ch->id )}}">
              <span class="chat_charity_name pull-right" style="font-size:11px"><b>{{$ch->name}}</b></span>
             </a>
            </div>
            <div class="col-sm-3 img" style="padding-left: 5px;">
              <a href="{{ url('/profile/'. $ch->id )}}">
                <img src="{{asset('avatar/'.$ch->profile)}}" style="height:40px;width:100%">
              </a>
           </div>
          </div>
          @endforeach
        @endif
       </div>
      </div>
     </div>
 <!--*************************End All Charities******************-->
</div>
</div>
<!-- Start PopUp For Tbar3-->
  <div id="myModalll" class="modal fade">
    <form action="{{ url('/paypal') }}" method="POST" >
      {{ csrf_field() }}
      <input type="hidden" onclick="alert( this.value );" name="donate" id="donate" value="">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close pull-left" style="margin:0;padding:6px;font-size: 20px;" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">تبرع</h4>
          </div>
          <div class="modal-body" style="padding: 0;">

            <div class='row' style='margin-bottom: 30px;margin-top: 30px;'>
                <div class="col-xs-12">
                  <img src="{{url('/design/images/paypal.svg ')}}" border="0" class="img-responsive" alt="PayPal Logo" style="margin:auto;width:40px;height: 40px">
                </div>
                <hr>
            </div>

            <div class='row' dir='rtl'>
              <div class='col-sm-12'>
                <input style="font-size: 15px;width: 80%;margin: auto;margin-bottom: 20px;" type="text" name="price" class="form-control" placeholder="المبلغ ...">
              </div>
            </div>

            <div style="padding: 16px; margin-top: 10px;" class="modal-footer">
              <button type="button" class="btn btn-default btn-lg" data-dismiss="modal">الغاء</button>
              <button type="submit" class="btn btn-primary btn-lg">ارسال</button>
            </div>
        </div>
    </form>
    </div>
  </div>
  </div>
<!-- End Popup --->

 <!-- Start Chating PopUp -->
 <div id="charities_model" class="modal fade">
                   <div class="modal-full-height" style="">
                       <div class="modal-content" style="width: 100%;">
                           <div class="modal-header">
                               <button type="button" class="close pull-left"  data-dismiss="modal" aria-hidden="true">&times;</button>
                               <h4 class="modal-title"></h4>
                           </div>
                          <div class="modal-body">
                            <div class='row'>
                             <div class='col-sm-5 col-xs-12' style="border-right:3px solid #ccc;overflow: auto;height:350px;">
                               <div class="panel-body chat_body" style="margin-bottom:0px;top:0px;">
                                @foreach($followings as $charity)
                                 <div style="cursor:pointer">
                                   <div class="row">
                                   <div class="col-sm-1 col-xs-2" style="padding:0;margin:0"><i class="fa fa-comment charity_chat" style="color:#cdd20a;padding-left: 7px;cursor: pointer;margin-left: 5px;font-size:20px"></i></div>
                                   <div class="col-sm-8 col-xs-7 name">
                                    <a href="{{ url('/profile/'. $charity->id )}}">
                                     <span class="chat_charity_name pull-right" style="font-size:11px"><b>{{$charity->name}}</b></span>
                                   </a>
                                   </div>
                                   <div class="col-sm-3 col-xs-3 img">
                                    <a href="{{ url('/profile/'. $charity->id )}}">
                                     <img src="{{asset('avatar/'.$charity->profile)}}" style="height:35px;width:100%">
                                    </a>
                                   </div>
                                 </div><hr>
                                 </div>
                               @endforeach

                               </div>
                             </div>
                             <!--Chat-->
                             <div class="col-sm-7 col-xs-12" id="appendnewChat" style="height:340px">
                               <div class="panel panel-default" style="margin-bottom:0;height:100%; height: 350px;">
                                <div class="panel-heading" style="height:60px;padding:0;background:#cdd20a">
                                  <div class='col-sm-9 col-xs-8' style="padding-right:8px;"><span class="pull-right"style="margin:15px auto"></span></div>
                                  <div class='col-sm-3 col-xs-4' style="padding:0;height: 100%"></div>
                                </div>
                                <div class="panel-body" id="ch_body" style="height: 238px">

                                </div>
                                <div class="panel-footer" style="padding:0px;">
                                    <textarea type="text" name='chat' id="message" class='form-control has-feedback' rows="1"  cols="18" wrap="soft" style="width:100%;padding:15px;overflow:hidden;border:none; resize:none;bottom:0;background: #f5f5f5" dir='rtl' Placeholder="ارسل رسالة..." required></textarea>
                                </div>
                              </div>
                             </div>
                            <!--End Chat body-->
                           </div>
                         </div>
                           <div class="modal-footer">


                           </div>
                       </div>
                   </div>

               </div>
<!-- End Popup --->


<script>
  window.addEventListener( "load" , function()
  {
    var donates = document.getElementsByClassName("donation") ;

    for( var i=0 ; i<donates.length ; i++)
    {
      donates[i].addEventListener( "click" , function(e) {
        $.ajax({
          type: 'GET' ,
          url: "/session/"+ e.target.style.zIndex ,
          });
      });
    }
  });
</script>

<script>
$(document).ready(function(){

  ///Follow
  $(".fa-plus").click(function(){

     @if(session()->has('charity_id'))
      {{$session_id = session('charity_id')}}
       var status = "charity";
     @elseif(session()->has('donor_id'))
       {{$session_id = session('donor_id')}}
        var status = "donor";
     @else
      window.location='/login';
     {{$session_id = 0}}
     @endif
    var session_id = {{$session_id}};
    $(this).siblings("input.sessionid").val({{$session_id}});
    $(this).siblings("input.status").val(status);
    var form = $(this).parent("#form_follow").serialize();
    var url = $("#form_follow").attr('action');
    var thiss=$(this);
    $.ajax({
      url:url,
      method:"POST",
      data:form,
      type:"post",
      dataType:'JSON',
      success:function(data)
      {
        if(session_id !=0 ){
        thiss.removeClass('fa-plus').addClass('fas fa-check');
        thiss.parent().parent().parent('.row').fadeOut(1200).css("transition","all .1s ease-in-out");
        /*$(".chat_body").append("<div class='row hidden_following'><div class='col-sm-1' style='padding:0;margin:0'><i class='fa fa-comment charity_chat' aria-hidden='true' href='#charities_model' data-id='PostId' data-toggle='modal' style='color:#cdd20a;padding-left: 7px;cursor: pointer;margin-left: 5px;font-size:20px'></i></div><div class='col-sm-8 name' style='text-align: center;padding-right: 5px;'> <a href='/profile/"+ data.charityid +"'><span class='chat_charity_name pull-right' style='font-size:11px'>"+data.name+"</span></a></div><div class='col-sm-3 img' style='padding-left: 5px;'><a href='/profile/"+ data.charityid +"'><img src='/avatar/"+data.profile+"'></a></div></div><hr>");
        $(".hidden_following").fadeIn(1200);*/
      }
      }
    })

  })

      $(".chat").height(window.screen.height/2+84);
      $(".charities").height(window.screen.height/2+50);

  $(".charity_chat").on('click',function(){
      var charityName = $(this).parent().siblings(".name").children().children(".chat_charity_name").html();
      var charityImg = $(this).parent().siblings(".img").children().children().attr('src');
      $("#message").parent(".panel-footer").removeClass("hidden");

        $("#appendnewChat").children().children(".panel-heading").children("div:eq(0)").children("span").html(charityName).css('color',"#fff");
        $("#appendnewChat").children().children(".panel-heading").children("div:eq(1)").html("<img src='"+charityImg+"'>");
        $("#appendnewChat img").css({

          "height":"100%",
          "width":"100%"
        });
  });
  //Chating in xsmall screen
  $(".charity_chat_xs").on('click',function(){
    $("#appendnewChat").children().children(".panel-heading").children("div:eq(0)").children("span").html('');
    $("#appendnewChat").children().children(".panel-heading").children("div:eq(1)").html('');
    $("#message").parent(".panel-footer").addClass("hidden");
  });

  $("<i class='fa fa-angle-left'></i>").insertBefore("#message");

  $(".fa-angle-left").parent().css('position','relative');
 $(".fa-angle-left").css({
  'position':'absolute',
  'top':'1px',
  'color':'#28b8b9',
  'cursor':'pointer',
  'font-size': '45px',
  'z-index':' 999',
  //'right':$(this).parent().find(':textarea').innerWidth() - 5
  'left':'6px'
});



    })
    // Add any thing in file
      </script>
