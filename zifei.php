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
require_once (dirname(__FILE__) . "/include/common.inc.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

//��ȡ����
$city = isset($_SESSION['city']) ? $_SESSION['city'] : '����';
//��ȡ���Ŷ�Ӧ���ʷ�˵��
$sql = "SELECT * from `#@__sgpage` where city = '" . $city . "'";

$dlist = new DataListCP();//��ҳ��
//echo $sql;
$dlist->SetParameter('city',$city);
$dlist->SetTemplet("./templets/home/zifei.html");
$dlist->SetSource($sql);
$dlist->display();
