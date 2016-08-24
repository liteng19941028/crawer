<?php
namespace Home\Controller;
use Think\Controller;
class UpdateController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $objPHPExcel = new \Org\PHPExcel\ExcelToArray();
        $data = $objPHPExcel->read('E:\Users\soarlee\Desktop\顺泰房产网\装修交流.xlsx','xls');
        $res = array();
        foreach($data as $k=>$val){
            if($k>1){
                $val[1] = preg_replace('/<div class="txtmsg">/','',$val[1]);
                $qie = strstr($val[1],'</div>');
                $val[1] = substr($val[1],0,strlen($val[1])-strlen($qie));
                $res[] = $val;
            }
        }

        $objPHPExcel->push($res);
        echo "完成";die;
    }
}