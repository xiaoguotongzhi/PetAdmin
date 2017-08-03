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
class PetCateController extends LoginController
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
     * 添加宠物分类表单
     * */
    public function AddNewPetCate(){
        $this->display();
    }

    /*
     * 添加品种
     * */
    public function AddNewCate(){

        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("PetCate/AddNewPetCate");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);


        //品种
        $cate_name = $_POST['cate_name'];
        //类型
        $variety_id = $_POST['variety_id'];
        //别名
        $alias_name = $_POST['alias_name'];
        //别名缩写
        $alias_jx = $_POST['alias_jx'];
        //全拼
        $py = $_POST['py'];
        //简写
        $jx = $_POST['jx'];
        //首字母
        $aleph = $_POST['aleph'];

        //品种图
        $imginfo = $_FILES['img'];
        $imgname = $imginfo['name'];
        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
        $imgpath = $imginfo['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据

        $model = M("pet_category");
        $data['variety_id'] = $variety_id;
        $data['cate_name'] = $cate_name;
        $data['alias_name'] = $alias_name;
        $data['alias_jx'] = $alias_jx;
        $data['py'] = $py;
        $data['jx'] = $jx;
        $data['aleph'] = $aleph;
        $data['is_hot'] = 0;
        $data['hot_pic'] = $path;
        if($model->add($data)){
            $this->assign('num',1);
            $this->display("PetCate/AddNewPetCate");
        }else{
            $this->assign('num',2);
            $this->display("PetCate/AddNewPetCate");
        }

    }


    //品种详情
    public function PetCateInfo(){
        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 6;

        $model = M("pet_category");
        $data = $model->select();
        $val = $this->page_array($PageSize,$page,$data,0);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->display();
    }

    /*
     * id查看详情
     * */
    public function PetCateIdInfo(){
        $id = $_GET['id'];
        $model = M("pet_category");
        $data = $model->where("id=".$id)->find();
        $this->assign("data",$data);
        $this->display();
    }


    /*
     * 修改宠物信息
     * */
    public function SaveNewCate(){
        if($_SESSION['code']!=$_POST['scode']){
            header('Cache-Control:no-cache,must-revalidat');
            header('Pragma:no-cache');
            $this->assign('num',4);
            $this->display("PetCate/AddNewPetCate");
            exit;
        }
        $_SESSION['code']=mt_rand(1,1000);

        //ID
        $id = $_POST['id'];
        //品种
        $cate_name = $_POST['cate_name'];
        //类型
        $variety_id = $_POST['variety_id'];
        //别名
        $alias_name = $_POST['alias_name'];
        //别名缩写
        $alias_jx = $_POST['alias_jx'];
        //全拼
        $py = $_POST['py'];
        //简写
        $jx = $_POST['jx'];
        //首字母
        $aleph = $_POST['aleph'];

        //品种图
        $imginfo = $_FILES['img'];
        $imgname = $imginfo['name'];
        $oss = new \Oss();//实例化oss类
        $rand = rand(1,99999).time();   //时间戳拼接五位随机数，作为图片名称
        $suffix = substr($imgname,strrpos($imgname,".")+1);   //截取图片的后缀名字
        $object = "question/".$rand.".".$suffix;   //拼接上传到oss 之中的路径
        $imgpath = $imginfo['tmp_name'];
        $oss -> upload($object,$imgpath);   //调用oss类中的upload方法
        $path = "http://peita.oss-cn-beijing.aliyuncs.com/".$object;   //入数据表表img字段的数据

        $model = M("pet_category");
        $data['variety_id'] = $variety_id;
        $data['cate_name'] = $cate_name;
        $data['alias_name'] = $alias_name;
        $data['alias_jx'] = $alias_jx;
        $data['py'] = $py;
        $data['jx'] = $jx;
        $data['aleph'] = $aleph;
        $data['is_hot'] = 0;
        $data['hot_pic'] = $path;
        if($model->where('id='.$id)->save($data)){
            $this->assign('num',1);
            $this->display("PetCate/AddNewPetCate");
        }else{
            $this->assign('num',2);
            $this->display("PetCate/AddNewPetCate");
        }
    }

    /*
     * 搜索
     * */
    public function PetCateSearchWord()
    {

        $page = $_GET['page']?$_GET['page']:'1';
        $PageSize = 8;

        $word = $_GET['word'];
        $model = M("pet_category");

        //宠物类型(1.狗2.猫3.鼠4.其它)
        if($word=='狗'){
            $word_res = 1;
        }else if($word=='猫'){
            $word_res = 2;
        }else if($word == '鼠'){
            $word_res = 3;
        }else{
            $word_res = 4;
        }

        // $condition['id'] = array('like',"$word%");
        // $condition['variety_id'] = array('like',"$word_res%");
        $condition['cate_name'] = array('like',"$word%");
        // $condition['alias_name'] = array('like',"$word%");
        // $condition['alias_jx'] = array('like',"$word%");
        // $condition['py'] = array('like',"$word%");
        // $condition['jx'] = array('like',"$word%");
        // $condition['aleph'] = array('like',"$word%");
        // $condition['_logic'] = 'OR';// 把查询条件传入查询方法
        $data = $model->where($condition)->select();

        $val = $this->search_page_array($PageSize,$page,$data,0,$word);

        $this->assign('data',$val['PageData']);
        $this->assign('page',$val['LastPage']);
        $this->assign('word',$word);
        $this->display("PetCate/PetCateInfo");

    }

    public function PetCateDel(){
        $id = $_GET['id'];
        $model = M("pet_category");
        $model->where('id='.$id)->delete();
    }
}