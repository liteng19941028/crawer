<?php
namespace Home\Controller;
use Think\Controller;
class SetExcelController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data = scandir('E:\Users\soarlee\Desktop\Q12\新建文件夹\统计');
        foreach($data as $val){
            if($val != '.'&&$val!='..'){
                $this->set($val);
            }
        }
    }

    public function set($val)
    {
        $jiejin = 10;
        $shiyebu = array(4.48, 4.17 , 4.07 ,3.74 ,	4.16 ,	4.15 ,	3.97 ,	4.33 ,	4.30 ,	4.24 ,	4.00 ,	4.31 );
        $fengongsi = \Org\PHPExcel\ExcelToArray::read('E:\Users\soarlee\Desktop\Q12\各城市公司平均分.xlsx','xlsx');
        $data = \Org\PHPExcel\ExcelToArray::read('E:\Users\soarlee\Desktop\Q12\新建文件夹\统计\\'.$val,'xlsx');
        unset($data[1]);
        foreach($fengongsi as $v){
            if($v[0] == $data[2][0]){
                $fengongsi = $v;
            }
        }
        $objPHPExcel = new \PHPExcel();
        foreach($data as $k=>$val){
            if(empty($val[0])){
                continue;
            }
            if($k >= 2){
                $objPHPExcel->createSheet();
            }
            $row = array();
            foreach($val as $k2=>$v){
                if(is_numeric($v)){
                    $v = round($v,2);
                }
                $row[] = mb_convert_encoding($v,"GBK","UTF-8");
            }
            $fileName = $row[0]."Q12问卷调查结果汇总.xlsx";
            $title = $row[0].' '.$row[1].' '.$row[2].'Q12团队成长报告';

            //$sheetName = mb_convert_encoding($row[0].'-'.$row[1],"UTF-8","GBK");

            $objWorksheet = $objPHPExcel->setActiveSheetIndex($k-2);



            $objWorksheet
                ->getStyle('C1')->getFont()->setSize(30);
            $objWorksheet
                ->getStyle('A5')->getFont()->setSize(15);
            $objWorksheet
                ->getStyle('A6')->getFont()->setSize(15);

            foreach(array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','H','I','J','K','L','M','N','O','P') AS $val){
                for($i=1;$i<=21;$i++){
                    if(!in_array($val.$i,array('A5','A6','A41','A42','B43','B44'))){
                        $objWorksheet->getStyle($val.$i)->getFont()
                            ->setName('Verdana')
                            ->setSize(12);
                        $objWorksheet
                            ->getStyle($val.$i)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objWorksheet
                            ->getStyle($val.$i)->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    }
                }
            }

            $objWorksheet
                ->mergeCells('C1:M4')
                ->mergeCells('B7:O7')
                ->mergeCells('O9:O11')
                ->mergeCells('O13:O16')
                ->mergeCells('O18:O21')
                ->mergeCells('B12:O12')
                ->mergeCells('B17:O17')

                ->mergeCells('C10:D10')
                ->mergeCells('E10:F10')
                ->mergeCells('G10:H10')
                ->mergeCells('I10:J10')
                ->mergeCells('K10:L10')
                ->mergeCells('M10:N10')
                ->mergeCells('C11:D11')
                ->mergeCells('E11:H11')
                ->mergeCells('I11:L11')
                ->mergeCells('M11:N11')

                ->mergeCells('C15:D15')
                ->mergeCells('E15:F15')
                ->mergeCells('G15:H15')
                ->mergeCells('I15:J15')
                ->mergeCells('K15:L15')
                ->mergeCells('M15:N15')
                ->mergeCells('C16:D16')
                ->mergeCells('E16:H16')
                ->mergeCells('I16:L16')
                ->mergeCells('M16:N16')

                ->mergeCells('C20:D20')
                ->mergeCells('E20:F20')
                ->mergeCells('G20:H20')
                ->mergeCells('I20:J20')
                ->mergeCells('K20:L20')
                ->mergeCells('M20:N20')
                ->mergeCells('C21:D21')
                ->mergeCells('E21:H21')
                ->mergeCells('I21:L21')
                ->mergeCells('M21:N21')

                ->mergeCells('A8:A21');


            //表格
            $objWorksheet
                ->setCellValue('C1', mb_convert_encoding($title,"UTF-8","GBK"))
                ->setCellValue('K58', mb_convert_encoding("FDD 二手房事业部人力资源部","UTF-8","GBK"))
                ->setCellValue('A5', mb_convert_encoding("◆参加人数：".$row[15].'人',"UTF-8","GBK"))
                ->setCellValue('A6', mb_convert_encoding("◆最后得分：".intval($row[17]/60*100).'分',"UTF-8","GBK"))
                ->setCellValue('A7', mb_convert_encoding("区分","UTF-8","GBK"))
                ->setCellValue('A8', mb_convert_encoding("分数结果","UTF-8","GBK"))


                ->setCellValue('B7', mb_convert_encoding("部门平均分","UTF-8","GBK"))            //部门平均分
                ->setCellValue('C8', mb_convert_encoding("Q1","UTF-8","GBK"))
                ->setCellValue('D8', mb_convert_encoding("Q2","UTF-8","GBK"))
                ->setCellValue('E8', mb_convert_encoding("Q3","UTF-8","GBK"))
                ->setCellValue('F8', mb_convert_encoding("Q4","UTF-8","GBK"))
                ->setCellValue('G8', mb_convert_encoding("Q5","UTF-8","GBK"))
                ->setCellValue('H8', mb_convert_encoding("Q6","UTF-8","GBK"))
                ->setCellValue('I8', mb_convert_encoding("Q7","UTF-8","GBK"))
                ->setCellValue('J8', mb_convert_encoding("Q8","UTF-8","GBK"))
                ->setCellValue('K8', mb_convert_encoding("Q9","UTF-8","GBK"))
                ->setCellValue('L8', mb_convert_encoding("Q10","UTF-8","GBK"))
                ->setCellValue('M8', mb_convert_encoding("Q11","UTF-8","GBK"))
                ->setCellValue('N8', mb_convert_encoding("Q12","UTF-8","GBK"))
                ->setCellValue('O8', mb_convert_encoding("总分比例","UTF-8","GBK"))

                ->setCellValue('B9', mb_convert_encoding("单项","UTF-8","GBK"))
                ->setCellValue('C9', mb_convert_encoding($row[3],"UTF-8","GBK"))
                ->setCellValue('D9', mb_convert_encoding($row[4],"UTF-8","GBK"))
                ->setCellValue('E9', mb_convert_encoding($row[5],"UTF-8","GBK"))
                ->setCellValue('F9', mb_convert_encoding($row[6],"UTF-8","GBK"))
                ->setCellValue('G9', mb_convert_encoding($row[7],"UTF-8","GBK"))
                ->setCellValue('H9', mb_convert_encoding($row[8],"UTF-8","GBK"))
                ->setCellValue('I9', mb_convert_encoding($row[9],"UTF-8","GBK"))
                ->setCellValue('J9', mb_convert_encoding($row[10],"UTF-8","GBK"))
                ->setCellValue('K9', mb_convert_encoding($row[11],"UTF-8","GBK"))
                ->setCellValue('L9', mb_convert_encoding($row[12],"UTF-8","GBK"))
                ->setCellValue('M9', mb_convert_encoding($row[13],"UTF-8","GBK"))
                ->setCellValue('N9', mb_convert_encoding($row[14],"UTF-8","GBK"))
                ->setCellValue('O9', mb_convert_encoding(intval($row[17]/60*100).'%',"UTF-8","GBK"))

                ->setCellValue('B10', mb_convert_encoding("属性","UTF-8","GBK"))
                ->setCellValue('C10', mb_convert_encoding("=AVERAGE(C9:D9)","UTF-8","GBK"))
                ->setCellValue('E10', mb_convert_encoding("=AVERAGE(E9:F9)","UTF-8","GBK"))
                ->setCellValue('G10', mb_convert_encoding("=AVERAGE(G9:H9)","UTF-8","GBK"))
                ->setCellValue('I10', mb_convert_encoding("=AVERAGE(I9:J9)","UTF-8","GBK"))
                ->setCellValue('K10', mb_convert_encoding("=AVERAGE(K9:L9)","UTF-8","GBK"))
                ->setCellValue('M10', mb_convert_encoding("=AVERAGE(M9:N9)","UTF-8","GBK"))

                ->setCellValue('B11', mb_convert_encoding("阶层","UTF-8","GBK"))
                ->setCellValue('C11', mb_convert_encoding("=C10","UTF-8","GBK"))
                ->setCellValue('E11', mb_convert_encoding("=AVERAGE(E10:H10)","UTF-8","GBK"))
                ->setCellValue('I11', mb_convert_encoding("=AVERAGE(I10:L10)","UTF-8","GBK"))
                ->setCellValue('M11', mb_convert_encoding("=M10","UTF-8","GBK"))


                ->setCellValue('B12', mb_convert_encoding($row[0]."平均分","UTF-8","GBK"))            //城市分公司平均分
                ->setCellValue('C13', mb_convert_encoding("第一题","UTF-8","GBK"))
                ->setCellValue('D13', mb_convert_encoding("第二题","UTF-8","GBK"))
                ->setCellValue('E13', mb_convert_encoding("第三题","UTF-8","GBK"))
                ->setCellValue('F13', mb_convert_encoding("第四题","UTF-8","GBK"))
                ->setCellValue('G13', mb_convert_encoding("第五题","UTF-8","GBK"))
                ->setCellValue('H13', mb_convert_encoding("第六题","UTF-8","GBK"))
                ->setCellValue('I13', mb_convert_encoding("第七题","UTF-8","GBK"))
                ->setCellValue('J13', mb_convert_encoding("第八题","UTF-8","GBK"))
                ->setCellValue('K13', mb_convert_encoding("第九题","UTF-8","GBK"))
                ->setCellValue('L13', mb_convert_encoding("第十题","UTF-8","GBK"))
                ->setCellValue('M13', mb_convert_encoding("第十一题","UTF-8","GBK"))
                ->setCellValue('N13', mb_convert_encoding("第十二题","UTF-8","GBK"))

                ->setCellValue('B14', mb_convert_encoding("单项","UTF-8","GBK"))
                ->setCellValue('C14', mb_convert_encoding($fengongsi[3],"UTF-8","GBK"))
                ->setCellValue('D14', mb_convert_encoding($fengongsi[4],"UTF-8","GBK"))
                ->setCellValue('E14', mb_convert_encoding($fengongsi[5],"UTF-8","GBK"))
                ->setCellValue('F14', mb_convert_encoding($fengongsi[6],"UTF-8","GBK"))
                ->setCellValue('G14', mb_convert_encoding($fengongsi[7],"UTF-8","GBK"))
                ->setCellValue('H14', mb_convert_encoding($fengongsi[8],"UTF-8","GBK"))
                ->setCellValue('I14', mb_convert_encoding($fengongsi[9],"UTF-8","GBK"))
                ->setCellValue('J14', mb_convert_encoding($fengongsi[10],"UTF-8","GBK"))
                ->setCellValue('K14', mb_convert_encoding($fengongsi[11],"UTF-8","GBK"))
                ->setCellValue('L14', mb_convert_encoding($fengongsi[12],"UTF-8","GBK"))
                ->setCellValue('M14', mb_convert_encoding($fengongsi[13],"UTF-8","GBK"))
                ->setCellValue('N14', mb_convert_encoding($fengongsi[14],"UTF-8","GBK"))
                ->setCellValue('O13', mb_convert_encoding(intval($fengongsi[15]/60*100).'%',"UTF-8","GBK"))

                ->setCellValue('B15', mb_convert_encoding("属性","UTF-8","GBK"))
                ->setCellValue('C15', mb_convert_encoding("=AVERAGE(C14:D14)","UTF-8","GBK"))
                ->setCellValue('E15', mb_convert_encoding("=AVERAGE(E14:F14)","UTF-8","GBK"))
                ->setCellValue('G15', mb_convert_encoding("=AVERAGE(G14:H14)","UTF-8","GBK"))
                ->setCellValue('I15', mb_convert_encoding("=AVERAGE(I14:J14)","UTF-8","GBK"))
                ->setCellValue('K15', mb_convert_encoding("=AVERAGE(K14:L14)","UTF-8","GBK"))
                ->setCellValue('M15', mb_convert_encoding("=AVERAGE(M14:N14)","UTF-8","GBK"))

                ->setCellValue('B16', mb_convert_encoding("阶层","UTF-8","GBK"))
                ->setCellValue('C16', mb_convert_encoding("=C15","UTF-8","GBK"))
                ->setCellValue('E16', mb_convert_encoding("=AVERAGE(E15:H15)","UTF-8","GBK"))
                ->setCellValue('I16', mb_convert_encoding("=AVERAGE(I15:L15)","UTF-8","GBK"))
                ->setCellValue('M16', mb_convert_encoding("=M15","UTF-8","GBK"))


                ->setCellValue('B17', mb_convert_encoding("事业部平均分","UTF-8","GBK"))        //事业部平均分
                ->setCellValue('A18', mb_convert_encoding("分数结果","UTF-8","GBK"))
                ->setCellValue('C18', mb_convert_encoding("Q1","UTF-8","GBK"))
                ->setCellValue('D18', mb_convert_encoding("Q2","UTF-8","GBK"))
                ->setCellValue('E18', mb_convert_encoding("Q3","UTF-8","GBK"))
                ->setCellValue('F18', mb_convert_encoding("Q4","UTF-8","GBK"))
                ->setCellValue('G18', mb_convert_encoding("Q5","UTF-8","GBK"))
                ->setCellValue('H18', mb_convert_encoding("Q6","UTF-8","GBK"))
                ->setCellValue('I18', mb_convert_encoding("Q7","UTF-8","GBK"))
                ->setCellValue('J18', mb_convert_encoding("Q8","UTF-8","GBK"))
                ->setCellValue('K18', mb_convert_encoding("Q9","UTF-8","GBK"))
                ->setCellValue('L18', mb_convert_encoding("Q10","UTF-8","GBK"))
                ->setCellValue('M18', mb_convert_encoding("Q11","UTF-8","GBK"))
                ->setCellValue('N18', mb_convert_encoding("Q12","UTF-8","GBK"))
                ->setCellValue('O18', mb_convert_encoding(intval(array_sum($shiyebu)/60*100).'%',"UTF-8","GBK"))

                ->setCellValue('B19', mb_convert_encoding("单项","UTF-8","GBK"))
                ->setCellValue('C19', mb_convert_encoding($shiyebu[0],"UTF-8","GBK"))
                ->setCellValue('D19', mb_convert_encoding($shiyebu[1],"UTF-8","GBK"))
                ->setCellValue('E19', mb_convert_encoding($shiyebu[2],"UTF-8","GBK"))
                ->setCellValue('F19', mb_convert_encoding($shiyebu[3],"UTF-8","GBK"))
                ->setCellValue('G19', mb_convert_encoding($shiyebu[4],"UTF-8","GBK"))
                ->setCellValue('H19', mb_convert_encoding($shiyebu[5],"UTF-8","GBK"))
                ->setCellValue('I19', mb_convert_encoding($shiyebu[6],"UTF-8","GBK"))
                ->setCellValue('J19', mb_convert_encoding($shiyebu[7],"UTF-8","GBK"))
                ->setCellValue('K19', mb_convert_encoding($shiyebu[8],"UTF-8","GBK"))
                ->setCellValue('L19', mb_convert_encoding($shiyebu[9],"UTF-8","GBK"))
                ->setCellValue('M19', mb_convert_encoding($shiyebu[10],"UTF-8","GBK"))
                ->setCellValue('N19', mb_convert_encoding($shiyebu[11],"UTF-8","GBK"))

                ->setCellValue('B20', mb_convert_encoding("属性","UTF-8","GBK"))
                ->setCellValue('C20', mb_convert_encoding("=AVERAGE(C19:D19)","UTF-8","GBK"))
                ->setCellValue('E20', mb_convert_encoding("=AVERAGE(E19:F19)","UTF-8","GBK"))
                ->setCellValue('G20', mb_convert_encoding("=AVERAGE(G19:H19)","UTF-8","GBK"))
                ->setCellValue('I20', mb_convert_encoding("=AVERAGE(I19:J19)","UTF-8","GBK"))
                ->setCellValue('K20', mb_convert_encoding("=AVERAGE(K19:L19)","UTF-8","GBK"))
                ->setCellValue('M20', mb_convert_encoding("=AVERAGE(M19:N19)","UTF-8","GBK"))

                ->setCellValue('B21', mb_convert_encoding("阶层","UTF-8","GBK"))
                ->setCellValue('C21', mb_convert_encoding("=C20","UTF-8","GBK"))
                ->setCellValue('E21', mb_convert_encoding("=AVERAGE(E20:H20)","UTF-8","GBK"))
                ->setCellValue('I21', mb_convert_encoding("=AVERAGE(I20:L20)","UTF-8","GBK"))
                ->setCellValue('M21', mb_convert_encoding("=M20","UTF-8","GBK"))
                ->setCellValue('A23', mb_convert_encoding("◆ 数据对比","UTF-8","GBK"));


            //图表
            //$this->drawChart($objWorksheet,'sheet',mb_convert_encoding("题目数据分析图","UTF-8","GBK"),\PHPExcel_Chart_DataSeries::TYPE_SCATTERCHART,1);
            //$this->drawChart($objWorksheet,'sheet',mb_convert_encoding("属性数据对比图","UTF-8","GBK"),\PHPExcel_Chart_DataSeries::TYPE_BARCHART,2);
            //$this->drawChart($objWorksheet,'sheet',mb_convert_encoding("阶层数据分析图","UTF-8","GBK"),\PHPExcel_Chart_DataSeries::TYPE_BARCHART,3);
            //结果分析
            $fenxi = array(
                '根据数据显示，贵部门各项指标得分与三级部门整体分数接近',
                '根据数据显示，贵部门各项指标得分高于三级部门整体分数',
                '根据数据显示，贵部门各项指标得分低于三级部门整体分数接近',
            );
            if(abs($row[17] - array_sum($fengongsi)) < $jiejin ){//接近
                $zhfenxi = $fenxi[0];
            }elseif($row[17] - array_sum($fengongsi) >= $jiejin){//高于
                $zhfenxi = $fenxi[1];
            }else{
                $zhfenxi = $fenxi[2];
            }

            $fenxi1 = array(
                '在盖勒普Q12阶层分布中，贵部门在第一阶层（我的需求）得分最低，说明我们应当更加关注对员工基本的工具和信息的确保',
                '在盖勒普Q12阶层分布中，贵部门在第二阶层(我的奉献)得分最低，说明我们应当更加着重于对员工的支持和帮助',
                '在盖勒普Q12阶层分布中，贵部门在第三阶层(我的归属)得分最低，说明我们应该重点关注员工归属感和团队凝聚力的强化',
                '在盖勒普Q12阶层分布中，贵部门在第四阶层（共同成长）得分最低，说明我们应该重点关注团队学习和培训氛围，尽可能提供更多员工的成长机会'
            );
            $jieceng = array(
                ($row[3]+$row[4])/2,
                ($row[5]+$row[6]+$row[7]+$row[8])/4,
                ($row[9]+$row[10]+$row[11]+$row[12])/4,
                ($row[13]+$row[14])/2
            );
            $key = array_search(min($jieceng),$jieceng);
            $zhfenxi1 = $fenxi1[$key];

            $tmfenxi = array(
                array('Q1' , '表现出管理者和员工通过良好的沟通，在业务职能、绩效目标方面沟通明确，员工工作有清晰的方向和目标'),
                array('Q2' , '表现出管理者为员工提供了充分的资源和信息，正确解读员工需求并提供支持，提升工作效率'),
                array('Q3' , '表现出管理者具体挖掘员工优势的能力，对员工技能、知识、才干有正确划分和引导，达到最佳人岗匹配，提升工作效率'),
                array('Q4' , '表现出管理者对员工及时激励、正向强化，不吝惜赞美语言，能正确把握尺度并引导员工，使员工获得成就感'),
                array('Q5' , '表现出管理者着重建立“情感账户”，给予员工温暖和关怀，关注员工工作/生活'),
                array('Q6' , '表现出管理者给员工举好“镜子”，帮助员工认清自身现况及规划职业发展方向，在发展过程中不断鼓励员工成长'),
                array('Q7' , '表现出管理者能很好的倾听员工心声，集思广益，使员工能感受到自身价值和得到尊重，使员工获得成就感'),
                array('Q8' , '表现出管理者能及时将公司战略/目标传达至员工，并在制定目标时与之建立起联系，员工责任感与使命感提升'),
                array('Q9' , '表现出管理者对流程分工合理、团队凝聚力高、协作能力强，每个人都能高效负责的完成工作'),
                array('Q10' , '表现出管理者重视创造团队内部信任、友谊的氛围，使员工有强烈的归属感，能更好的应对工作上的困难和压力'),
                array('Q11' , '表现出管理者定期反馈，让员工看到自己的成长和进步，使员工收到鼓舞提升自信心'),
                array('Q12' , '表现出管理者为员工提供了挑战性工作、辅导、反馈及各种学习、发展的机会，使员工学习成长适应各种未来未知挑战')
            );
            $temp = array($row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
            $maxi = array_search(max($temp),$temp);
            $zhtmfenxi[0] = $tmfenxi[$maxi];
            unset($temp[$maxi]);
            $maxi = array_search(max($temp),$temp);
            $zhtmfenxi[1] = $tmfenxi[$maxi];

            $tmfenxi1 = array(
                array('Q1' , '表现出部门内部业务职能设定较模糊，同时绩效目标的设定需要优化，在内部沟通上也需要加强'),
                array('Q2' , '表现出管理者没有为员工提供相应的工作资源和信息，或者没有充分了解员工需求，导致员工工作效率降低'),
                array('Q3' , '表现出管理者对员工现况缺乏了解，无法为员工匹配最优工作分工，工作效率降低'),
                array('Q4' , '表现出管理者对员工激励赞扬不足，员工缺乏成就感，有可能会导致团队士气降低'),
                array('Q5' , '表现出管理者没有为员工给予足够的关怀，忽视团队凝聚力建设，使员工缺乏归属感'),
                array('Q6' , '表现出管理者没有充分了解员工自身状况，未能帮助员工规划自身职业发展方向，使员工失去前进的动力'),
                array('Q7' , '表现出管理者缺乏倾听意识，对员工的意见没有引起足够的重视，或者没有使员工更好的感受到自身价值'),
                array('Q8' , '表现出管理者的团队缺乏信息传达渠道，员工不能及时了解公司战略/目标，使员工很难制定与公司一致的目标导向'),
                array('Q9' , '表现出管理者对员工流程分工不太合理，团队凝聚力和协作能力不足，员工工作效能不高'),
                array('Q10' , '表现出管理者对创造团队信任、友谊氛围重视程度不足，员工归属感欠缺，应对困难和压力能力偏弱'),
                array('Q11' , '表现出管理者定期准确反馈的习惯不，员工无法得到对自己进步的肯定，降低员工自信心，甚至怀疑自己是否胜任工作'),
                array('Q12' , '表现出管理者没有充分为员工提供挑战、辅导、反馈以及各种学习发展机会，使员工可能在未来不适应更具挑战性工作')
            );
            $temp = array($row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
            $maxi = array_search(min($temp),$temp);
            $zhtmfenxi1[0] = $tmfenxi1[$maxi];
            unset($temp[$maxi]);
            $maxi = array_search(min($temp),$temp);
            $zhtmfenxi1[1] = $tmfenxi1[$maxi];

            $advice = array(
                array('Q1' , array(
                    '— 对业务模块职能重新梳理：业务职能设定应更加具体、可量化并且可实现',
                    '— 绩效目标标准再核定：制定适当的高标准提升员工积极性',
                    '— 沟通渠道强化：多听取员工心声，及时掌握员工动态'
                )),
                array('Q2' , array(
                    '-对现有资源及设备进行传播共享：正确解读员工需求、指引员工能做“有米之炊”',
                    '-资源整合：优化资源配置、由信息共享而实现业务模块全程的可见性'
                )),
                array('Q3' , array(
                    '— 人岗匹配度分析：分析匹配度并重新优化岗位分配，提升效率',
                    '— 员工积极性提升：适当授权，鼓励员工自发创新，通过持续激励引导员工积极性上升'
                )),
                array('Q4' , array(
                    '— 积极肯定：对工作出色的员工及时表扬，同时强化正向引导，引导团队其他员工成长',
                    '— 适当批评：注意批评的场合(私下沟通为主)和方式，解决问题同时充分考虑对方感受'
                )),
                array('Q5' , array(
                    '— “情感账户”建立：管理者平时应多与员工沟通，了解工作生活中的困难并主动提供帮助，建立相互信任感',
                    '— 团队凝聚力提升：通过活动、沟通会等方式建立团队凝聚力，并引导员工帮助困难同事，形成团结互助的团队氛围'
                )),
                array('Q6' , array(
                    '— 职业发展方向规划：通过观察和分析帮助员工认清自我，从而明确职业发展方向',
                    '— 鼓励员工：在员工发展过程中不断鼓励，帮助员工达成或超额完成目标'
                )),
                array('Q7' , array(
                    '— 学会倾听：管理者应善于听取员工意见，并在员工提出建议时应给予鼓励和重视',
                    '— 沟通氛围建立：团队中提倡员工敞开心扉，集思广益，提升员工使命感和成就感'
                )),
                array('Q8' , array(
                    '— 信息传达渠道建立：应建立多渠道的信息传达方式并有效维护，确保信息有效上传下达',
                    '-培养团队使命感氛围：建立正确目标，高效管理\执行公司战略性方向'
                )),
                array('Q9' , array(
                    '— 流程分工再梳理：充分了解团队现况，将流程分工再梳理优化，提升工作效率',
                    '— 团队协作能力提升：通过加强部门内横向合作和沟通，提升团队协作效能，从而提升整体工作效率'
                )),
                array('Q10' , array(
                    '— 员工交流增强:创造员工交流机会，提升部门内部横向协作能力，增强员工归属感',
                    '— 正能量传递：提倡员工间相互帮助，共享价值观(注：非组织关系的应用需谨慎，防止员工抱团影响执行力)'
                )),
                array('Q11' , array(
                    '—建立了结构性反馈机制：包括明确的目标定义和成绩等级，以及定期举行团队回馈汇谈，以掌握团队成员迈向目标的个人情况'
                )),
                array('Q12' , array(
                    '— 挑战性工作赋予：管理者应根据员工实际业务能力布置部分超出他能力的挑战性工作并进行过程辅导，提升员工能力',
                    '— 学习机会争取：为员工争取尽可能多的学习、培训机会，扩展员工视野，提升能力'
                ))
            );
            $temp = array($row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
            $maxi = array_search(min($temp),$temp);
            $zhadvice[0] = $advice[$maxi];
            unset($temp[$maxi]);
            $maxi = array_search(min($temp),$temp);
            $zhadvice[1] = $advice[$maxi];

            $objWorksheet
                ->setCellValue('A41',mb_convert_encoding("◆ 结果分析：","UTF-8","GBK"))
                ->setCellValue('A42',mb_convert_encoding("◇ 综合分析：","UTF-8","GBK"))
                ->setCellValue('B43',mb_convert_encoding($zhfenxi,"UTF-8","GBK"))
                ->setCellValue('B44',mb_convert_encoding($zhfenxi1,"UTF-8","GBK"))
                ->setCellValue('A45',mb_convert_encoding("◇ 题目分析：","UTF-8","GBK"))
                ->setCellValue('B46',mb_convert_encoding("— 得分最高:","UTF-8","GBK"))
                ->setCellValue('B47',mb_convert_encoding($zhtmfenxi[0][0].':',"UTF-8","GBK"))
                ->setCellValue('C47',mb_convert_encoding($zhtmfenxi[0][1],"UTF-8","GBK"))
                ->setCellValue('B48',mb_convert_encoding($zhtmfenxi[1][0].':',"UTF-8","GBK"))
                ->setCellValue('C48',mb_convert_encoding($zhtmfenxi[1][1],"UTF-8","GBK"))
                ->setCellValue('B49',mb_convert_encoding("— 得分最低:","UTF-8","GBK"))
                ->setCellValue('B50',mb_convert_encoding($zhtmfenxi1[0][0].':',"UTF-8","GBK"))
                ->setCellValue('C50',mb_convert_encoding($zhtmfenxi1[0][1],"UTF-8","GBK"))
                ->setCellValue('B51',mb_convert_encoding($zhtmfenxi1[1][0].':',"UTF-8","GBK"))
                ->setCellValue('C51',mb_convert_encoding($zhtmfenxi1[1][1],"UTF-8","GBK"))
                ->setCellValue('A52',mb_convert_encoding('◇ 改善建议：',"UTF-8","GBK"))
                ->setCellValue('B53',mb_convert_encoding($zhadvice[0][0].':',"UTF-8","GBK"));
            $i = 53;
            foreach($zhadvice[0][1] as $k1=>$v1){
                $objWorksheet->setCellValue('C'.($i+=$k1),mb_convert_encoding($v1,"UTF-8","GBK"));
            };
            $objWorksheet
                ->setCellValue('B'.(++$i),mb_convert_encoding($zhadvice[1][0].':',"UTF-8","GBK"));
            foreach($zhadvice[1][1] as $k1=>$v1){
                $objWorksheet->setCellValue('C'.($i+=$k1),mb_convert_encoding($v1,"UTF-8","GBK"));
            };

            $objWorksheet
            //    ->setTitle(mb_convert_encoding($row[0].'-'.$row[1],"UTF-8","GBK"));
            ->setTitle('sheet');
        }
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->setIncludeCharts(TRUE);
        $scan = scandir('./Public/upfile/excel/data/');
        if(in_array($fileName,$scan)){
            $fileName = explode('.',$fileName)[0].'(1).xlsx';
            if(in_array($fileName,$scan)){
                $fileName = explode('.',$fileName)[0].'(2).xlsx';
            }
        }
        $objWriter->save("./Public/upfile/excel/data/".$fileName);
    }

    public function drawChart(&$objWorksheet,$sheetName = 'sheet',$chartName,$chartType,$type = 1){
// 设置每一个data series 数据系列的名称
        $dataseriesLabels = array(
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$B$7', NULL, 1),	//	2010
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$B$12', NULL, 1),	//	2011
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$B$17', NULL, 1),	//	2012
        );
//	设置X轴Tick数据(X轴每一个刻度值)
        $xAxisTickValues = array(
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$C$8:$N$8', NULL, 12),	//	Q1 to Q4
        );
//	设置作图区域数据
        if($type==1){
            $dataSeriesValues = array(
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$9:$N$9', NULL, 12),
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$14:$N$14', NULL, 12),
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$19:$N$19', NULL, 12),
            );
        }elseif($type==2){
            $dataSeriesValues = array(
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$10:$N$10', NULL, 6),
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$15:$N$15', NULL, 6),
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$20:$N$20', NULL, 6),
            );
        }else{
            $dataSeriesValues = array(
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$11:$N$11', NULL, 4),
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$16:$N$16', NULL, 4),
                new \PHPExcel_Chart_DataSeriesValues('Number', $sheetName.'!$C$21:$N$21', NULL, 4),
            );
        }


//	构建数据系列 dataseries
        $series = new \PHPExcel_Chart_DataSeries(
            $chartType,		// plotType
            \PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
            range(0, count($dataSeriesValues)-1),			// plotOrder
            $dataseriesLabels,								// plotLabel
            $xAxisTickValues,								// plotCategory
            $dataSeriesValues								// plotValues
        );

        $series->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COLUMN);
// 给数据系列分配一个做图区域
        $plotarea = new \PHPExcel_Chart_PlotArea(NULL, array($series));
// Set the chart legend
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

// 设置图形标题
        $title = new \PHPExcel_Chart_Title($chartName);


// 创建图形
        $chart = new \PHPExcel_Chart(
            'chart1',		// name
            $title,			// title
            $legend,		// legend
            $plotarea,		// plotArea
            true,			// plotVisibleOnly
            0,				// displayBlanksAs
            NULL			// xAxisLabel
        );

// 设置图形绘制区域
        if($type==1){
            $chart->setTopLeftPosition('A24');
            $chart->setBottomRightPosition('E39');
        }elseif($type==2){
            $chart->setTopLeftPosition('F24');
            $chart->setBottomRightPosition('K39');
        }else{
            $chart->setTopLeftPosition('L24');
            $chart->setBottomRightPosition('P39');
        }

// 将图形添加到当前工作表
        $objWorksheet->addChart($chart);
    }
}