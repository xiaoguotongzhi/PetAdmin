<?php
namespace Home\Controller;
use Think\Controller;
require './ThinkPHP/Library/Vendor/Push/IGt.Batch.php';
/*Push_Start*/
header("Content-Type: text/html; charset=utf-8");

//http的域名
define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

//生产环境
define('APPKEY','F4PBi3IJTqA1cVX5gRvbO5');
define('APPID','mFSW4is4PU8ZBO0MheyAtA');
define('MASTERSECRET','pwRvXYXUxg7xwY5D4M5LA3');

//开发环境
//define('APPKEY','EDP5zovj329wHPEnKN3Sc2');
//define('APPID','lrDptagIl5AGX9IQnTt9J4');
//define('MASTERSECRET','VCTOb8JOAg5dUurhmMmsc9');

/*Push_End*/

class UserController extends LoginController {
    public function __construct()
    {
        parent::__Construct();
        $username = $_SESSION['username'];
        $where['username'] = $username;
        $AdminUser = M('admin_user');
        $data = $AdminUser->where($where)->find();
        if(!$data){
            echo "<meta charset='utf-8' /><script>alert('重新登录一下吧！');top.location.href='".__MODULE__."/Login/index'</script>";
        }
    }


    /*
     * 用户统计
     * */
    public function UserInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 16;

        $model = M("user");
        $data = $model->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }


    /*
     * 身份审核
     * */
    public function UserCardList(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 6;

        $model = M("card");
        $data = $model->order('card_id desc')->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 通过身份审核
     * */
    public function CardOk(){
        $id = $_GET['id'];
        $model = M("card");
        $data['status'] = 1;
        if($model->where('card_id='.$id)->save($data)){

            $arr = $model->where('card_id='.$id)->find();
            $job_status = $arr['job_status'];
            if($job_status==1){
                $job = '医生';
            }elseif ($job_status==2){
                $job = '救援队';
            }elseif ($job_status==3){
                $job = '美容师';
            }elseif ($job_status==4){
                $job = '训犬师';
            }else{
                $job = '其他';
            }

            $model2 = M("user");
            $user = $model2->where('id='.$arr['user_id'])->find();
            $cid = $user['c_id'];

            //修改user寄养状态
            $userArr['foster'] = '2';
            if($model2->where('id='.$user['id'])->save($userArr)){
               //定义发送参数
                $title = '陪它通知';
                $content = '您的'.$job.'身份验证已经通过审核';
                $url = $id;
                //实例化个推
                $igt = new \IGeTui(HOST,APPKEY,MASTERSECRET);
                //要发送的消息内容
                //$template = $this->IGtLinkTemplateTest();
                $template = $this->IGtTransmissionTemplateDemo($title,$content,$url);
                //个推信息体
                $message = new \IGtSingleMessage();

                $message->set_isOffline(true);//是否离线
                $message->set_offlineExpireTime(3600*12*1000);//离线时间
                $message->set_data($template);//设置推送消息类型
                $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
                //接收方
                $target = new \IGtTarget();
                $target->set_appId(APPID);

                $target->set_clientId($cid);

                $rep = $igt->pushMessageToSingle($message, $target);


                if($rep['result'] && $rep['result']=='ok'){
                    echo json_encode(['code'=>200,'msg'=>'操作成功']);
                }else{
                    echo json_encode(['code'=>201,'msg'=>'操作失败']);
                }
            }

        }else{
            echo json_encode(['code'=>201,'msg'=>'操作失败']);
        }
    }

    /*
     * 拒绝身份审核
     * */
    public function CardNo(){
        $id = $_GET['id'];
        $model = M("card");
        $data['status'] = 2;
        if($model->where('card_id='.$id)->save($data)){

            $arr = $model->where('card_id='.$id)->find();
            $job_status = $arr['job_status'];
            if($job_status==1){
                $job = '医生';
            }elseif ($job_status==2){
                $job = '救援队';
            }elseif ($job_status==3){
                $job = '美容师';
            }elseif ($job_status==4){
                $job = '训犬师';
            }else{
                $job = '其他';
            }

            $model2 = M("user");
            $user = $model2->where('id='.$arr['user_id'])->find();
            $cid = $user['c_id'];

            //定义发送参数
            $title = '陪它通知';
            $content = '您的'.$job.'身份验证未通过审核，请重新提交资料';
            $url = $id;
            //实例化个推
            $igt = new \IGeTui(HOST,APPKEY,MASTERSECRET);
            //要发送的消息内容
            //$template = $this->IGtLinkTemplateTest();
            $template = $this->IGtTransmissionTemplateDemo($title,$content,$url);
            //个推信息体
            $message = new \IGtSingleMessage();

            $message->set_isOffline(true);//是否离线
            $message->set_offlineExpireTime(3600*12*1000);//离线时间
            $message->set_data($template);//设置推送消息类型
            $message->set_PushNetWorkType(0);//设置是否根据WIFI推送消息，1为wifi推送，0为不限制推送
            //接收方
            $target = new \IGtTarget();
            $target->set_appId(APPID);

            $target->set_clientId($cid);

            $rep = $igt->pushMessageToSingle($message, $target);

            if($rep['result'] && $rep['result']=='ok'){
                echo json_encode(['code'=>200,'msg'=>'操作成功']);
            }else{
                echo json_encode(['code'=>201,'msg'=>'操作失败']);
            }

        }else{
            echo json_encode(['code'=>201,'msg'=>'操作失败']);
        }
    }

    /*
     * 删除身份审核信息
     * */
    public function CardIdDel(){
        $id = $_GET['id'];
        $model = M("card");
        $arr = $model->where('card_id='.$id)->find();

        $model2 = M("user");
        $userArr2 = $model2->where('id='.$arr['user_id'])->find();
        $foster = $userArr2['foster'];
        if($foster=='0'){
            if($model->where('card_id='.$id)->delete()){
                $model3 = M("read");
                if($model3->where('to_user_id='.$arr['user_id'])->delete()){
                    echo json_encode(['code'=>200,'msg'=>'操作成功']);
                }else{
                    echo json_encode(['code'=>201,'msg'=>'操作失败']);
                }

            }else{
                echo json_encode(['code'=>201,'msg'=>'操作失败']);
            }
        }else{
            $userArr['foster'] = '0';
            if($model2->where('id='.$arr['user_id'])->save($userArr)){
                if($model->where('card_id='.$id)->delete()){

                    $model3 = M("read");
                    if($model3->where('to_user_id='.$arr['user_id'])->delete()){
                        echo json_encode(['code'=>200,'msg'=>'操作成功']);
                    }else{
                        echo json_encode(['code'=>201,'msg'=>'操作失败']);
                    }

                }else{
                    echo json_encode(['code'=>201,'msg'=>'操作失败']);
                }
            }
        }
    }

    /*
     * 消息推送模板
     * */
    function IGtTransmissionTemplateDemo($title,$content,$url){
        $template =  new \IGtTransmissionTemplate();
        $template->set_appId(APPID);//应用appid
        $template->set_appkey(APPKEY);//应用appkey
        $template->set_transmissionType(2);//透传消息类型
        $template->set_transmissionContent(json_encode(['type'=>5,'msg'=>$content,'id'=>$url]));//透传内容

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
        $apn->add_customMsg("id",$url);
        $apn->contentAvailable=1;
        $apn->category="ACTIONABLE";
        $template->set_apnInfo($apn);

        return $template;
    }
}