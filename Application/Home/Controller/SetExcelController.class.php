<?php
namespace Home\Controller;
use Think\Controller;
class SetExcelController extends Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $data = scandir('E:\Users\soarlee\Desktop\Q12\�½��ļ���\ͳ��');
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
        $fengongsi = \Org\PHPExcel\ExcelToArray::read('E:\Users\soarlee\Desktop\Q12\�����й�˾ƽ����.xlsx','xlsx');
        $data = \Org\PHPExcel\ExcelToArray::read('E:\Users\soarlee\Desktop\Q12\�½��ļ���\ͳ��\\'.$val,'xlsx');
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
            $fileName = $row[0]."Q12�ʾ����������.xlsx";
            $title = $row[0].' '.$row[1].' '.$row[2].'Q12�Ŷӳɳ�����';

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


            //���
            $objWorksheet
                ->setCellValue('C1', mb_convert_encoding($title,"UTF-8","GBK"))
                ->setCellValue('K58', mb_convert_encoding("FDD ���ַ���ҵ��������Դ��","UTF-8","GBK"))
                ->setCellValue('A5', mb_convert_encoding("���μ�������".$row[15].'��',"UTF-8","GBK"))
                ->setCellValue('A6', mb_convert_encoding("�����÷֣�".intval($row[17]/60*100).'��',"UTF-8","GBK"))
                ->setCellValue('A7', mb_convert_encoding("����","UTF-8","GBK"))
                ->setCellValue('A8', mb_convert_encoding("�������","UTF-8","GBK"))


                ->setCellValue('B7', mb_convert_encoding("����ƽ����","UTF-8","GBK"))            //����ƽ����
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
                ->setCellValue('O8', mb_convert_encoding("�ֱܷ���","UTF-8","GBK"))

                ->setCellValue('B9', mb_convert_encoding("����","UTF-8","GBK"))
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

                ->setCellValue('B10', mb_convert_encoding("����","UTF-8","GBK"))
                ->setCellValue('C10', mb_convert_encoding("=AVERAGE(C9:D9)","UTF-8","GBK"))
                ->setCellValue('E10', mb_convert_encoding("=AVERAGE(E9:F9)","UTF-8","GBK"))
                ->setCellValue('G10', mb_convert_encoding("=AVERAGE(G9:H9)","UTF-8","GBK"))
                ->setCellValue('I10', mb_convert_encoding("=AVERAGE(I9:J9)","UTF-8","GBK"))
                ->setCellValue('K10', mb_convert_encoding("=AVERAGE(K9:L9)","UTF-8","GBK"))
                ->setCellValue('M10', mb_convert_encoding("=AVERAGE(M9:N9)","UTF-8","GBK"))

                ->setCellValue('B11', mb_convert_encoding("�ײ�","UTF-8","GBK"))
                ->setCellValue('C11', mb_convert_encoding("=C10","UTF-8","GBK"))
                ->setCellValue('E11', mb_convert_encoding("=AVERAGE(E10:H10)","UTF-8","GBK"))
                ->setCellValue('I11', mb_convert_encoding("=AVERAGE(I10:L10)","UTF-8","GBK"))
                ->setCellValue('M11', mb_convert_encoding("=M10","UTF-8","GBK"))


                ->setCellValue('B12', mb_convert_encoding($row[0]."ƽ����","UTF-8","GBK"))            //���зֹ�˾ƽ����
                ->setCellValue('C13', mb_convert_encoding("��һ��","UTF-8","GBK"))
                ->setCellValue('D13', mb_convert_encoding("�ڶ���","UTF-8","GBK"))
                ->setCellValue('E13', mb_convert_encoding("������","UTF-8","GBK"))
                ->setCellValue('F13', mb_convert_encoding("������","UTF-8","GBK"))
                ->setCellValue('G13', mb_convert_encoding("������","UTF-8","GBK"))
                ->setCellValue('H13', mb_convert_encoding("������","UTF-8","GBK"))
                ->setCellValue('I13', mb_convert_encoding("������","UTF-8","GBK"))
                ->setCellValue('J13', mb_convert_encoding("�ڰ���","UTF-8","GBK"))
                ->setCellValue('K13', mb_convert_encoding("�ھ���","UTF-8","GBK"))
                ->setCellValue('L13', mb_convert_encoding("��ʮ��","UTF-8","GBK"))
                ->setCellValue('M13', mb_convert_encoding("��ʮһ��","UTF-8","GBK"))
                ->setCellValue('N13', mb_convert_encoding("��ʮ����","UTF-8","GBK"))

                ->setCellValue('B14', mb_convert_encoding("����","UTF-8","GBK"))
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

                ->setCellValue('B15', mb_convert_encoding("����","UTF-8","GBK"))
                ->setCellValue('C15', mb_convert_encoding("=AVERAGE(C14:D14)","UTF-8","GBK"))
                ->setCellValue('E15', mb_convert_encoding("=AVERAGE(E14:F14)","UTF-8","GBK"))
                ->setCellValue('G15', mb_convert_encoding("=AVERAGE(G14:H14)","UTF-8","GBK"))
                ->setCellValue('I15', mb_convert_encoding("=AVERAGE(I14:J14)","UTF-8","GBK"))
                ->setCellValue('K15', mb_convert_encoding("=AVERAGE(K14:L14)","UTF-8","GBK"))
                ->setCellValue('M15', mb_convert_encoding("=AVERAGE(M14:N14)","UTF-8","GBK"))

                ->setCellValue('B16', mb_convert_encoding("�ײ�","UTF-8","GBK"))
                ->setCellValue('C16', mb_convert_encoding("=C15","UTF-8","GBK"))
                ->setCellValue('E16', mb_convert_encoding("=AVERAGE(E15:H15)","UTF-8","GBK"))
                ->setCellValue('I16', mb_convert_encoding("=AVERAGE(I15:L15)","UTF-8","GBK"))
                ->setCellValue('M16', mb_convert_encoding("=M15","UTF-8","GBK"))


                ->setCellValue('B17', mb_convert_encoding("��ҵ��ƽ����","UTF-8","GBK"))        //��ҵ��ƽ����
                ->setCellValue('A18', mb_convert_encoding("�������","UTF-8","GBK"))
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

                ->setCellValue('B19', mb_convert_encoding("����","UTF-8","GBK"))
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

                ->setCellValue('B20', mb_convert_encoding("����","UTF-8","GBK"))
                ->setCellValue('C20', mb_convert_encoding("=AVERAGE(C19:D19)","UTF-8","GBK"))
                ->setCellValue('E20', mb_convert_encoding("=AVERAGE(E19:F19)","UTF-8","GBK"))
                ->setCellValue('G20', mb_convert_encoding("=AVERAGE(G19:H19)","UTF-8","GBK"))
                ->setCellValue('I20', mb_convert_encoding("=AVERAGE(I19:J19)","UTF-8","GBK"))
                ->setCellValue('K20', mb_convert_encoding("=AVERAGE(K19:L19)","UTF-8","GBK"))
                ->setCellValue('M20', mb_convert_encoding("=AVERAGE(M19:N19)","UTF-8","GBK"))

                ->setCellValue('B21', mb_convert_encoding("�ײ�","UTF-8","GBK"))
                ->setCellValue('C21', mb_convert_encoding("=C20","UTF-8","GBK"))
                ->setCellValue('E21', mb_convert_encoding("=AVERAGE(E20:H20)","UTF-8","GBK"))
                ->setCellValue('I21', mb_convert_encoding("=AVERAGE(I20:L20)","UTF-8","GBK"))
                ->setCellValue('M21', mb_convert_encoding("=M20","UTF-8","GBK"))
                ->setCellValue('A23', mb_convert_encoding("�� ���ݶԱ�","UTF-8","GBK"));


            //ͼ��
            //$this->drawChart($objWorksheet,'sheet',mb_convert_encoding("��Ŀ���ݷ���ͼ","UTF-8","GBK"),\PHPExcel_Chart_DataSeries::TYPE_SCATTERCHART,1);
            //$this->drawChart($objWorksheet,'sheet',mb_convert_encoding("�������ݶԱ�ͼ","UTF-8","GBK"),\PHPExcel_Chart_DataSeries::TYPE_BARCHART,2);
            //$this->drawChart($objWorksheet,'sheet',mb_convert_encoding("�ײ����ݷ���ͼ","UTF-8","GBK"),\PHPExcel_Chart_DataSeries::TYPE_BARCHART,3);
            //�������
            $fenxi = array(
                '����������ʾ�����Ÿ���ָ��÷�������������������ӽ�',
                '����������ʾ�����Ÿ���ָ��÷ָ������������������',
                '����������ʾ�����Ÿ���ָ��÷ֵ�������������������ӽ�',
            );
            if(abs($row[17] - array_sum($fengongsi)) < $jiejin ){//�ӽ�
                $zhfenxi = $fenxi[0];
            }elseif($row[17] - array_sum($fengongsi) >= $jiejin){//����
                $zhfenxi = $fenxi[1];
            }else{
                $zhfenxi = $fenxi[2];
            }

            $fenxi1 = array(
                '�ڸ�����Q12�ײ�ֲ��У������ڵ�һ�ײ㣨�ҵ����󣩵÷���ͣ�˵������Ӧ�����ӹ�ע��Ա�������Ĺ��ߺ���Ϣ��ȷ��',
                '�ڸ�����Q12�ײ�ֲ��У������ڵڶ��ײ�(�ҵķ���)�÷���ͣ�˵������Ӧ�����������ڶ�Ա����֧�ֺͰ���',
                '�ڸ�����Q12�ײ�ֲ��У������ڵ����ײ�(�ҵĹ���)�÷���ͣ�˵������Ӧ���ص��עԱ�������к��Ŷ���������ǿ��',
                '�ڸ�����Q12�ײ�ֲ��У������ڵ��Ľײ㣨��ͬ�ɳ����÷���ͣ�˵������Ӧ���ص��ע�Ŷ�ѧϰ����ѵ��Χ���������ṩ����Ա���ĳɳ�����'
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
                array('Q1' , '���ֳ������ߺ�Ա��ͨ�����õĹ�ͨ����ҵ��ְ�ܡ���ЧĿ�귽�湵ͨ��ȷ��Ա�������������ķ����Ŀ��'),
                array('Q2' , '���ֳ�������ΪԱ���ṩ�˳�ֵ���Դ����Ϣ����ȷ���Ա�������ṩ֧�֣���������Ч��'),
                array('Q3' , '���ֳ������߾����ھ�Ա�����Ƶ���������Ա�����ܡ�֪ʶ���Ÿ�����ȷ���ֺ��������ﵽ����˸�ƥ�䣬��������Ч��'),
                array('Q4' , '���ֳ������߶�Ա����ʱ����������ǿ��������ϧ�������ԣ�����ȷ���ճ߶Ȳ�����Ա����ʹԱ����óɾ͸�'),
                array('Q5' , '���ֳ����������ؽ���������˻���������Ա����ů�͹ػ�����עԱ������/����'),
                array('Q6' , '���ֳ������߸�Ա���ٺá����ӡ�������Ա�����������ֿ����滮ְҵ��չ�����ڷ�չ�����в��Ϲ���Ա���ɳ�'),
                array('Q7' , '���ֳ��������ܺܺõ�����Ա����������˼���棬ʹԱ���ܸ��ܵ������ֵ�͵õ����أ�ʹԱ����óɾ͸�'),
                array('Q8' , '���ֳ��������ܼ�ʱ����˾ս��/Ŀ�괫����Ա���������ƶ�Ŀ��ʱ��֮��������ϵ��Ա�����θ���ʹ��������'),
                array('Q9' , '���ֳ������߶����̷ֹ������Ŷ��������ߡ�Э������ǿ��ÿ���˶��ܸ�Ч�������ɹ���'),
                array('Q10' , '���ֳ����������Ӵ����Ŷ��ڲ����Ρ�����ķ�Χ��ʹԱ����ǿ�ҵĹ����У��ܸ��õ�Ӧ�Թ����ϵ����Ѻ�ѹ��'),
                array('Q11' , '���ֳ������߶��ڷ�������Ա�������Լ��ĳɳ��ͽ�����ʹԱ���յ���������������'),
                array('Q12' , '���ֳ�������ΪԱ���ṩ����ս�Թ���������������������ѧϰ����չ�Ļ��ᣬʹԱ��ѧϰ�ɳ���Ӧ����δ��δ֪��ս')
            );
            $temp = array($row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
            $maxi = array_search(max($temp),$temp);
            $zhtmfenxi[0] = $tmfenxi[$maxi];
            unset($temp[$maxi]);
            $maxi = array_search(max($temp),$temp);
            $zhtmfenxi[1] = $tmfenxi[$maxi];

            $tmfenxi1 = array(
                array('Q1' , '���ֳ������ڲ�ҵ��ְ���趨��ģ����ͬʱ��ЧĿ����趨��Ҫ�Ż������ڲ���ͨ��Ҳ��Ҫ��ǿ'),
                array('Q2' , '���ֳ�������û��ΪԱ���ṩ��Ӧ�Ĺ�����Դ����Ϣ������û�г���˽�Ա�����󣬵���Ա������Ч�ʽ���'),
                array('Q3' , '���ֳ������߶�Ա���ֿ�ȱ���˽⣬�޷�ΪԱ��ƥ�����Ź����ֹ�������Ч�ʽ���'),
                array('Q4' , '���ֳ������߶�Ա���������ﲻ�㣬Ա��ȱ���ɾ͸У��п��ܻᵼ���Ŷ�ʿ������'),
                array('Q5' , '���ֳ�������û��ΪԱ�������㹻�Ĺػ��������Ŷ����������裬ʹԱ��ȱ��������'),
                array('Q6' , '���ֳ�������û�г���˽�Ա������״����δ�ܰ���Ա���滮����ְҵ��չ����ʹԱ��ʧȥǰ���Ķ���'),
                array('Q7' , '���ֳ�������ȱ��������ʶ����Ա�������û�������㹻�����ӣ�����û��ʹԱ�����õĸ��ܵ������ֵ'),
                array('Q8' , '���ֳ������ߵ��Ŷ�ȱ����Ϣ����������Ա�����ܼ�ʱ�˽⹫˾ս��/Ŀ�꣬ʹԱ�������ƶ��빫˾һ�µ�Ŀ�굼��'),
                array('Q9' , '���ֳ������߶�Ա�����̷ֹ���̫�����Ŷ���������Э���������㣬Ա������Ч�ܲ���'),
                array('Q10' , '���ֳ������߶Դ����Ŷ����Ρ������Χ���ӳ̶Ȳ��㣬Ա��������Ƿȱ��Ӧ�����Ѻ�ѹ������ƫ��'),
                array('Q11' , '���ֳ������߶���׼ȷ������ϰ�߲���Ա���޷��õ����Լ������Ŀ϶�������Ա�������ģ����������Լ��Ƿ�ʤ�ι���'),
                array('Q12' , '���ֳ�������û�г��ΪԱ���ṩ��ս�������������Լ�����ѧϰ��չ���ᣬʹԱ��������δ������Ӧ������ս�Թ���')
            );
            $temp = array($row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
            $maxi = array_search(min($temp),$temp);
            $zhtmfenxi1[0] = $tmfenxi1[$maxi];
            unset($temp[$maxi]);
            $maxi = array_search(min($temp),$temp);
            $zhtmfenxi1[1] = $tmfenxi1[$maxi];

            $advice = array(
                array('Q1' , array(
                    '�� ��ҵ��ģ��ְ����������ҵ��ְ���趨Ӧ���Ӿ��塢���������ҿ�ʵ��',
                    '�� ��ЧĿ���׼�ٺ˶����ƶ��ʵ��ĸ߱�׼����Ա��������',
                    '�� ��ͨ����ǿ��������ȡԱ����������ʱ����Ա����̬'
                )),
                array('Q2' , array(
                    '-��������Դ���豸���д���������ȷ���Ա������ָ��Ա������������֮����',
                    '-��Դ���ϣ��Ż���Դ���á�����Ϣ�����ʵ��ҵ��ģ��ȫ�̵Ŀɼ���'
                )),
                array('Q3' , array(
                    '�� �˸�ƥ��ȷ���������ƥ��Ȳ������Ż���λ���䣬����Ч��',
                    '�� Ա���������������ʵ���Ȩ������Ա���Է����£�ͨ��������������Ա������������'
                )),
                array('Q4' , array(
                    '�� �����϶����Թ�����ɫ��Ա����ʱ���ͬʱǿ�����������������Ŷ�����Ա���ɳ�',
                    '�� �ʵ�������ע�������ĳ���(˽�¹�ͨΪ��)�ͷ�ʽ���������ͬʱ��ֿ��ǶԷ�����'
                )),
                array('Q5' , array(
                    '�� ������˻���������������ƽʱӦ����Ա����ͨ���˽⹤�������е����Ѳ������ṩ�����������໥���θ�',
                    '�� �Ŷ�������������ͨ�������ͨ��ȷ�ʽ�����Ŷ���������������Ա����������ͬ�£��γ��Žụ�����Ŷӷ�Χ'
                )),
                array('Q6' , array(
                    '�� ְҵ��չ����滮��ͨ���۲�ͷ�������Ա���������ң��Ӷ���ȷְҵ��չ����',
                    '�� ����Ա������Ա����չ�����в��Ϲ���������Ա����ɻ򳬶����Ŀ��'
                )),
                array('Q7' , array(
                    '�� ѧ��������������Ӧ������ȡԱ�����������Ա���������ʱӦ�������������',
                    '�� ��ͨ��Χ�������Ŷ����ᳫԱ���������飬��˼���棬����Ա��ʹ���кͳɾ͸�'
                )),
                array('Q8' , array(
                    '�� ��Ϣ��������������Ӧ��������������Ϣ���﷽ʽ����Чά����ȷ����Ϣ��Ч�ϴ��´�',
                    '-�����Ŷ�ʹ���з�Χ��������ȷĿ�꣬��Ч����\ִ�й�˾ս���Է���'
                )),
                array('Q9' , array(
                    '�� ���̷ֹ�����������˽��Ŷ��ֿ��������̷ֹ��������Ż�����������Ч��',
                    '�� �Ŷ�Э������������ͨ����ǿ�����ں�������͹�ͨ�������Ŷ�Э��Ч�ܣ��Ӷ��������幤��Ч��'
                )),
                array('Q10' , array(
                    '�� Ա��������ǿ:����Ա���������ᣬ���������ڲ�����Э����������ǿԱ��������',
                    '�� ���������ݣ��ᳫԱ�����໥�����������ֵ��(ע������֯��ϵ��Ӧ�����������ֹԱ������Ӱ��ִ����)'
                )),
                array('Q11' , array(
                    '�������˽ṹ�Է������ƣ�������ȷ��Ŀ�궨��ͳɼ��ȼ����Լ����ھ����Ŷӻ�����̸���������Ŷӳ�Ա����Ŀ��ĸ������'
                )),
                array('Q12' , array(
                    '�� ��ս�Թ������裺������Ӧ����Ա��ʵ��ҵ���������ò��ֳ�������������ս�Թ��������й��̸���������Ա������',
                    '�� ѧϰ������ȡ��ΪԱ����ȡ�����ܶ��ѧϰ����ѵ���ᣬ��չԱ����Ұ����������'
                ))
            );
            $temp = array($row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[11],$row[12],$row[13],$row[14]);
            $maxi = array_search(min($temp),$temp);
            $zhadvice[0] = $advice[$maxi];
            unset($temp[$maxi]);
            $maxi = array_search(min($temp),$temp);
            $zhadvice[1] = $advice[$maxi];

            $objWorksheet
                ->setCellValue('A41',mb_convert_encoding("�� ���������","UTF-8","GBK"))
                ->setCellValue('A42',mb_convert_encoding("�� �ۺϷ�����","UTF-8","GBK"))
                ->setCellValue('B43',mb_convert_encoding($zhfenxi,"UTF-8","GBK"))
                ->setCellValue('B44',mb_convert_encoding($zhfenxi1,"UTF-8","GBK"))
                ->setCellValue('A45',mb_convert_encoding("�� ��Ŀ������","UTF-8","GBK"))
                ->setCellValue('B46',mb_convert_encoding("�� �÷����:","UTF-8","GBK"))
                ->setCellValue('B47',mb_convert_encoding($zhtmfenxi[0][0].':',"UTF-8","GBK"))
                ->setCellValue('C47',mb_convert_encoding($zhtmfenxi[0][1],"UTF-8","GBK"))
                ->setCellValue('B48',mb_convert_encoding($zhtmfenxi[1][0].':',"UTF-8","GBK"))
                ->setCellValue('C48',mb_convert_encoding($zhtmfenxi[1][1],"UTF-8","GBK"))
                ->setCellValue('B49',mb_convert_encoding("�� �÷����:","UTF-8","GBK"))
                ->setCellValue('B50',mb_convert_encoding($zhtmfenxi1[0][0].':',"UTF-8","GBK"))
                ->setCellValue('C50',mb_convert_encoding($zhtmfenxi1[0][1],"UTF-8","GBK"))
                ->setCellValue('B51',mb_convert_encoding($zhtmfenxi1[1][0].':',"UTF-8","GBK"))
                ->setCellValue('C51',mb_convert_encoding($zhtmfenxi1[1][1],"UTF-8","GBK"))
                ->setCellValue('A52',mb_convert_encoding('�� ���ƽ��飺',"UTF-8","GBK"))
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
// ����ÿһ��data series ����ϵ�е�����
        $dataseriesLabels = array(
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$B$7', NULL, 1),	//	2010
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$B$12', NULL, 1),	//	2011
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$B$17', NULL, 1),	//	2012
        );
//	����X��Tick����(X��ÿһ���̶�ֵ)
        $xAxisTickValues = array(
            new \PHPExcel_Chart_DataSeriesValues('String', $sheetName.'!$C$8:$N$8', NULL, 12),	//	Q1 to Q4
        );
//	������ͼ��������
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


//	��������ϵ�� dataseries
        $series = new \PHPExcel_Chart_DataSeries(
            $chartType,		// plotType
            \PHPExcel_Chart_DataSeries::GROUPING_STACKED,	// plotGrouping
            range(0, count($dataSeriesValues)-1),			// plotOrder
            $dataseriesLabels,								// plotLabel
            $xAxisTickValues,								// plotCategory
            $dataSeriesValues								// plotValues
        );

        $series->setPlotDirection(\PHPExcel_Chart_DataSeries::DIRECTION_COLUMN);
// ������ϵ�з���һ����ͼ����
        $plotarea = new \PHPExcel_Chart_PlotArea(NULL, array($series));
// Set the chart legend
        $legend = new \PHPExcel_Chart_Legend(\PHPExcel_Chart_Legend::POSITION_BOTTOM, NULL, false);

// ����ͼ�α���
        $title = new \PHPExcel_Chart_Title($chartName);


// ����ͼ��
        $chart = new \PHPExcel_Chart(
            'chart1',		// name
            $title,			// title
            $legend,		// legend
            $plotarea,		// plotArea
            true,			// plotVisibleOnly
            0,				// displayBlanksAs
            NULL			// xAxisLabel
        );

// ����ͼ�λ�������
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

// ��ͼ����ӵ���ǰ������
        $objWorksheet->addChart($chart);
    }
}