<?php
/**
 * 编辑一个模板
 *
 * @version        $Id: templets_one_edit.php 1 23:07 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once (dirname(__FILE__) . "/include/common.inc.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

//获取城市
$city = isset($_SESSION['city']) ? $_SESSION['city'] : '厦门';
//获取厦门对应的资费说明
$sql = "SELECT * from `#@__sgpage` where city = '" . $city . "'";

$dlist = new DataListCP();//分页用
//echo $sql;
$dlist->SetParameter('city',$city);
$dlist->SetTemplet("./templets/home/zifei.html");
$dlist->SetSource($sql);
$dlist->display();
