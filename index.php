<?php
session_start();
require_once (dirname(__FILE__) . "/include/common.inc.php");
require_once (dirname(__FILE__) . "/include/checkMobile.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

//���л���������ת
if(!isset($dopost)){
	if(empty($_SESSION['city']))
		$city = '����';
	else 
		$city = $_SESSION['city'];
}else 
	$_SESSION['city'] = $city;
//��ȡ���н���ͼƬ
//$sql  = "SELECT city_intro_pic FROM `#@__city` where city_name = '" . $city . "'";
//$city_pic = $dsql->getOne($sql);

$dlist = new DataListCP();//��ҳ��
$dlist->SetParameter('city',$city);
//�ж��Ƿ�Ϊ�ֻ������
$isMobile = isMobile()?1:0;

$dlist->SetParameter('isMobile',$isMobile);
//$dlist->SetParameter('city_pic',$city_pic['city_intro_pic']);

$dlist->SetTemplet("./templets/home/index.html");
$dlist->SetSource($sql);
$dlist->display();


