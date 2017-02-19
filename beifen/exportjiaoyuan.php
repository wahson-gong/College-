
<?php
/*
 * Created on 2015年11月15日
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
/**
 *
 * @copyright 2007-2012 Xiaoqiang.
 * @author Xiaoqiang.Wu <jamblues@gmail.com>
 * @version 1.01
 */
 set_time_limit (0);
 @ ini_set('memory_limit', '1024M'); 
header("Content-type: text/html; charset=gbk");  
error_reporting(E_ALL);
 
date_default_timezone_set('Asia/ShangHai');
 
/** PHPExcel_IOFactory */
include '../PHPExcel.php';
require_once ("../include/common.inc.php");

/*要生成的表格*/
$objPHPExcel = new PHPExcel();
/*设置文本对齐方式*/
$objPHPExcel->getDefaultStyle()->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
$objPHPExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(40);
$objPHPExcel->getActiveSheet()->getDefaultColumnDimension()->setWidth(18);
$objPHPExcel->getActiveSheet()->getColumnDimension("D")->setWidth(30);
			/*以下是一些设置 ，什么作者  标题啊之类的*/
			$objPHPExcel->getProperties()->setCreator("Admin")
			->setLastModifiedBy("Admin")
			->setTitle('教员表')
			->setSubject('教员表')
			->setDescription("教员表")
			->setKeywords("excel")
			->setCategory("result file");
			/*设置栏目名称*/
/*设置表头信息等*/
$headComumns = array( "A1" => "编号", "B1" => "城市", "C1" => "姓名", "D1" => "学校", "E1" => "年级", "F1" => "专业", "G1" => "性别", 
					"H1" => "qq",  "I1" => "教员类型", "J1" => "备注");
$objPHPExcel->setActiveSheetIndex(0)
			//Excel的第A列，uid是你查出数组的键值，下面以此类推
			->setCellValue('A1', $headComumns['A1'])
			->setCellValue('B1', $headComumns['B1'])
			->setCellValue('C1', $headComumns['C1'])
			->setCellValue('D1', $headComumns['D1'])
			->setCellValue('E1', $headComumns['E1'])
			->setCellValue('F1', $headComumns['F1'])
			->setCellValue('G1', $headComumns['G1'])
			->setCellValue('H1', $headComumns['H1'])
			->setCellValue('I1', $headComumns['I1'])
			->setCellValue('J1', $headComumns['J1']);
//条件筛选
if(!empty($_GET['zt']))
	$wheres[] = " spacesta = '" . trim($_GET['zt']) . "'";
if(!empty($_GET['city']))
	$wheres[] = " city like '" . trim($_GET['city']) . "'";
$wheres[] = " matt != 10 ";
$whereSql = join(' AND ',$wheres);

if($whereSql!='')
{
	$whereSql = ' WHERE '.$whereSql;
}else 
	$whereSql = " WHERE 1=1 ";
/*获取数据*/
$dsql->SetQuery($sql  = "SELECT m.*,a.* as aid FROM `#@__member` as m left join `#@__archives` as a on m.mid = a.mid $whereSql ORDER BY m.mid DESC ");
$dsql->Execute();

while($record = $dsql->GetObject())
{
	$records[] = $record;
}
$staArr = array( 0=>'注册教员', 1=>'审核教员', 2=>'推荐教员', 3=>'明星教员');
//写入到表格中
for($row = 0; $row < count($records); $row++){
	$excelRow = $row + 2;
	$spacesta = intval($records[$row]->spacesta);
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A'.($excelRow), $records[$row]->mid)//编号
	->setCellValue('B'.($excelRow), iconv('gbk','utf-8',$records[$row]->city))//chengshi
	->setCellValue('C'.($excelRow), iconv('gbk','utf-8',$records[$row]->uname))//城市
	->setCellValue('D'.($excelRow), iconv('gbk','utf-8',$records[$row]->school))//信息
	->setCellValue('E'.($excelRow), iconv('gbk','utf-8',$records[$row]->nianji))//联系方式
	->setCellValue('F'.$excelRow,iconv('gbk','utf-8',$records[$row]->zhuanye))//信息费
	->setCellValue('G'.($excelRow), iconv('gbk','utf-8',$records[$row]->sex))//状态
	->setCellValue('H'.($excelRow), iconv('gbk','utf-8',$records[$row]->qq))//备注
	->setCellValue('I'.($excelRow), $staArr[$spacesta])//试讲日期
	->setCellValue('J'.($excelRow), iconv('gbk','utf-8',$records[$row]->beizhu));//试讲反馈
}		
	   $fname = date("Y-m-d")."教员列表";
        /*如果找到了就输出输出下载到本地*/
        $objPHPExcel->getActiveSheet()->setTitle('教员列表');
		$objPHPExcel->setActiveSheetIndex(0);
		ob_end_clean();//清除缓冲区，防止乱码
		header('Content-Type: application/vnd.ms-excel');

		header('Content-Disposition: attachment;filename="'.$fname.'.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

		$objWriter->save('php://output');
		exit;		
		
?>
