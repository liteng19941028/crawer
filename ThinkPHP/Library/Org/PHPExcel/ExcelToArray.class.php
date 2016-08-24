<?php
/**
 * Created by PhpStorm.
 * User: Tinkpad
 * Date: 2015/12/30
 * Time: 15:50
 */
namespace Org\PHPExcel;

class ExcelToArray{

    public function __construct() {

        /*导入phpExcel核心类    注意 ：你的路径跟我不一样就不能直接复制*/
        include_once(dirname(__FILE__).'/PHPExcel.php');
    }

    /**

     * 读取excel $filename 路径文件名 $encode 返回数据的编码 默认为utf8

     *以下基本都不要修改

     */

    public function read($filename,$extension,$encode='utf-8'){
        import('Org.PHPExcel.PHPExcel.IOFactory');
        if( $extension =='xlsx' )
        {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        }
        else
        {
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
        }

        $objReader->setReadDataOnly(true);

        $objPHPExcel = $objReader->load($filename);

        $objWorksheet = $objPHPExcel->getActiveSheet();
        if(!$objWorksheet){
            echo 'get worksheet failed:'.$filename.'<br>';
            return;
            //returnMsg('该文件格式错误，无法获取文件内容！');
        }

        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        import('Org.PHPExcel.PHPExcel.Cell');
        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
        $excelData = array();
        for ($row = 1; $row <= $highestRow; $row++) {
            for ($col = 0; $col < $highestColumnIndex; $col++) {
                $excelData[$row][] =(string)$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
            }
        }
        return $excelData;
    }

    public function push($data,$filename='Excel',$sheet = false,$savePath = '',$title = array('要闻','市场','政策')){
        import('Org.PHPExcel.PHPExcel');
        error_reporting(E_ALL);
        date_default_timezone_set('Europe/London');
        $objPHPExcel = new \PHPExcel();

        /*以下是一些设置 ，什么作者  标题啊之类的*/
        $objPHPExcel->getProperties()->setCreator("转弯的阳光")
            ->setLastModifiedBy("转弯的阳光")
            ->setTitle("数据EXCEL导出")
            ->setSubject("数据EXCEL导出")
            ->setDescription("备份数据")
            ->setKeywords("excel")
            ->setCategory("result file");
        /*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/

        if( !$sheet ){
            $num = 0;
            foreach($data as $k => $v){
                $num++;
                $objPHPExcel->setActiveSheetIndex(0)
                    //Excel的第A列，uid是你查出数组的键值，下面以此类推
                    ->setCellValue('A'.$num, $v[0])
                    ->setCellValue('B'.$num, $v[1]);
            }
           /* $objPHPExcel->setActiveSheetIndex(0)
                //Excel的第A列，uid是你查出数组的键值，下面以此类推
                ->setCellValue('A1', '标题')
                ->setCellValue('B1', '发布时间')
                ->setCellValue('C1', '来源')
                ->setCellValue('D1', '文章');
            $num = 1;
            foreach($data as $k => $v){
                $num++;
                $objPHPExcel->setActiveSheetIndex(0)

                    //Excel的第A列，uid是你查出数组的键值，下面以此类推
                    ->setCellValue('A'.$num, $v['title'])
                    ->setCellValue('B'.$num, $v['show_time'])
                    ->setCellValue('C'.$num, $v['content_from'])
                    ->setCellValue('D'.$num, $v['article']);
            }*/
        }else{
            foreach($data as $key => $val) {
                if($key >= 1){
                    $objPHPExcel->createSheet();
                }
                $objPHPExcel->setActiveSheetIndex($key)->setTitle($title[$key])
                    //Excel的第A列，uid是你查出数组的键值，下面以此类推
                    ->setCellValue('A1', '标题')
                    ->setCellValue('B1', '发布时间')
                    ->setCellValue('C1', '来源')
                    ->setCellValue('D1', '文章');
                $num = 1;
                foreach ($val as $k => $v) {
                    $num++;
                    $objPHPExcel->setActiveSheetIndex($key)
                        //Excel的第A列，uid是你查出数组的键值，下面以此类推
                        ->setCellValue('A' . $num, $v['title'])
                        ->setCellValue('B' . $num, $v['show_time'])
                        ->setCellValue('C' . $num, $v['content_from'])
                        ->setCellValue('D' . $num, $v['article']);
                }
            }
        }
        import('Org.PHPExcel.PHPExcel.IOFactory');
        //$objPHPExcel->getActiveSheet()->setTitle('文章');
        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        if( $savePath ){
            $objWriter->save($savePath.$filename);
        }else{
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter->save('php://output');
        }
        //exit;
    }

}