<?php
/**
 * @version        $Id: edit_baseinfo.php 1 8:38 2010��7��9��Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
session_start();
require_once (dirname(__FILE__) . "/include/common.inc.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");

$dlist = new DataListCP();//��ҳ��

$city = isset($_SESSION['city'])?$_SESSION['city']:'����';

$dlist->SetParameter("city", $city);
$dlist->SetTemplet("./templets/home/find.htm");
$dlist->display();
