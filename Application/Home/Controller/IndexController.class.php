<?php
namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function index()
    {

//        $message = S('message_queue');
//      var_dump($message);
//        var_dump($this->get_index($message, 45));
//        $message = array_slice($message, $this->get_index($message, 45), null, true);
//        var_dump($message);
        $this->display();
    }



    public function add()
    {
        if (IS_POST) {
            $message = $_SERVER['REMOTE_ADDR'] . '_';
            $message1 = I('post.message');
            $message .= $message1;
            file_put_contents('a3.txt',print_r($message,true));
            $result = $this->addMsg($message);
            if ($result) {
                $this->ajaxReturn(array('status' => 1, 'message' => '成功'));
            } else {
                $this->ajaxReturn(array('status' => 0, 'message' => '发送失败'));
            }
        }
    }

    public function getMsgList()
    {
        $index = I('post.index');
        $message = S('message_queue');
        file_put_contents('a1.txt',print_r($index,true));
        file_put_contents('a2.txt',print_r($message,true));
        file_put_contents('b.txt',print_r($_SERVER,true));
//        $this->ajaxReturn(array('status' => 1, 'message' => $message, 'is_mine' => 1));
        if ($message) {
            $new_message = array();
            foreach ($message as $v){
               $new_message[] = substr($v,0,strpos($v,"_"));
            }
            file_put_contents('a6.txt',print_r($new_message,true));
            foreach ($new_message as $val){
                if($val == '127.0.0.1'){
                    empty($index) && $this->ajaxReturn(array('status' => 1, 'message' => $message, 'is_mine' => 1));
                }else{
                    empty($index) && $this->ajaxReturn(array('status' => 1, 'message' => $message, 'is_mine' => 2));
                }
            }

            $message = array_slice($message, $this->get_index($message, $index) + 1, null, true);
            file_put_contents('a7.txt',print_r($message,true));
            if($_SERVER[REMOTE_ADDR] == '127.0.0.1'){
                //从他当前最后一个聊天记录查找
                $this->ajaxReturn(array('status' => 1, 'message' => $message, 'is_mine' => 1));
            }else{
                //从他当前最后一个聊天记录查找
                $this->ajaxReturn(array('status' => 1, 'message' => $message, 'is_mine' => 2));
            }

        }
        $this->ajaxReturn(array('status' => 0, 'message' => '获取失败'));
    }
    //获取截取的某个从0开始下标
    private function get_index($array = array(), $index)
    {
        $keys = array_keys($array);
        $i = array_search($index, $keys);
        return $i;
    }


    private function addMsg($v)
    {
        //获取当前的message
        !S('message_queue') && S('message_queue', array());
        //当message为空的时候，给他赋值一个空数组
        $arr_msg = S('message_queue');
        if (isset($v)) {
            //判断是否传过来的信息为null
            if (count($arr_msg) > 30) {  //判断是否长度为100，因为此为聊天室信息，不保存
                $arr_msg = array_slice($arr_msg, 20, count($arr_msg), true);
            }
            array_push($arr_msg, $v);//增加消息到队尾
            $result[] = S('message_queue', $arr_msg);//保存消息队列
            return $result;
        }
    }
}