<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>PHP聊天室</title>
</head>
<body onload="connect();">
  
  <script>
    var ws, name, client_list={};

    // 连接服务端
    var connect = function() {
       // 创建websocket
       ws = new WebSocket("ws://"+document.domain+":50001");
       // 当socket连接打开时，输入用户名
       ws.onopen = onopen;
       // 当有消息时根据消息类型显示不同信息
       ws.onmessage = onmessage; 
       ws.onclose = function() {
        console.log("连接关闭，定时重连");
          connect();
       };
       ws.onerror = function() {
        console.log("出现错误");
       };
    }

    // 连接建立时发送登录信息
    var onopen = function()
    {
        if(!name)
        {
            show_prompt();
        }
        // 登录
        var login_data = '{"type":"login","client_name":"'+name.replace(/"/g, '\\"')+'","room_id":"<?php echo isset($_GET['room_id']) ? $_GET['room_id'] : 1?>"}';
        console.log("websocket握手成功，发送登录数据:"+login_data);
        ws.send(login_data);
    }
  </script>
</body>
</html>