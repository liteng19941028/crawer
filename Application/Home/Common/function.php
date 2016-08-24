<?php
function sortArrByField(&$arrUsers , $field, $direction = 'SORT_DESC'){
    $arrSort = array();
    foreach($arrUsers AS $k=>$v ){
        $arrSort[$k] = $v[$field];
    }
    return array_multisort($arrSort, constant($direction), $arrUsers);
}

function str_replace_once($needle, $replace, $haystack) {

// Looks for the first occurence of $needle in $haystack

// and replaces it with $replace.
    foreach($needle as $k=>$val){
        $pos = strpos($haystack, $val);
        if ($pos !== false) {
            $haystack = substr_replace($haystack, $replace[$k], $pos, strlen($val));
        }
    }

    return $haystack;

}

function setArticle($html){
    $html = htmlspecialchars_decode($html);
    $search = array('http://','www','cn','red','com','cn','wang','cc','in','ren','com','red','pub','co','net','org','info','xyz','site','club','win');
    $html = str_replace($search,'',$html);
    $html = preg_replace('/400-[\d]+.*?转.*?[\d]+/i',"********",$html);
    $html = preg_replace('/400-[\d]+/i',"********",$html);
    $html = preg_replace('/[\d]{8,}/i',"********",$html);
    $html = preg_replace('/<img.*?>/i',"",$html);
    $html = preg_replace('/<a[^>]*>/i',"",$html);
    $html = preg_replace('/<\/a>/i',"",$html);
    $html = preg_replace('/<p class="related">.*?<\/p>/i',"",$html);
    $html = preg_replace('/<iframe.*?<\/iframe>/i',"",$html);

    return $html;
}

function arr_strstr($str,$arr){
    foreach($arr as $val){
        if(strstr($str,$val)){
            return true;
        }
    }
    return false;
}

function curl_get($url, $gzip=false){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($curl, CURLOPT_TIMEOUT,10);
    if($gzip) curl_setopt($curl, CURLOPT_ENCODING, "gzip"); // 关键在这里
    $content = curl_exec($curl);
    curl_close($curl);
    return json_decode($content ,true);
}
/*
 *      函数库
 * */

function getFriendUrl(){
    return D('Seo')->getSeoList();
}
//获取楼盘资讯类型
function info_type( $name ){
    $houseinfo_type = C('info_type');
    return $houseinfo_type[$name];
}

//获取百科类型
function wiki_type( $name ){
    $wiki_type = C('wiki_type');
    return $wiki_type[$name];
}

//获取问答类型
function question_type( $name ){
    $question_type = C('question_type');
    return $question_type[$name];
}

//获取聚焦专题类型
function focus_type( $name ){
    $focus_type = C('focus_type');
    return $focus_type[$name];
}



//获取图片类型码
function img_column( $name ){
    $img_type = C('img_column');
    return $img_type[$name];
}
//获取文章大类型
function article_column( $name ){
    $article_type = C('article_column');
    return $article_type[$name];
}

//错误页面
function error($str){
    echo $str?$str:'system error!';
    die;
}


//分页起始
function pageOffset($page,$size){
    return ($page-1)*$size;
}

//url指向类型
function dispatch(){
    if(in_array(ACTION_NAME,array('index','stamp','support','getmorelist'))){
        return ACTION_NAME;
    }
    return  is_numeric(ACTION_NAME)?'id':'type';
}

//文章截取
function sub_article($str){
    return mb_substr(preg_replace("/(\s|\&nbsp\;|　|\xc2\xa0)/", "", strip_tags($str)),0,120,'utf-8').'...';
}

function error_404($obj){
    @header("HTTP/1.1 404 Not Found");
    @header("Status: 404 Not Found");
    $obj->display("Public:404");die;
}

function redisInit(){
    $redis = new redis();
    $redis->connect('127.0.0.1', 6379);
    return $redis;
}

//获取新房数据
function newHouse($city_id = null){
    $redis = redisInit();
    if(!$city_id){
        $city_id = getCityData();
        $city_id = $city_id['id'];
    }
    $cacheTime = $redis->get('newHouseTime_'.$city_id);
    $now = time();
    if(!$cacheTime || $now-$cacheTime>86400) {
        $rs = curl_init();
        //'http://api.nh.fangdd.com/c/loupans/hot?cityId=1337&limit=3'
        curl_setopt($rs, CURLOPT_URL, "http://api.nh.fangdd.com/c/loupans/hot?cityId={$city_id}&limit=10");
        curl_setopt($rs, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rs, CURLOPT_TIMEOUT_MS, 2000); //超时时间200毫秒
        curl_setopt($rs, CURLOPT_HEADER, 0);
        $json = curl_exec($rs);
        curl_close($rs);
        $result = json_decode($json, true);
        if ($result['code'] != 200) {
            return false;
        }else{
            $redis->set('newHouseTime_'.$city_id,time());
            $redis->set('newHouse_'.$city_id,$json);
        }
    }else{
        $json = $redis->get('newHouse_'.$city_id);
        $result = json_decode($json, true);
    }
    foreach($result['data'] as $k=>$val){
        $result['data'][$k]['districtName'] = mb_substr($val['districtName'],0,2,'utf-8');
        $result['data'][$k]['loupanArea'] = mb_substr($val['loupanArea'],0,2,'utf-8');
        $result['data'][$k]['loupanPrice'] = !$val['loupanPrice']?"售价待定":$val['loupanPrice'].'元/平';
    }
    return $result['code']==200?$result['data']:false;
}

//获取二手房数据
function oldHouse($city_id = null){
    $redis = redisInit();
    if(!$city_id){
        $city_id = getCityData();
        $city_id = $city_id['id'];
    }
    $cacheTime = $redis->get('oldHouseTime_'.$city_id);
    $now = time();
    if(!$cacheTime || $now-$cacheTime>86400){
        $rs = curl_init();
        curl_setopt($rs, CURLOPT_URL, "http://m.fangdd.com/h5/sale/get_all?page=1&limit=10&city_id={$city_id}");
        curl_setopt($rs, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($rs, CURLOPT_TIMEOUT_MS, 2000); //超时时间200毫秒
        curl_setopt($rs, CURLOPT_HEADER, 0);
        $json = curl_exec($rs);
        curl_close($rs);

        $redis->set('oldHouseTime_'.$city_id,time());
        $redis->set('oldHouse_'.$city_id,$json);
    }else{
        $json = $redis->get('oldHouse_'.$city_id);
    }

    $result = json_decode($json,true);
    return $result['code']=='00000'?$result['data']:false;
}

function getCityData($spell = null){
    $default = array("id"=>'121',"area_name"=>"上海","spell"=>'shanghai','pid'=>0);
    if( empty($spell) ){
        $ip = $_SERVER["REMOTE_ADDR"];
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if(empty($res)){
            return $default;
        }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if(!isset($jsonMatches[0])){ return $default; }
        $json = json_decode($jsonMatches[0], true);
        if(isset($json['ret']) && $json['ret'] == 1){
            $json['ip'] = $ip;
            unset($json['ret']);
        }
        $spell =  $json['city'];
    }
    $m = M('area_copy');
    $data = $m->where("area_name='{$spell}' or spell='{$spell}' or id='{$spell}'")->find();
    return $data ? $data:$default;
}

function randSections($city_id){
    $randSections = M()->query("select * from house_rand_sections a join house_area_copy b on a.section_id=b.id where a.city_id={$city_id}");
    if(empty($randSections)){
        $randSections = M()->query("select * from house_area_copy where pid in (select id from house_area_copy where pid={$city_id}) order by rand() limit 20");
        $data = $row = array();
        foreach($randSections as $val){
            $row['section_id'] = $val['id'];
            $row['city_id'] = $city_id;
            $row['area_name'] = $val['area_name'];
            $data[] = $row;
        }
        M('rand_sections')->addAll($data);
    }
    return $randSections;
}

function getCityPin($cityName) {
    switch($cityName) {
        case '上海':
            $result = 'shanghai';
            break;
        case '苏州':
            $result = 'suzhou';
            break;
        case '杭州':
            $result = 'hangzhou';
            break;
        case '南京':
            $result = 'nanjing';
            break;
        case '广州':
            $result = 'guangzhou';
            break;
        case '深圳':
            $result = 'shenzhen';
            break;
    }

    return $result;
}

function getPinCity($pin) {
    switch($pin) {
        case 'shanghai':
            $result = '上海';
            break;
        case 'suzhou':
            $result = '苏州';
            break;
        case 'hangzhou':
            $result = '杭州';
            break;
        case 'nanjing':
            $result = '南京';
            break;
        case 'guangzhou':
            $result = '广州';
            break;
        case 'shenzhen':
            $result = '深圳';
            break;
    }

    return $result;
}

function getHost() {
    return 'http://' . $_SERVER['HTTP_HOST'];
}
?>