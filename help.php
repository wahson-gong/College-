<?php
/**
 * �༭һ��ģ��
 *
 * @version        $Id: templets_one_edit.php 1 23:07 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
session_start();
require_once (dirname(__FILE__) . "/include/common.inc.php");
require_once (dirname(__FILE__) . "/include/checkMobile.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

//��ȡ����
$city = isset($_SESSION['city']) ? $_SESSION['city'] : '����';
$aid=intval($_GET['aid']);
/*
if(empty($aid))
{
	ShowMsg('�����ID��','javascript:;');
	exit();
}

include_once(DEDEINC."/arc.sgpage.class.php");
$sg = new sgpage($aid);
$sg->display();
exit();
*/

$sql = "SELECT * from `#@__sgpage` where aid=" . $aid;
$row = $dsql->GetOne($sql);

$dlist = new DataListCP();//��ҳ��

//echo $sql;
$dlist->SetParameter('city',$city);
//�ж��Ƿ�Ϊ�ֻ������
$isMobile = isMobile()?1:0;

$dlist->SetParameter("isMobile",$isMobile);
$dlist->SetParameter('aid',$aid);
$dlist->SetTemplet("./templets/home/help.html");
//$dlist->SetSource($sql);
$dlist->display();
function convert($html){
	return html_entity_decode($html,ENT_QUOTES);
}
