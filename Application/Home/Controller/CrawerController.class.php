<?php
namespace Home\Controller;
use Think\Controller;
class CrawerController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $urls = array(

                'http://yufabu.com/crawer/loupanWang?u=shanghai&d=1',
                'http://yufabu.com/crawer/loupanWang?u=hangzhou&d=1',
                'http://yufabu.com/crawer/loupanWang?u=suzhou&d=1',
                'http://yufabu.com/crawer/loupanWang?u=shenzhen&d=1',
                'http://yufabu.com/crawer/loupanWang?u=guangzhou&d=1',
                'http://yufabu.com/crawer/loupanWang?u=nanjing&d=1',

                'http://yufabu.com/crawer/souFang?u=shanghai&d=1',
                'http://yufabu.com/crawer/souFang?u=hangzhou&d=1',
                'http://yufabu.com/crawer/souFang?u=suzhou&d=1',
                'http://yufabu.com/crawer/souFang?u=shenzhen&d=1',
                'http://yufabu.com/crawer/souFang?u=guangzhou&d=1',
                'http://yufabu.com/crawer/souFang?u=nanjing&d=1',

                'http://yufabu.com/crawer/houseNews?d=1',

                'http://yufabu.com/crawer/sinaHouse?d=1',
                'http://yufabu.com/crawer/sinaHouse_1?d=1',
                'http://yufabu.com/crawer/sinaHouse_2?d=1',

                'http://yufabu.com/crawer/hexunwang?d=1',

                'http://yufabu.com/crawer/tencent?d=1',

                'http://yufabu.com/crawer/leju?d=1'
        );
        $this->display();
    }

    public function manageData()
    {
        header('Content-type: text/html; charset=utf-8');
        $dir = 'E:\Users\soarlee\Desktop\articles';
        //读取路径下所有文件
        $filePathes = array();
        $file=scandir($dir);
        foreach($file as $val){
            if($val != '.'&& $val != '..') {
                $filePath = $dir . '\\' . $val;
                $file1 = scandir($filePath);
                foreach ($file1 as $v) {
                    if ($v != '.' && $v != '..') {
                        $filePathes[] = $filePath .'\\'. $v;
                    }
                }
            }
        }

        $obj = new \Org\PHPExcel\ExcelToArray();
        foreach($filePathes as $val){
            $res = $obj->read($val, strtolower('xlsx'));        //每个excel中的文章
            foreach($res as $k=>$v){
                $article = $v[1];
                //对文章进行处理
                $search = array('http://','www','cn','red','com','cn','wang','cc','in','ren','com','red','pub','co','net','org','info','xyz','site','club','win');
                $article = str_replace($search,'',$article);
                $article = preg_replace('/400-[\d]+转[\d]+/i',"********",$article);
                $article = preg_replace('/[\d]{8,}/i',"********",$article);
                $article = preg_replace('/<img.*?>/i',"",$article);
                $article = preg_replace('/<a[^>]*>/i',"",$article);
                $article = preg_replace('/<\/a>/i',"",$article);
                $article = preg_replace('/<h1.*?<\/h1>/i',"",$article);

               /* $article = preg_replace('/<div class="newsnav">.*?class="txtmsg">/is','<div class="txtmsg">',$article);

                $article = preg_replace('/<div class="blank10">.*?<div class="n" id="zoom">/is','<div class="n" id="zoom">',$article);
                $article = preg_replace('/<div id="pnav" class="pnav".*?<\/div>/is','',$article);*/

                $res[$k][1] = $article;
            }
            $temp = explode('\\',$val);
            $savePath = './Public/upfile/excel/'.$temp[count($temp)-2].'/';
            $fileName = $temp[count($temp)-1];
            if(!is_dir($savePath)){
                mkdir($savePath);
            }
            $obj->push($res ,$fileName,0,$savePath);
        }
        echo '完成';
    }

    public function loupanWang()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y-m-d',strtotime("-{$days} day"));
        $urls = array(
            'shanghai'=>array('http://sh.loupan.com/news/list-36.html','http://sh.loupan.com/news/list-37.html','http://sh.loupan.com/news/list-38.html','http://sh.loupan.com/news/list-129.html'),
            'guangzhou'=>array('http://gz.loupan.com/news/list-36.html','http://gz.loupan.com/news/list-37.html','http://gz.loupan.com/news/list-38.html','http://gz.loupan.com/news/list-129.html'),
            'hangzhou'=>array('http://hz.loupan.com/news/list-36.html','http://hz.loupan.com/news/list-37.html','http://hz.loupan.com/news/list-38.html','http://hz.loupan.com/news/list-129.html'),
            'nanjing'=>array('http://nj.loupan.com/news/list-36.html','http://nj.loupan.com/news/list-37.html','http://nj.loupan.com/news/list-38.html','http://nj.loupan.com/news/list-129.html'),
            'shenzhen'=>array('http://sz.loupan.com/news/list-36.html','http://sz.loupan.com/news/list-37.html','http://sz.loupan.com/news/list-38.html','http://sz.loupan.com/news/list-129.html'),
            'suzhou'=>array('http://suzhou.loupan.com/news/list-36.html','http://suzhou.loupan.com/news/list-37.html','http://suzhou.loupan.com/news/list-38.html','http://suzhou.loupan.com/news/list-129.html'),
        );
        $type = I('get.u');
        $url = $urls[$type];
        if(!$url){
            echo "参数错误";
            return;
        }
        $types = array('1','1','2','3');
        $city_ids = array('shanghai'=>'121','suzhou'=>'3','hangzhou'=>'2316','nanjing'=>'267','guangzhou'=>'852','shenzhen'=>'1337');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->curlloupan($val,$todate);
            foreach($data as $key=>$v){
                $data[$key]['area_id'] = $city_ids[$type];
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':$types[$k];
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }
        echo 'done ';
    }

    private function curlloupan( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        if($page!=1) str_replace(array('.html','htm'),'',$url)."-{$page}.html";
        $htmlsource = curl_get( $url , true);
        preg_match_all('/<li class="nopic.*?>(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $k=>$val){
            preg_match('/<p.*?class="time">(.*?)<\/p>/is',$val,$timestr);
            $date = mb_substr($timestr[1] ,0 ,10 ,'utf-8');
            $time = mb_substr($timestr[1] ,16 ,8 ,'utf-8');

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<h3.*?<a href="(.*?)".*?\/h3>/is',$val,$href);
                    $htmlsource = curl_get( 'http://'.explode('/',$url)[2].$href[1] , true);

                    preg_match('/<h1.*?class="news-title">(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //preg_match('/<p.*?class="time-form">(.*?) 来源：.*?\/p>/is',$htmlsource,$content);
                    //$data['show_time'] = $content[1];
                    preg_match('/<p.*?class="time-form">.*? 来源：(.*?)<\/p>/is',$htmlsource,$content);
                    $data['content_from'] = $content[1];
                    preg_match('/<div.*?id="news_content_box_id".*?>(.*?)<\/div>/is',$htmlsource,$content);
                    $data['article'] = $content[1];

                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }*/
        return $title;
    }

    public function souFang()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y/m/d',strtotime("-{$days} day"));
        $urls = array(
            'shanghai'=>array('http://news.focus.cn/sh/yaowen/','http://news.focus.cn/sh/shichang/','http://news.focus.cn/sh/zhengce/'),
            'hangzhou'=>array('http://news.focus.cn/hz/yaowen/','http://news.focus.cn/hz/shichang/','http://news.focus.cn/hz/zhengce/'),
            'nanjing'=>array('http://news.focus.cn/nj/yaowen/','http://news.focus.cn/nj/shichang/','http://news.focus.cn/nj/zhengce/'),
            'suzhou'=>array('http://news.focus.cn/suzhou/yaowen/','http://news.focus.cn/suzhou/shichang/','http://news.focus.cn/suzhou/zhengce/'),
            'shenzhen'=>array('http://news.focus.cn/sz/yaowen/','http://news.focus.cn/sz/shichang/','http://news.focus.cn/sz/zhengce/'),
            'guangzhou'=>array('http://news.focus.cn/gz/yaowen/','http://news.focus.cn/gz/shichang/','http://news.focus.cn/gz/zhengce/')
        );
        $type = I('get.u');
        $url = $urls[$type];
        if(!$url){
            echo "参数错误";
            return;
        }
        $types = array('1','1','2');
        $city_ids = array('shanghai'=>'121','suzhou'=>'3','hangzhou'=>'2316','nanjing'=>'267','guangzhou'=>'852','shenzhen'=>'1337');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->curl($val,$todate);
            foreach($data as $key=>$v){
                $data[$key]['area_id'] = $city_ids[$type];
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':$types[$k];
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }
        echo 'done ';
    }

    private function curl($url,$todate,$title = array(),$page = 1)
    {
        $cnt = 0;
        $htmlsource = curl_get("{$url}{$page}/" , true);
        preg_match_all('/<li class="item clearfix">(.*?)<\/li>/is',$htmlsource,$result);
        foreach($result[1] as $val){
            preg_match('/<span class="note-time">(.*?)<\/span>/is',$val,$timestr);
            $date = mb_substr($timestr[1] ,0 ,10 ,'utf-8');
            $time = mb_substr($timestr[1] ,16 ,8 ,'utf-8');

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<a href="(.*?)" target="_blank">/is',$val,$href);
                    $htmlsource = curl_get($href[1] , true);
                    preg_match('/<h1>(.*?)<\/h1>/is',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //preg_match('/<div class="info-source">[^<]*<span>(.*?)<\/span>/is',$htmlsource,$content);
                    //$data['show_time'] = $content[1];
                    preg_match('/<span>来源：[^>]*>(.*?)<\/a>[^<]*<\/span>/is',$htmlsource,$content);
                    $data['content_from'] = $content[1];
                    preg_match('/<div class="n-d-content" id="newscontent">(.*?)<\/div>/is',$htmlsource,$content);
                    $data['article'] = $content[1];

                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curl($url, $todate, $title, $page);
        }*/
        return $title;
    }

    public function houseNews()
{
    $days = intval(I('get.d',1));
    $todate = date('Y-m-d',strtotime("-{$days} day"));
    $urls = array(
        array('http://www.fcxzx.cn/news/zhengcefagui/',
            'http://www.fcxzx.cn/news/xinpankuaixun/',
            'http://www.fcxzx.cn/news/loushijiaodian/',
            'http://www.fcxzx.cn/news/nhouse/'
        )
    );
    $url = $urls[0];

    $types = array('2','1','6','1');
    $news = M('info');
    $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
    foreach($url as $k=>$val){
        $data = $this->houseNewsCurl($val,$todate);
        foreach($data as $key=>$v){
            $data[$key]['area_id'] = '999999';
            $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':$types[$k];
            $data[$key]['dtitle'] = $v['title'];

            if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                $news->add($data[$key]);
            }
        }
    }
    echo 'done ';
}

    private function houseNewsCurl( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        $htmlsource = curl_get( $url.$page.'.html' , true);
        preg_match('/<ul id="newsList">(.*?)<\/ul>/is',$htmlsource,$result);
        $htmlsource = $result[1];
        preg_match_all('/<li>(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $val){
            preg_match('/<span class="date">\((.*?)\)<\/span>/is',$val,$timestr);
            $date = mb_substr($timestr[1] ,0 ,10 ,'utf-8');
            $time = mb_substr($timestr[1] ,16 ,8 ,'utf-8');

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match_all('/<a.*?href=[\'\"](.*?)[\'\"].*?>/is',$val,$href);
                    $htmlsource = curl_get( $href[1][1] , true);

                    preg_match('/<h1.*?id="title">(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //$data['show_time'] = $date;
                    preg_match('/<div id="riqi".*?来源：(.*?)&nbsp;/is',$htmlsource,$content);
                    $data['content_from'] = $content[1];
                    preg_match('/<div class="con" id="zoom">(.*?)<\/div>/is',$htmlsource,$content);
                    $data['article'] = $content[1];

                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);

                    $title[] = $data;
                }
            }
        }
        if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }
        return $title;
    }

    //新浪房产
    public function sinaHouse()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y-m-d',strtotime("-{$days} day"));

        //城市页
        $urls = array(
            array(
                'http://sh.house.sina.com.cn/news/dongtai/',
                'http://suzhou.house.sina.com.cn/news/dongtai/',
                'http://hz.house.sina.com.cn/news/dongtai/',
                'http://nj.house.sina.com.cn/news/dongtai/',
                'http://gz.house.sina.com.cn/news/dongtai/',
                'http://sz.house.sina.com.cn/news/dongtai/',
            )
        );
        $url = $urls[0];
        $city_ids = array('121','3','2316','267','852','1337');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->sinaHouseCurl($val,$todate);
            foreach($data as $key=>$v){
                $data[$key]['area_id'] = $city_ids[$k];
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':'1';
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }

        echo 'done ';
    }

    private function sinaHouseCurl( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        $htmlsource = curl_get( $url , true);
        preg_match('/<ul class="new-list">(.*?)<\/ul>/is',$htmlsource,$result);
        $htmlsource = $result[1];
        preg_match_all('/<li class="new-li clearfix">(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $val){
            preg_match('/<span>.*?([\d]+年[\d]+月[\d]+).*?<\/span>/is',$val,$timestr);
            $date = str_replace(array('年','月','日'),'-',$timestr[1]);

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<a.*?href=[\'\"](.*?)[\'\"].*?>/is',$val,$href);
                    $htmlsource = curl_get( $href[1] , true);

                    preg_match('/<h1.*?class="title">(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //preg_match('/<span><strong>(.*?)<\/strong><\/span>/i',$htmlsource,$content);
                    //$data['show_time'] = $content[1];
                    preg_match('/<span>来源：<strong><span class="linkRed02 m0">(.*?)<\/span><\/strong><\/span>/is',$htmlsource,$content);
                    $data['content_from'] = $content[1];
                    preg_match('/<div class="article-body">(.*?)<\/div>/is',$htmlsource,$content);
                    $data['article'] = $content[1];

                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }*/
        return $title;
    }


    //新浪房产1
    public function sinaHouse_1()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y-m-d',strtotime("-{$days} day"));

        //城市页
        $urls = array(
            array(
                //'http://news.dichan.com/news/02.html',    //404无法采集
                'http://news.dichan.com/news/03.html',
                //'http://news.dichan.com/news/01.html',    //404无法采集
                //'http://news.dichan.com/news/04.html',    //404无法采集
                //'http://news.dichan.com/news.html',       //404无法采集
            )
        );
        $url = $urls[0];
        $types = array('1','2','2','1','1');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->sinaHouseCurl_1($val,$todate);
            foreach($data as $key=>$v){
                if(empty($v['title'])){
                    unset($data[$key]);
                    continue;
                }
                $data[$key]['area_id'] = '999999';
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':$types[$k];
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }
        echo 'done ';
    }

    private function sinaHouseCurl_1( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        $htmlsource = curl_get( $url , true);
        preg_match('/<ul class="article_list" >(.*?)<\/ul>/is',$htmlsource,$result);
        $htmlsource = $result[1];
        preg_match_all('/<li>(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $val){
            preg_match('/<div class=" gray time fr">(.*?) [\d]+:[\d]+<\/div>/is',$val,$timestr);
            $date = $timestr[1];

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<a.*?href=[\'\"](.*?)[\'\"].*?>/is',$val,$href);
                    $htmlsource = iconv("GB2312","UTF-8",curl_get( $href[1] , true));

                    preg_match('/<h1 id="h1Title">(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //preg_match('/<span id="pub_date">(.*?)<\/span>/i',$htmlsource,$content);
                    //$data['show_time'] = $content[1];
                    preg_match('/href="#">(.*?)<\/a>/is',$htmlsource,$content);
                    $data['content_from'] = $content[1];
                    preg_match('/<div id="divContent" class="blkContainerSblkCon blkContainerSblkCon_14">(.*?)<\/div>[^<]*?<div id="divAttachment">/is',$htmlsource,$content);
                    $data['article'] = $content[1];

                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }*/
        return $title;
    }


    //新浪房产1
    public function sinaHouse_2()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y-m-d',strtotime("-{$days} day"));

        //城市页
        $urls = array(
            array(
                'http://www.fangchan.com/news/1/',
                'http://www.fangchan.com/news/4/',
                'http://www.fangchan.com/news/5/',
                'http://www.fangchan.com/news/6/',
                'http://www.fangchan.com/news/9/'
            )
        );
        $url = $urls[0];
        $types = array('1','2','2','1','1');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->sinaHouseCurl_2($val,$todate);
            foreach($data as $key=>$v){
                if(empty($v['title'])){
                    unset($data[$key]);
                    continue;
                }
                $data[$key]['area_id'] = '999999';
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':$types[$k];
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }
        echo 'done ';
    }

    private function sinaHouseCurl_2( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        $htmlsource = file_get_contents( $url );
        preg_match('/<ul class="c_l_list">(.*?)<\/ul>/is',$htmlsource,$result);
        $htmlsource = $result[1];
        preg_match_all('/<li>(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $val){
            preg_match('/<span>(.*?)<\/span>/is',$val,$timestr);
            $date = $timestr[1];

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<a.*?href=[\'\"](.*?)[\'\"].*?>/is',$val,$href);
                    $htmlsource = file_get_contents( $href[1]);
                    //$htmlsource = iconv("GB2312","UTF-8",curl_get( $href[1] , true));

                    preg_match('/<h1 class="clearfix">(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //preg_match('/<span>([\d]+.*?)<\/span>/i',$htmlsource,$content);
                    //$data['show_time'] = $content[1];
                    preg_match('/<span>来源：<span>(.*?)<\/span><\/span>/is',$htmlsource,$from);
                    $data['content_from'] = $from[1];
                    preg_match('/<div class="summary_text">(.*?)<\/div>/is',$htmlsource,$content);
                    $data['article'] = $content[1];


                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }*/
        return $title;
    }


    //和讯网
    public function hexunwang()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y-m-d',strtotime("-{$days} day"));

        //城市页
        $urls = array(
            array(
                'http://house.hexun.com/list/',
                'http://house.hexun.com/list1/',
                'http://house.hexun.com/list2/',
                'http://house.hexun.com/finance/'
            )
        );
        $url = $urls[0];
        $types = array('1','5','2','3');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->hexunwangCurl($val,$todate);
            foreach($data as $key=>$v){
                if(empty($v['title'])){
                    unset($data[$key]);
                    continue;
                }
                $data[$key]['area_id'] = '999999';
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':$types[$k];
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }
        echo 'done ';
    }

    private function hexunwangCurl( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        $htmlsource = file_get_contents( $url );
        preg_match('/<div class="temp01">(.*?)<\/div>/is',$htmlsource,$result);
        $htmlsource = $result[1];
        preg_match_all('/<li>(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $val){
            preg_match('/<span>\((.*?) [\d]+:[\d]+\)<\/span>/is',$val,$timestr);
            $date = date('Y').'/'.$timestr[1];

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<a.*?href=[\'\"]*(.*?)[\'\"\ ].*?>/is',$val,$href);
                    //$htmlsource = curl_get( $href[1] );
                    $htmlsource = iconv("GB2312","UTF-8",curl_get( $href[1] , true));

                    preg_match('/<h1>(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //preg_match('/<span class="gray" id="pubtime_baidu">(.*?)<\/span>/i',$htmlsource,$show_time);
                    //$data['show_time'] = $show_time[1];
                    preg_match('/来源：<a href=".*?" target="_blank">(.*?)<\/a>/is',$htmlsource,$from);
                    $data['content_from'] = $from[1];
                    preg_match('/<div id="artibody" class="art_context">(.*?)<span id="arctTailMark"><\/span>/is',$htmlsource,$content);
                    $data['article'] = $content[1];


                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }*/
        return $title;
    }


    //腾讯大申网
    public function tencent()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y-m-d',strtotime("-{$days} day"));

        //城市页
        $urls = array(
            array(
                'http://sh.house.qq.com/l/shloushi/list.htm',
                'http://suzhou.house.qq.com/2015/zxxw/zixun.htm',
                'http://hz.house.qq.com/l/news/list20110510151825.htm',
                'http://nj.house.qq.com/l/news/newslist.htm',
                'http://gz.house.qq.com/l/gdxw/more.htm',
                'http://sz.house.qq.com/l/sghgdxw/list.htm'
            )
        );
        $url = $urls[0];
        $city_ids = array('121','3','2316','267','852','1337');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->tencentCurl($val,$todate);
            foreach($data as $key=>$v){
                $data[$key]['area_id'] = $city_ids[$k];
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':'1';
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }

        echo 'done ';
    }

    private function tencentCurl( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        //$htmlsource = curl_get( $url , true);
        $htmlsource = iconv("GB2312","UTF-8",curl_get( $url , true));
        preg_match('/<div class="mod newslist"><ul>(.*?)<\/ul><\/div>/is',$htmlsource,$result);
        $htmlsource = $result[1];
        preg_match_all('/<li>(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $val){
            preg_match('/<span class="pub_time">(.*?)日.*?<\/span>/is',$val,$timestr);
            $date = str_replace(array('年','月','日'),'-',$timestr[1]);
            $date = date('Y').'-'.$date;

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<a.*?href=[\'\"]*(.*?)[\'\"\ ].*?>/is',$val,$href);
                    //$href[1] = str_replace('.htm','_all.htm#page1',$href[1]);
                    //$htmlsource = curl_get( $href[1] , true);
                    $htmlsource = iconv("GBK","UTF-8",curl_get( $href[1] , true));

                    preg_match('/<h1>(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    preg_match('/<span class="article-time">(.*?)<\/span>/i',$htmlsource,$content);
                    //$data['show_time'] = $content[1];
                    //preg_match('/<span>来源：<strong><span class="linkRed02 m0">(.*?)<\/span><\/strong><\/span>/is',$htmlsource,$content);
                    $data['content_from'] = '互联网';
                    preg_match('/<div id="Cnt-Main-Article-QQ" bossZone="content">(.*?)<\/div>/is',$htmlsource,$content);
                    $data['article'] = $content[1];

                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);
                    $data['article'] = preg_replace('/<P style="TEXT-INDENT: 2em">>>返回腾讯.*/is','',$data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }*/
        return $title;
    }


    //乐居
    public function leju()
    {
        $days = intval(I('get.d',1));
        $todate = date('Y-m-d',strtotime("-{$days} day"));

        //城市页
        $urls = array(
            array(
                'http://sh.leju.com/news/',
                'http://suzhou.leju.com/news/',
                'http://hz.leju.com/news/',
                'http://nj.leju.com/news/',
                'http://gz.leju.com/news/',
                'http://sz.leju.com/news/',
            )
        );
        $url = $urls[0];
        $city_ids = array('121','3','2316','267','852','1337');
        $news = M('info');
        $array = array("公积金","贷款","金融","股票","融资","众筹","首付贷");
        foreach($url as $k=>$val){
            $data = $this->lejuCurl($val,$todate);
            foreach($data as $key=>$v){
                $data[$key]['area_id'] = $city_ids[$k];
                $data[$key]['type'] = arr_strstr($v['title'],$array)?'3':'1';
                $data[$key]['dtitle'] = $v['title'];

                if(!empty($data[$key]['title']) && !($news->where("title='{$data[$key]['title']}'")->find())){
                    $news->add($data[$key]);
                }
            }
        }

        echo 'done ';
    }

    private function lejuCurl( $url,$todate,$title = array(),$page = 1 )
    {
        $cnt = 0;
        $htmlsource = curl_get( $url , true);
        //$htmlsource = iconv("GB2312","UTF-8",curl_get( $url , true));
        preg_match('/<ul class="new-list">(<li class="new-li clearfix">.*?)<\/ul>/is',$htmlsource,$result);
        $htmlsource = $result[1];
        preg_match_all('/<li class="new-li clearfix">(.*?)<\/li>/is',$htmlsource,$result);

        foreach($result[1] as $val){
            preg_match('/<span>.*?([\d]+年[\d]+月[\d]+).*?<\/span>/is',$val,$timestr);
            $date = str_replace(array('年','月','日'),'-',$timestr[1]);

            if( strtotime($date) >= strtotime($todate) ){
                $cnt++;
                if(strtotime($date) < strtotime(date('Y-m-d', time()))){
                    preg_match('/<a.*?href=[\'\"]*(.*?)[\'\"\ ].*?>/is',$val,$href);
                    //$href[1] = str_replace('.htm','_all.htm#page1',$href[1]);
                    $htmlsource = curl_get( substr($url,0,-6).$href[1] , true);
                    //$htmlsource = iconv("GBK","UTF-8",curl_get( $href[1] , true));

                    preg_match('/<h1 class="title">(.*?)<\/h1>/i',$htmlsource,$content);
                    $data['title'] = $content[1];
                    //preg_match('/<span><strong>(.*?)<\/strong><\/span>/i',$htmlsource,$content);
                    //$data['show_time'] = $content[1];
                    preg_match('/<span>来源：<strong><span class="linkRed02 m0">(.*?)<\/span><\/strong><\/span>/is',$htmlsource,$content);
                    $data['content_from'] = $content[1];
                    preg_match('/<div class="article-body">(.*?)<\/div>/is',$htmlsource,$content);
                    $data['article'] = $content[1];

                    //对文章进行处理
                    $data['article'] = setArticle($data['article']);
                    $data['article'] = preg_replace('/<strong>新浪乐居讯<\/strong>/is','',$data['article']);

                    $title[] = $data;
                }
            }
        }
        /*if($cnt == count($result[1])) {
            $page++;
            $title = $this->curlloupan($url, $todate, $title, $page);
        }*/
        return $title;
    }
}