function user_status(class1,class2){
    var stat=['online','offline'];
    $.each(stat,function (k,v) {
        $('.'+class1).removeClass(v);
    });
    $('.'+class1).addClass(class2);
}

$(document).ready(function(){
    var my_list=[];
    $('.pageChat').each(function () {
        var uid=$(this).attr('ch_id');
        my_list.push(uid);
    });
    var my_status="online";
    var socket=io.connect('http://localhost:5000',
        {
            query:'user_id='+user_id+'&username='+username+'&my_list='+my_list.join(',')+'&status='+my_status}
    );
    var array_emit=['is_online','iam_online','iam_offline'];
    $.each(array_emit,function (k,v) {
        socket.on(v,function (data) {
            user_status(data.user_id,data.status);
        });
    });

    socket.on('connect',function (data) {
        $('.pageChat').each(function () {
            var uid=$(this).attr('ch_id');
            socket.emit('check_online',{
                user_id:'user_'+uid
            });
        });
    });

    socket.on('new_private_msg',function (data) {
        var from_id=data.from_uid.substr(5);
        if (!$('.charity_chat_img').hasClass('box_'+from_id)) {
            var number_of_msg=parseInt(document.getElementById('box_number_'+from_id).innerText);
            if(isNaN(number_of_msg))
            {
                document.getElementById('box_number_'+from_id).innerHTML="<b>1</b>";
            }else{
                var t=number_of_msg+1;
                document.getElementById('box_number_'+from_id).innerHTML="<b>"+t+"</b>";
            }

        }

        if ($('.charity_chat_img').hasClass('box_'+from_id)) {

            if(data.whois=='user_'+user_id)
            {
                var textClass='msg-right';
            }else
            {
                var textClass='msg-left';
            }
            $('<div class="'+textClass+'">'+data.username+':'+data.message+'</div>').insertBefore('#broadcast');
            $('#ch_body').scrollTop($('#ch_body')[0].scrollHeight);
        }

    });
    $(document).on('keypress', 'textarea' , function(e) {
        var chatbox = $(".charity_chat_img").attr("ch_id");


        if (e.keyCode == 13 ) {
            var msg = $(this).val();
            $(this).val('');
            if(msg.trim().length != 0){

                $.ajax(
                    {
                        url:url+"/send/message",
                        type:'post',
                        dataType:'json',
                        data:{_token:token,from_id:user_id,to_id:chatbox,message:msg},
                        success:function (data) {
                            console.log(data);
                        }

                    }
                );

                socket.emit('send_private_msg',{
                    message:msg,
                    to:"user_"+chatbox,

                });

            }
        }else{
            socket.emit('broadcast_private',{
                to:"user_"+chatbox,
                username:username
            });
        }
    });
    socket.on('new_broadcast',function (data) {
        var from_id=data.from.substr(5);
        var x=document.getElementsByClassName("charity_chat_img")[0].getAttribute("ch_id");

        if (from_id===x) {
            $('#broadcast').html('<span style="font-size: 10px;float: left">' + data.username + '</span><img style="height: 30px;width: 30px;" src="' + typing + '"/>');
            setTimeout(function () {
                $('#broadcast').html('');
            }, 5000);
        }
    });





});