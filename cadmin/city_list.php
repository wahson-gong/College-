<?php
require_once(dirname(__FILE__)."/config.php");
//CheckPurview('info_List');

require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");



$sql  = "SELECT * FROM `#@__city` ORDER by mid asc";
$dlist = new DataListCP();//·ÖÒ³ÓÃ

$dlist->SetTemplet(DEDEADMIN."/templets/city_list.htm");
$dlist->SetSource($sql);
$dlist->display();