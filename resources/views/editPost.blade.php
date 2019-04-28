@include("navbar")


<!-- For upload multiple images (fileinput plugin)-->
<link rel="stylesheet" href="http://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
<link href="http://cdnjs.cloudflare/ajax/libs/bootstrap-fileinput/4.4.7/css/fileinput.css" media="all" rel="stylesheet" type="text/css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/fileinput.css" media="all" rel="stylesheet" type="text/css">
<style>
    .file-footer-caption,.file-caption-main .file-caption,i.glyphicon-plus-sign,.file-drop-zone-title{
        display:none;
    }
    button.fileinput-upload-button,button.fileinput-remove-button,button.fileinput-cancel-button{
        display: none;
    }
    .input-group-append{
        width:100%;
        margin:0;
    }
    .kv-preview-thumb{
        width:32%;
        margin:2px;
        display:inline-block;
    }
    .list .dropdown-menu {
        min-width: 77px;
        box-shadow: none;
        top: 77%;
    }
    .dropdown-toggle::after {
        display:none;
    }
    .modal {
        background: none;
    }

    body{
        background: #ece6e6;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8">
            <!--Edit Post-->
            <section class="post newPost" style="margin-top:100px">
                <div class="panel panel-default" dir='ltr'>
                    <form method="post" action="{{route('updatePost',$post->id)}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="postid" value="{{$post->id}}">
                        <div class="panel-body">
                            <input type="hidden" name="ch_id" value="{{Session('charity_id')}}">
                            <div class="head" style="margin-top: 20px">
                                <div class='row' dir='rtl'>
                                    <div class='col-sm-2 col-xs-4'>
                                        <img src="{{ url('/avatar/'.Session('profile')) }}" class="img-responsive display-inline pull-right" style="max-width:80px;max-height:80px;border-radius:50%;">
                                    </div>
                                    <div class='col-sm-9 col-xs-8'>
                                        <span class="name name_pro pull-right">{{Session('name')}} </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <textarea type="text" name='post' class='question form-control has-feedback' rows="4"  cols="18" wrap="soft" style="overflow:hidden; resize:none;padding:20px" dir='rtl' value="{{$post->story}}"required>{{$post->story}}</textarea>
                                </div>
                                <div class='col-sm-12'>
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    @if($post->images)
                                        @foreach($post->images as $image)
                                            <div class=" edit_images">
                                                <div class="col-sm-4">
                                                    <input type="hidden" id="imgId" name="imgId" value="{{$image->id}}">
                                                    <i class="fa fa-times"></i>
                                                    <a href="{{asset('images/'.$image->image)}}" tabindex='-1' class='downfile'><img src="{{asset('images/'.$image->image)}}" class="img-responsive old_image"></a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                    <input type="hidden" name="imagesId" id="imagesId" value="">
                                </div>
                                <div class='col-sm-12'>
                                    <!--Plugin inputfile-->
                                    <div class="main-section">
                                        <div class="form-group">
                                            <input type="file" id="file-1" name="file[]" multiple class="file" data-overwrite-initial="false" data-min-file-count="">
                                        </div>
                                    </div>
                                    <!--End Plugin-->
                                </div>
                            </div>
                        </div>
                        <div class='panel-footer'>
                            <div class="row">
                                <div class='col-sm-offset-9 col-sm-3 col-xs-offset-6 col-xs-6'>
                                    <input type="submit" name="submit" value="حفظ" class='btn btn-info pull-right publish pub_pro' id="update_post" style="color:white">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

        </div></div></div>
<script src="{{ url("/design/colo/js/jquery-3.2.1.min.js") }}"></script>
<!-- For upload multiple images (fileinput plugin)-->
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="{{ url("/design/colo/js/fileinput.js") }}"></script>
<script src="{{ url("/design/colo/themes/fa/theme.js") }}"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" type="text/javascript"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script>
<script>
    $(".fa-times").on('click',function(){
        var imgId=$(this).siblings("#imgId").val();
        $(this).css("display","none").siblings('a').parent().addClass('hidden');
        var imagesId=$("#imagesId").attr('value');
        var totalImagesId=$("#imagesId").val(imagesId+','+imgId);
    })


</script>
@include("copy")