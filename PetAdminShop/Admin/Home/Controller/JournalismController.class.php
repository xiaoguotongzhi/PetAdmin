<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/2
 * Time: 16:44
 */
namespace Home\Controller;
use Think\Controller;
include("./ThinkPHP/Library/Vendor/oss/index.php");
class JournalismController extends LoginController
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

    /*
     * 新增趣闻页面
     * */
    public function AddNewJournalismForm()
    {
        $this->display();
    }

    /*
     * 新增趣闻
     * */
    public function AddNewJournalism()
    {
//        author:author,
//        editer:editer,
//        tag:spCodesTemp,
//        froms:froms,
//        introduction:introduction,
//        content:content

        //图片处理
        $imginfo1 = $_FILES['img1'];
        $imgname1 = $imginfo1['name'];
        if(!empty($imgname1)){
            $oss = new \Oss();//实例化oss类
            $rand1 = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
            $suffix1 = substr($imgname1,strrpos($imgname1,".")+1);   //截取图片的后缀名字
            $object1 = "question/".$rand1.".".$suffix1;   //拼接上传到oss 之中的路径
            $imgpath1 = $imginfo1['tmp_name'];
            $oss -> upload($object1,$imgpath1);   //调用oss类中的upload方法
            $path1 = "http://peita.oss-cn-beijing.aliyuncs.com/".$object1;   //入数据表表img字段的数据
        }else{
            $path1 = null;
        }


        $imginfo2 = $_FILES['img2'];
        $imgname2 = $imginfo2['name'];
        if(!empty($imgname2)){
            $oss = new \Oss();//实例化oss类
            $rand2 = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
            $suffix2 = substr($imgname2,strrpos($imgname2,".")+1);   //截取图片的后缀名字
            $object2 = "question/".$rand2.".".$suffix2;   //拼接上传到oss 之中的路径
            $imgpath2 = $imginfo2['tmp_name'];
            $oss -> upload($object2,$imgpath2);   //调用oss类中的upload方法
            $path2 = "http://peita.oss-cn-beijing.aliyuncs.com/".$object2;   //入数据表表img字段的数据
        }else{
            $path2 = null;
        }


        $imginfo3 = $_FILES['img3'];
        $imgname3 = $imginfo3['name'];
        if(!empty($imgname3)){
            $oss = new \Oss();//实例化oss类
            $rand3 = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
            $suffix3 = substr($imgname3,strrpos($imgname3,".")+1);   //截取图片的后缀名字
            $object3 = "question/".$rand3.".".$suffix3;   //拼接上传到oss 之中的路径
            $imgpath3 = $imginfo3['tmp_name'];
            $oss -> upload($object3,$imgpath3);   //调用oss类中的upload方法
            $path3 = "http://peita.oss-cn-beijing.aliyuncs.com/".$object3;   //入数据表表img字段的数据
        }else{
            $path3 = null;
        }


        $data['title'] = $_POST['title'];
        $data['author'] = $_POST['author'];
        $data['introduction'] = $_POST['introduction'];
        $data['img1'] = $path1;
        $data['img2'] = $path2;
        $data['img3'] = $path3;
        $data['create_time'] = time();
        $data['editer'] = $_POST['editer'];
        $data['tags'] = $_POST['tag'];
        $data['froms'] = $_POST['froms'];
        if($_POST['introduction']==3){
            $data['video'] = $_POST['video_url'];
        }else{
            $data['video'] = null;
        }
        $data['dm'] = $_POST['content'];
        $model = M("journalism");

        if($model->add($data)){
            $this->assign("num",1);
            $this->display("Journalism/AddNewJournalismForm");
        }else{
            $this->assign("num",2);
            $this->display("Journalism/AddNewJournalismForm");
        }
    }

    /*
     * 趣闻详情
     * */
    public function JournalismInfo(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 10;

        $model = M("journalism");
        $data = $model->order('jid desc')->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 根据id查看详情
     * */
    public function EditJournalismIdInfo(){
        $id = $_GET['id'];
        $model = M("journalism");
        $data = $model->where('jid='.$id)->find();
        $this->assign("data",$data);
        $this->display();
    }

    /*
     * 修改趣闻
     * */
    public function EditJournalism()
    {
//        jid:jid,
//        title:title,
//        author:author,
//        editer:editer,
//        tag:spCodesTemp,
//        froms:froms,
//        introduction:introduction,
//        content:content


        //图片处理
        $imginfo1 = $_FILES['img1'];
        $imgname1 = $imginfo1['name'];
        if(!empty($imgname1)){
            $oss = new \Oss();//实例化oss类
            $rand1 = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
            $suffix1 = substr($imgname1,strrpos($imgname1,".")+1);   //截取图片的后缀名字
            $object1 = "question/".$rand1.".".$suffix1;   //拼接上传到oss 之中的路径
            $imgpath1 = $imginfo1['tmp_name'];
            $oss -> upload($object1,$imgpath1);   //调用oss类中的upload方法
            $path1 = "http://peita.oss-cn-beijing.aliyuncs.com/".$object1;   //入数据表表img字段的数据
        }else{
            $path1 = $_POST['pic1'];
        }


        $imginfo2 = $_FILES['img2'];
        $imgname2 = $imginfo2['name'];
        if(!empty($imgname2)){
            $oss = new \Oss();//实例化oss类
            $rand2 = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
            $suffix2 = substr($imgname2,strrpos($imgname2,".")+1);   //截取图片的后缀名字
            $object2 = "question/".$rand2.".".$suffix2;   //拼接上传到oss 之中的路径
            $imgpath2 = $imginfo2['tmp_name'];
            $oss -> upload($object2,$imgpath2);   //调用oss类中的upload方法
            $path2 = "http://peita.oss-cn-beijing.aliyuncs.com/".$object2;   //入数据表表img字段的数据
        }else{
            $path2 = $_POST['pic2'];
        }


        $imginfo3 = $_FILES['img3'];
        $imgname3 = $imginfo3['name'];
        if(!empty($imgname3)){
            $oss = new \Oss();//实例化oss类
            $rand3 = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
            $suffix3 = substr($imgname3,strrpos($imgname3,".")+1);   //截取图片的后缀名字
            $object3 = "question/".$rand3.".".$suffix3;   //拼接上传到oss 之中的路径
            $imgpath3 = $imginfo3['tmp_name'];
            $oss -> upload($object3,$imgpath3);   //调用oss类中的upload方法
            $path3 = "http://peita.oss-cn-beijing.aliyuncs.com/".$object3;   //入数据表表img字段的数据
        }else{
            $path3 = $_POST['pic3'];
        }


        $jid = $_POST['jid'];

        $data['title'] = $_POST['title'];
        $data['author'] = $_POST['author'];
        $data['introduction'] = $_POST['introduction'];
        $data['img1'] = $path1;
        $data['img2'] = $path2;
        $data['img3'] = $path3;
        $data['editer'] = $_POST['editer'];
        $data['tags'] = implode(',',$_POST['tag']);
        $data['froms'] = $_POST['froms'];
        if($_POST['introduction']==3){
            $data['video'] = $_POST['video_url'];
        }else{
            $data['video'] = null;
        }
        $data['dm'] = $_POST['content'];
        
        $model = M("journalism");
        if($model->where('jid='.$jid)->save($data)){
            $da2 = $model->where("jid=".$jid)->find();
            $this->assign("data",$da2);
            $this->display("Journalism/EditJournalismIdInfo");
        }else{
            $da2 = $model->where("jid=".$jid)->find();
            $this->assign("data",$da2);
            $this->display("Journalism/EditJournalismIdInfo");
        }
    }


    /*
     * 删除趣闻
     * */
    public function JournalismDel()
    {
        $id = $_GET['id'];
        $model = M("journalism");
        $model->where('jid='.$id)->delete();
    }

    /*
     * 趣闻广告
     * */
    public function JournalismBannerForm(){
        $this->display();
    }

    /*
     * 添加趣闻广告
     * */
    public function JournalismBannerSub()
    {
        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("Journalism/JournalismBannerForm");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);

        $jid = $_POST['jid'];
        $title = $_POST['title'];

        //处理图片
        $imginfo = $_FILES['img'];
        $imgname = $imginfo['name'];
        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
        $imgpath = $imginfo['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据

        $model = M("journalismbanner");
        $data['img'] = $path;
        $data['jid'] = $jid;
        $data['status'] = 1;
        $data['create_time'] = time();
        $data['update_time'] = time();
        $data['title'] = $title;
        if($model->add($data)){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign("num",1);
            $this->display("Journalism/JournalismBannerForm");
        }else{
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign("num",2);
            $this->display("Journalism/JournalismBannerForm");
        }

    }

    /*
     * 趣闻广告详情
     * */
    public function JournalismBannerInfo()
    {
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 6;

        $model = M("journalismbanner");
        $data = $model->select();

        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * 趣闻广告修改
     * */
    public function EditJournalismBannerIdInfo(){
        $id = $_GET['id'];
        $model = M("journalismbanner");
        $data = $model->where('id='.$id)->find();
        $this->assign('data',$data);
        $this->display();
    }

    /*
     * 修改
     * */
    public function EditJournalismBannerInfo(){
        $id = $_POST['id'];
        $data['jid'] = $_POST['jid'];
        $data['title'] = $_POST['title'];
        $data['status'] = $_POST['status'];
        $model = M("journalismbanner");
        if($model->where('id='.$id)->save($data)){
            echo json_encode(['code'=>200,'msg'=>'广告信息修改成功']);
        }else{
            echo json_encode(['code'=>201,'msg'=>'请检查广告修改信息']);
        }
    }
    /*
     * 趣闻广告删除
     * */
    public function JournalismBDel(){
        $id = $_GET['id'];
        $model = M("journalismbanner");
        $model->where('id='.$id)->delete();
    }

    /*
     * 趣闻搜索
     * */
    public function JournalismSearchWord(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $word = $_GET['word'];
        $model = M("journalism");
        $condition['jid'] = $word;
        $condition['title'] = array('like',"$word%");
        $condition['_logic'] = 'OR';// 把查询条件传入查询方法
        $data = $model->where($condition)->select();

        $val = $this->search_page_array($PageSize,$page,$data,0,$word);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->assign('word',$word);
        $this->display("Journalism/JournalismInfo");
    }
}