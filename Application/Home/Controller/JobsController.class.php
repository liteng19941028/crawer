<?php
namespace Home\Controller;
use Think\Controller;
class JobsController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->display();
    }
    //51job
    public function wuyijob()
    {
        $id = I('get.id');
        header("Content-type: text/html; charset=utf-8");
        $htmlsource = file_get_contents("http://jobs.51job.com/s/{$id}.html" );
        $htmlsource = iconv("GB2312//IGNORE", "UTF-8", $htmlsource);
        $regular = array(
            "title" => '/<h1 title="(.*?)">/is',
            "place" => '/<span class="lname">(.*?)<\/span>/is',
            'str_salary' => '/<div class="cn".*?<strong>(.*?)<\/strong>/is',
            'website' => '/<p class="cname">[^<]*?<a href="(.*?)"/is',
            'company' => '/<p class="cname">.*?title="(.*?)">/is',
            "company_type" => '/<p class="msg ltype">(.*?)&nbsp;/is',
            "company_people" => '/<p class="msg ltype">.*?\|&nbsp;&nbsp;(.*?)&nbsp;&nbsp;\|/is',
            "bussiness" => '/<p class="msg ltype">.*?\|.*?\|&nbsp;&nbsp;(.*?)<\/p>/is',
            'experience' => '/<span class="sp4"><em class="i1"><\/em>(.*?)<\/span>/',
            'education' => '/<span class="sp4"><em class="i2"><\/em>(.*?)<\/span>/',
            'people_cnt' => '/<span class="sp4"><em class="i3"><\/em>(.*?)<\/span>/',
            'show_time' => '/<span class="sp4"><em class="i4"><\/em>(.*?)<\/span>/',
            'welfare' => '/<p class="t2">(.*?)<\/p>/is',
            'detail_address' => '/<div class="bmsg inbox">.*?<span class="label">.*?<\/span>(.*?)<\/p>/is'
        );
        $data1 = $data = array();
        foreach($regular as $k=>$val){
            preg_match($val,$htmlsource,$data1[$k]);
            $data[$k] = $data1[$k][1];
        }
        if(!empty($data['title'])) {
            $data['id'] = $id;
            M('all_jobs')->add($data);
        }
        echo json_encode($data);
    }
}