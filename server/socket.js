'use srtict';
class Socket {
    constructor(socket)
    {
        this.io=socket;
        this.online_users=[];
        this.status='';
        // this.username='';
    }
    ioConfig()
    {
        this.io.use((socket,next)=>{
            socket['id']='user_'+socket.handshake.query.user_id;
            if(socket.handshake.query.my_list !== ''||socket.handshake.query.my_list !== 'undefined') {
                socket['my_friend'] = socket.handshake.query.my_list.split(',');
            }else {
                socket['my_friend'] =[];
            }
            if(socket.handshake.query.username !== ''||socket.handshake.query.username !== 'undefined') {
                socket['username'] = socket.handshake.query.username;
            }else {
                socket['username'] =[];
            }
            if (socket.handshake.query.status !==''||socket.handshake.query.status!=='undefined')
            {
                socket['status']=socket.handshake.query.status;

            }else {
                this.status='online';
            }
            next();
        });
    }
    response_status(socket){
        socket.on('response_status',(data)=>{
            if(this.online_users.indexOf(data.to_user)!=-1) {
                this.io.sockets.connected[data.to_user].emit('is_online', {
                    status: data.my_status,
                    user_id: socket.id,
                })
            }
        })
    }
    check_online(socket)
    {
        socket.on('check_online',(data)=>{
            if(this.online_users.indexOf(data.user_id)!=-1){
                try {
                    this.io.sockets.connected[data.user_id].emit('iam_online', {
                        user_id: socket.id,
                        status: socket.status
                    });
                }catch (e) {

                }
            }
            if(this.online_users.indexOf(data.user_id)!==-1) {
                /*
                this.io.sockets.connected[data.user_id].emit('request_status',{
                    user_id:socket.id,
                    status:socket.status,

                });
                */
                this.io.sockets.connected[socket.id].emit('is_online', {
                    user_id: data.user_id,
                    status: 'online'
                });

            }else{
                this.io.sockets.connected[socket.id].emit('is_online', {
                    user_id: data.user_id,
                    status: 'offline'
                });
            }


        });
    }
    socketConnection()
    {
        this.ioConfig();

        this.io.on('connection',(socket)=>{
            this.online_users=Object.keys(this.io.sockets.sockets);
            this.check_online(socket);
            this.user_status(socket);
            //console.log(socket.handshake.query.status);
            this.private_message(socket);
            this.broadcast_private(socket);
            this.response_status(socket);
            this.socketDisconnect(socket);

        });

    }

    user_status(socket)
    {
        socket.on('change_status',(data)=>{
            var my_friend=socket.my_friend;
            if(my_friend.length>0) {
                my_friend.forEach((user) => {
                    if (this.online_users.indexOf('user_' + user) !== -1) {

                        var uid = 'user_' + user;
                        this.io.sockets.connected[uid].emit('new_status', {
                            user_id: socket.id,
                            status: data.status
                        });
                    }
                });
            }
        });
    }

    broadcast_private(socket){

        socket.on('broadcast_private',(data)=>{
            console.log(socket.id+' '+data.to+' '+data.username)
            this.io.sockets.connected[data.to].emit('new_broadcast',{
                from:socket.id,
                to:data.to,
                username:data.username
            });
        });
    }

    private_message(socket)
    {
        socket.on('send_private_msg',(data)=>{

            this.io.sockets.connected[socket.id].emit('new_private_msg',{
                username:socket.username,
                from_uid:data.to,
                message:data.message,
                whois:socket.id,
            });
            console.log(data.to);
            this.io.sockets.connected[data.to].emit('new_private_msg',{
                username:socket.username,
                from_uid:socket.id,
                message:data.message,
                whois:socket.id,
            });
        });
    }

    socketDisconnect(socket)
    {
        socket.on('disconnect',(data)=>{
            var my_friend=socket.my_friend;
            if(my_friend.length>0) {
                my_friend.forEach((user) => {
                    if (this.online_users.indexOf('user_' + user) != -1) {
                        var uid = 'user_' + user;
                        try {
                            this.io.sockets.connected[uid].emit('iam_offline', {
                                user_id: socket.id,
                                status: 'offline'
                            });
                        }catch (e) {

                        }
                    }
                });
            }
        });
    }
}

module.exports=Socket;