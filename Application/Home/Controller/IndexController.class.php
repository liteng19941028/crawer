<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        die;
        $mod = M('soufangmaifangzhishi');
        $data = $mod->field('id,article')->where('updated=0')->order("id")->limit(I('get.t'))->select();
        foreach($data as $k=>$val){
            $search = array('http://','www','cn','red','com','cn','wang','cc','in','ren','com','red','pub','co','net','org','info','xyz','site','club','win');
            $val['article'] = str_replace($search,'',$val['article']);
            $val['article'] = preg_replace('/[\d]{8,}/i',"********",$val['article']);
            $val['article'] = preg_replace('/<img .*?\/?>/i',"",$val['article']);
            $val['article'] = preg_replace('/<\/a>/i',"",$val['article']);
            /*preg_match_all('<img.*?src="(.*?)">',$val['article'],$imgurls);
            foreach($imgurls[1] as $v){
                $img = GrabImage($v);
                $val['article'] = str_replace($v ,$img ,$val['article']);
            }*/
            $val['updated'] = 1;
            $mod->where("id={$val['id']}")->save($val);
        }
        echo "完成";
    }

    public function downImg(){
        $img = GrabImage("http://fs.fangdd.com/thumb/200m150/000/009/576/IICU3hCNa6Vp_jzfy48FvccCZk0.jpg", "");
        if ($img):echo '<pre><img src="' . $img . '"></pre>';
//如果返回值为真，这显示已经采集到服务器上的图片
        else:echo "false";
        endif;
    }

    public function exchange(){
        $mod = M('article');
        $data = $mod->field('id,content,add_time')->where("id>1583")->select();
        foreach($data as $k=>$val){
            $val['content'] = preg_replace("/<a [^>]*>.*<\/a>/","",$val['content']);
            $val['content'] = preg_replace("/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif | \.jpg | \.png]))[\'|\"].*?[\/]?>/","",$val['content']);
            $val['content'] = str_replace(array("）","(","（","讯："),"",$val['content']);
            $mod->where("id={$val['id']}")->save($val);
        }
        echo "完成";
    }

    public function create_xml(){
        $s = I("get.start");
        $data = \Org\PHPExcel\ExcelToArray::read('E:\Users\soarlee\Desktop\loupan.xls');
        unset($data[1]);
        $data = array_slice($data,$s,500);
        //$str = '<DOCUMENT>';
        $str = '';
        foreach($data as $val){
            //const FJ_URL = '10.0.5.56:8044';    //开发环境
            //const FJ_URL = '10.0.1.82:9044';    //测试环境
            //const FJ_URL = 'fspu.esf.fdd';    //正式环境
            //echo "http://fspu.esf.fdd/dictionary/cells/{$val[0]}";die;
            $rs = curl_get("http://10.0.1.82:9044/dictionary/cells/{$val[0]}");
            $row = $rs['data'];
            $str .= "<item><key>{$val[1]}</key><display><title>{$val[1]}二手房房源-房多多</title><url>http://m.fangdd.com/h5/sale/all?cell_id={$val[0]}&amp;city_id={$row['cityId']}&amp;utm_source=baidu_alading_h5&amp;utm_medium=cpc</url><icon link=\"http://m.fangdd.com/h5/sale/all?cell_id={$val[0]}&amp;city_id={$row['cityId']}&amp;utm_source=baidu_alading_h5&amp;utm_medium=cpc\" imgurl=\"{$row['coverImage']['imageUrl']}\"/><price title=\"均价：\" value=\"{$row['cellPrice']}\" unit=\"元/平方米\"/><info title=\"年代：\" value=\"{$row['cellCompletionTime']}\"/><info title=\"类型：\" value=\"{$row['propertyType']}\"/><info title=\"地址：\" value=\"{$row['cellAddress']}\"/><btn txt=\"二手房源\" link=\"http://m.fangdd.com/h5/sale/all?cell_id={$val[0]}&amp;city_id={$row['cityId']}&amp;utm_source=baidu_alading_h5&amp;utm_medium=cpc\"/><btn txt=\"验真房源\" link=\"http://m.fangdd.com/h5/sale/all?cell_id={$val[0]}&amp;city_id={$row['cityId']}&amp;utm_source=baidu_alading_h5&amp;utm_medium=cpc&amp;tag=%E4%B8%8A%E9%97%A8%E9%AA%8C%E7%9C%9F\"/><resource title=\"房多多\"/><moreHouse title=\"更多相关房源\" link=\"http://m.fangdd.com/h5/sale/all?city_id={$row['cityId']}&amp;utm_source=baidu_alading_h5&amp;utm_medium=cpc\"/></display></item>";
        }
        //$str .= "</DOCUMENT>";
        $file = fopen("a.xml",'a');
        fwrite($file,$str);
        fclose($file);
        echo "done";die;
    }
}