<?php
namespace Home\Controller;
use Think\Controller;
include("./ThinkPHP/Library/Vendor/oss/index.php");
header("Content-type: text/html; charset=utf-8");
class EncyclopediasController extends LoginController
{
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

    public function AddNewEncyclopediasForm(){
        $this->display();
    }

    /*
     * 数据添加
     * */
    public function AddNewEncyclopedias(){

        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("Encyclopedias/AddNewEncyclopediasForm");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);


        $title = I('post.title');
        $author_id = I('post.author_id');
        $content = I('post.content');
        $tags = I('post.tags');

        //在这里进行判断标签日志表
        foreach(explode(',',$_POST['tags']) as $name){
            $tagslog = M('encyclopedias_tags_log');
            $con['tag'] = $name;
            $findres = $tagslog->where($con)->find();
            if($findres){
                $tagslog->where($con)->setInc('num',1);
            }else{
                $dd['tag'] = $name;
                $dd['num'] = 1;
                $tagslog->add($dd);
            }
        }


        //图片处理
        foreach($_FILES as $key){
            if($key['name']!=null){
                $re[] = $this->OssUp($key);
            }
        }

        $res = implode(",",$re);

        //数据写入
        $encyclopedias = M("encyclopedias");
        $data['title'] = $title;
        $data['author_id'] = $author_id;
        $data['reward'] = 0;
        $data['img'] = $res;
        $data['content'] = $content;
        $data['reward_status'] = 3;
        $data['share_num'] = 0;
        $data['create_time'] = time();
        $data['content_status'] = 1;
        $data['tags'] = $tags;
        if($encyclopedias->add($data)){
            $this->assign("num",1);
            $this->display("Encyclopedias/AddNewEncyclopediasForm");
        }else{
            $this->assign("num",2);
            $this->display("Encyclopedias/AddNewEncyclopediasForm");
        }
    }

    /*
     * 百科详情
     * */
    public function AddNewEncyclopediasInfo(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 10;

        $model = M("encyclopedias");
        $data = $model->where('content_status = 1')->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 百科删除
     * */
    public function EIdDel(){
        $id = $_GET['id'];
        $model = M("encyclopedias");
        $model->where('id='.$id)->delete();

    }

    /*
     * 待审核列表
     * */
    public function EncyclopediasInfoIsOkList(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 10;

        $model = M("encyclopedias");
        $data = $model->where('content_status = 2')->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 审核通过
     * */
    public function EBok(){
        $id = $_GET['id'];
        $encyclopedias = M("encyclopedias");
        $data['content_status'] = 1;
        $data['tags'] = $_POST['tags'];
        $re = $encyclopedias->where('id='.$id)->save($data);
        if($re){
            //在这里进行判断标签日志表
            foreach(explode(',',$_POST['tags']) as $name){
                $tagslog = M('encyclopedias_tags_log');
                $con['tag'] = $name;
                $findres = $tagslog->where($con)->find();
                if($findres){
                    $tagslog->where($con)->setInc('num',1);
                }else{
                    $dd['tag'] = $name;
                    $dd['num'] = 1;
                    $tagslog->add($dd);
                }
            }
            echo json_encode(['code'=>200,'msg'=>'操作成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'操作成功']);
        }
    }

    /*
     * 审核拒绝
     * */
    public function EBno(){
        $id = $_GET['id'];
        $uid = $_GET['author_id'];
        $encyclopedias = M("encyclopedias");

        $back_jd = M('encyclopedias');
        $back_jd_info = $back_jd->where('id='.$id)->find();

        //取出金豆数量还给用户
        $reward = $back_jd_info['reward'];

        //用户信息以及金豆退回
        $user = M('user');
        $userInfo = $user->where('id='.$uid)->find();
        $current_reward = $userInfo['currency'];
        //最终的金豆
        $last_reward = $current_reward+$reward;

        //修改金豆
        $data22['currency'] = $last_reward;
        $user->where('id='.$uid)->save($data22);

        $data['content_status'] = '3';
        $res = $encyclopedias->where('id='.$id)->save($data);
        if($res){
            echo json_encode(['code'=>200,'msg'=>'操作成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'操作成功']);
        }
    }

    /*
     * 审核回收站列表
     * */
    public function EncyclopediasRecovery()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 10;

        $model = M("encyclopedias");
        $data = $model->where('content_status = 3')->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 回收站信息删除
     * */
    public function EBde(){
        $id = $_GET['id'];
        $model = M("encyclopedias");
        $model->where('id='.$id)->delete();
    }
    

    /*
     * OSS封装
     * */
    public function OssUp($key){
        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($key['name'],strrpos($key['name'],".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
        $imgpath = $key['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据
        return $path;
    }
}