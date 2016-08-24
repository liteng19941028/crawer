<?php
namespace Home\Controller;
use Think\Controller;
class CrawFJController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $area_copy = M('house_area_copy');
        $area_price = M('house_area_price');
        $obj = M();
        //$address = $obj->query("select * from house_area_copy where id not in (select area_id from house_area_price) and (pid in (select id from house_area_copy where pid=0) or pid=0)");        //区域和城市
        $address = $obj->query("select * from house_area_copy where id not in (select area_id from house_area_price) and (pid not in (select id from house_area_copy where pid=0) and pid<>0)");//板块
        $urls = $raw = array();
        foreach($address as $val) {
            $row = array();
            if ($val['pid'] == 0) {
                $row['url'] = "http://{$val['spell']}.anjuke.com/market/";
                $row['id'] = $val['id'];
            } else {
                $city = $area_copy->where("id={$val['pid']}")->find();
                if ($city['pid'] != 0) {
                    $city = $area_copy->where("id={$city['pid']}")->find();
                }
                $row['url'] = "http://{$city['spell']}.anjuke.com/market/{$val['spell']}/";
                $row['id'] = $val['id'];
            }
            $urls[] = $row;
        }
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; 4399Box.560; .NET4.0C; .NET4.0E)');    //$context = stream_context_create($opts);
        $fail = $row = array();
        foreach($urls as $val) {
            $row = array();
            $html = file_get_contents($val['url']);
            //echo $http_response_header[0] . '<br>';
            if (strstr($http_response_header[0], '200')) {
                $preg = '/ydata:\[\{"name"\:".*"\,"data":\[(.*?)\]\}\]/';
                preg_match_all($preg, $html, $data);
                $row = array();
                $row['data'] = $data[1][0];
                if (!empty($row['data'])) {
                    $row['area_id'] = $val['id'];
                    $area_price->add($row);
                }
            }else{
                $row['url'] = $val['url'];
                $row['response_header'] = $http_response_header[0];
                $fail[] = $row;
                $row['data'] = "0,0,0,0,0,0,0,0,0,0,0,0";
                $row['area_id'] = $val['id'];
                $area_price->add($row);
            }
        }
        echo "一共请求".count($urls)."条<br>\n";
        echo "失败".count($fail)."条,失败的信息：<br>\n";
        print_r($fail);
    }
}