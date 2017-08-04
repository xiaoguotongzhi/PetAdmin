<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
       $this->display();
    }

    /*
     * 狗牌链接生成并入库
     * */
    public function EWMshuju(){
        for($i=1;$i<=1200;$i++){
            $token = base64_encode(rand(0,99999999));
            $res = 'https://www.peita.net?ak='.$token."B1";
            $model = M("ewmlists");
            $data['ewm_url'] = $res;
            $model->add($data);
            echo "成功<hr/>";
        }
    }


    /*
     * 狗牌说明书页面
     * */
    public function CardExplain(){
        $this->display();
    }
}