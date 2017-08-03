<?php
namespace Home\Controller;
use Think\Controller;
require './ThinkPHP/Library/Vendor/Push/IGt.Batch.php';

/*Push_Start*/
header("Content-Type: text/html; charset=utf-8");

//http的域名
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

//https的域名
//define('HOST','https://api.getui.com/apiex.htm');

//生产环境
//define('APPKEY','F4PBi3IJTqA1cVX5gRvbO5');
//define('APPID','mFSW4is4PU8ZBO0MheyAtA');
//define('MASTERSECRET','pwRvXYXUxg7xwY5D4M5LA3');

//开发环境
define('APPKEY','EDP5zovj329wHPEnKN3Sc2');
define('APPID','lrDptagIl5AGX9IQnTt9J4');
define('MASTERSECRET','VCTOb8JOAg5dUurhmMmsc9');


define('CID','');
define('DEVICETOKEN','');
define('Alias','请输入别名');
/*Push_End*/


class PushController extends LoginController {

    public function __construct()
    {
        parent::__Construct();
        $username = $_SESSION['username'];
        $where['username'] = $username;
        $AdminUser = M('admin_user');
        $data = $AdminUser->where($where)->find();
        if (!$data) {
            echo "<meta charset='utf-8' /><script>alert('重新登录一下吧！');top.location.href='" . __MODULE__ . "/Login/index'</script>";
        }
    }

    //个推提交页面
    public function PushIndex(){
        $this->display();
    }


    //实现通知发送
    public function push(){
        $title = '陪它通知';
        $content = I("post.content");
        $url = I("post.url");
        //实例化个推
        $igt = new \IGeTui(HOST,APPKEY,MASTERSECRET);
        //要发送的消息内容
        //$template = $this->IGtLinkTemplateTest();
        $template = $this->IGtTransmissionTemplateDemo($title,$content,$url);
        //个推信息体
        //基于应用消息体
        $message = new \IGtAppMessage();
        $message->set_isOffline(true);
        $message->set_offlineExpireTime(10*60*1000);
        $message->set_data($template);

        //设置appid
        $appIdList = array(APPID);
        //消息发送
        $message->set_appIdList($appIdList);

        //发送
        $rep = $igt->pushMessageToApp($message);
        if($rep['result'] && $rep['result']=='ok'){
            //入库
            $model = M('igt');
            $data['title'] = $title;
            $data['content'] = $content;
            $data['url'] = $url;
            $data['create_time'] = time();
            $model->add($data);

            $this->assign("num",1);
            $this->display("Push/PushIndex");
        }else{
            $this->assign("num",2);
            $this->display("Push/PushIndex");
        }

    }


    //推送详情
    public function PushInfo(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 10;

        $model = M("igt");
        $data = $model->order('id desc')->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    //删除推送内容
    public function PushIdDelete()
    {
        $id = $_GET['id'];
        $model = M("igt");
        if($model->where('id='.$id)->delete())
        {
            echo json_encode(['code'=>200,'msg'=>'推送内容已成功移除！']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'推送内容移除失败！']);
        }
    }

    //设置要发送的消息(这个仅仅是发送通知用的，和透传没有关系，这个只是安卓可以收到消息)
    public function IGtLinkTemplateTest(){

        $title = '钱箱借贷';
        $text = '最好用的贷款App，新上线N多贷款方，你看了吗？';
        $url = 'https://www.moneylending.cn';


        $template =  new \IGtLinkTemplate();
        $template ->set_appId(APPID);//应用appid
        $template ->set_appkey(APPKEY);//应用appkey
        $template ->set_title($title);//通知栏标题
        $template ->set_text($text);//通知栏内容
        $template ->set_logo("");//通知栏logo
        $template ->set_isRing(true);//是否响铃
        $template ->set_isVibrate(true);//是否震动
        $template ->set_isClearable(true);//通知栏是否可清除
        $template ->set_url($url);//打开连接地址
        return $template;
    }


    //设置带透传的模板(我们一般用的就是这个，这样的话客户端可以通过截取透传从而实现在应用内打开)
    public function IGtNotificationTemplateTest($title,$content,$url){
        /*
        //设置透传内容
        $url = 'https://www.moneylending.cn';

        //设置标题
        $title = '钱箱借贷';
        //设置内容
        $content = '一款最好用的贷款APP，今天上线了更多的优惠，你关注了吗？';

        */

        //消息体设置
        $template =  new \IGtNotificationTemplate();
        $template->set_appId(APPID);//应用appid
        $template->set_appkey(APPKEY);//应用appkey
        $template->set_transmissionType(1);//透传消息类型
        $template->set_transmissionContent($url);//透传内容
        $template->set_title($title);//通知栏标题
        $template->set_text($content);//通知栏内容
        $template->set_logo("http://peita.oss-cn-beijing.aliyuncs.com/question/700271491038066.png");//通知栏logo
        $template->set_isRing(true);//是否响铃
        $template->set_isVibrate(true);//是否震动
        $template->set_isClearable(true);//通知栏是否可清除

        $apn = new \IGtAPNPayload();
        //$alertmsg=new \SimpleAlertMsg();
        //$alertmsg->alertMsg=$content;
        //$apn->alertMsg=$alertmsg;
        $apn->badge=1;//这个是桌面应用图标右上角冒出的一个警示图标，比如发送了一条推送，红色警示的小圆点就是1，所以这里设置1
        $apn->sound="";
        $apn->add_customMsg("payload","payload");
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);

        return $template;
    }



    function IGtTransmissionTemplateDemo($title,$content,$url){
        $template =  new \IGtTransmissionTemplate();
        $template->set_appId(APPID);//应用appid
        $template->set_appkey(APPKEY);//应用appkey
        $template->set_transmissionType(2);//透传消息类型
        $template->set_transmissionContent(json_encode(['type'=>1,'msg'=>$content,'url'=>$url]));//透传内容

//       APN高级推送
        $apn = new \IGtAPNPayload();
        $alertmsg=new \DictionaryAlertMsg();
        $alertmsg->body=$content;
        $alertmsg->actionLocKey="ActionLockey";
        $alertmsg->locKey="LocKey";
        $alertmsg->locArgs=array("locargs");
        $alertmsg->launchImage="launchimage";
//        iOS8.2 支持
        $alertmsg->title=$title;
        $alertmsg->titleLocKey="TitleLocKey";
        $alertmsg->titleLocArgs=array("TitleLocArg");

        $apn->alertMsg=$alertmsg;
        $apn->badge=1;
        $apn->sound="";
        $apn->add_customMsg("payload",$url);
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);

        return $template;
    }


}