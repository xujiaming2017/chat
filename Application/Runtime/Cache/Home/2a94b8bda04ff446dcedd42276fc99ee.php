<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style>
        body {

            background-color: #f3f3f3;
        }

        .message_content {
            width: 700px;
            margin: 0 auto;
            height: 500px;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 25px;
            background-color: skyblue;
            box-shadow: 3px 3px 3px #cccccc;
        }

        .content {
            width: 700px;
            margin: 0 auto;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 25px;
            background-color: skyblue;
            box-shadow: 3px 3px 3px #cccccc;
            text-align: right;
        }

        ul li {
            width: 100%;
            list-style: none;
        }

        ul li span {
            list-style: none;
            color: white;
            padding: 5px 15px;
            border-radius: 10px;
            font-size: 35px;
            background-color: #00CC66;
            margin: 15px 0;
            display: inline-block;
        }

        .mine {
            text-align: right;
        }

        input[type='button'] {
            padding: 5px 15px;
            border-radius: 5px;

        }

        textarea {
            width: 95%;
            font-size: 24px;
            padding: 15px;
            color: #232323;
        }
    </style>
</head>
<body>
<div class="message_content">
    <ul id="msg_list">
    </ul>
</div>
<div class="content">
    <form>
        <textarea id="msg" name="msg" rows="4" cols="12"></textarea>
        <input id="btn" type="button" value="提交"/>
    </form>


</div>
<script src="/Public/js/jquery-3.1.1.js"></script>
<script>
//    $(function(){
//        $('#msg_list').scrollTop($('#msg_list')[0].scrollHeight);
//    });

    $(function () {
        var array = [];

        setInterval(function () {

            var index = $('#msg_list li').eq(-1).attr('data-id');
            //console.log(index);
            $.ajax({
                url: "<?php echo U('Index/getMsgList');?>",
                dataType: 'json',
                data:{index:index},
                type: 'post',
                success: function (data) {
                    console.log(data);
                    //表示成功
                    if (data.status == 1) {
                        var serach = $('#msg_list li');
                        var is_mine = data.is_mine;
                        console.log(is_mine);
                        $.each(data.message, function (k, v) {
                            if (array.indexOf(k) == -1) {
                                array.push(k);
                                //console.log(array);

                                if(is_mine == 1){
                                    var data = '<li data-id="' + k + '" class="mine">' + '<span>'+ v + '</span>' + '</li><br/>';
                                }else{
                                    var data = '<li data-id="' + k + '">' + '<span>'+ v + '</span>' + '</li><br/>';
                                }

                                $('#msg_list').append(data);
                            }
                        });
                    } else {
                        console.log(data.message);//输出错误信息
                    }
                }
            });
        }, 2000);
    });
    $('#btn').on('click', function (event) {
        $('#msg_list').scrollTop($('#msg_list')[0].scrollHeight);
        var data = $('#msg').val();
        $('#msg').val('');
        $.ajax({
            url: "<?php echo U('Index/add');?>",
            dataType: 'json',
            type: 'POST',
            data: {message: data},
            success: function (data) {

                if (data.status == 1) {

                } else {
                    console.log(data.message);//输出错误信息
                }
            }
        });
    });


</script>

</body>
</html>