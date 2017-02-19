<?php
/**
 * @version        $Id: edit_baseinfo.php 1 8:38 2010年7月9日Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
$menutype = 'config';
if(!isset($dopost)) $dopost = '';

//获取试讲记录
$dsql->SetQuery("Select * From `#@__try_feed_back` where user_id =" . $cfg_ml->M_ID);
$dsql->Execute();

$trylist = array();
while($row = $dsql->GetArray())
{
	$trylist[] = $row;
}

//如果是提交试讲反馈
if($dopost=='add')
{
    //判断数据的正确性
    if(isset($bianhao)) 
    	$bianhao = htmlspecialchars_decode($bianhao);
    if(isset($ac_feedback))
    	$try_feedback = htmlspecialchars_decode($try_feedback);
    
    if(empty($bianhao)){
    	ShowMsg('信息编号不能为空','-1');
    	exit();
    }
    if(empty($try_feedback)){
    	ShowMsg('反馈说明不能为空','-1');
    	exit();
    }
    if(empty($try_status)){
    	ShowMsg('试讲反馈不能为空','-1');
    	exit();
    }
    //该编号的正在安排中的信息是否存在
    $info = $dsql->GetOne("SELECT * FROM `#@__member_xueyuan` WHERE bianhao = '" . $bianhao . "' AND status = '试讲中'");
    if(empty($info)){
    	ShowMsg('不存在编号为'.$bianhao.'的学员信息','try_feed_back.php',0,2000);
    	exit;
    }
    
    $try_time = mktime();
    $info_id = $info['mid'];
    $info_bianhao = $info['bianhao'];
    $user_id = $cfg_ml->M_ID;
    //查看是否已经提交过反馈
    $try_record = $dsql->GetOne("SELECT * FROM `#@__try_feed_back` WHERE info_bianhao= '" . $bianhao . "' AND user_id = " . $user_id);
    if(empty($try_record))
    	//添加到数据库
    	$query = "INSERT INTO `#@__try_feed_back`(`user_id`,`info_id`,`info_bianhao`,`try_feed_back`,`try_status`) VALUES('$user_id','$info_id','$info_bianhao','$try_feedback','$try_status')";
    else
    	$query = "UPDATE `#@__try_feed_back` SET try_feed_back = '" . $try_feedback . "', try_status = '" . $try_status . "' WHERE info_bianhao= '" . $bianhao . "' AND user_id = " . $user_id;
    
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){
    	 // 清除会员缓存
    	//$cfg_ml->DelCache($cfg_ml->M_ID);
    	
    	$dsql->ExecuteNoneQuery("UPDATE `#@__member_xueyuan` SET try_feedback = '" . $try_feedback . "'," .
    			"try_status='$try_status' WHERE bianhao = '" . $info_bianhao . "'");

    	ShowMsg('试讲反馈增加成功','try_feed_back.php',0,5000);
    	exit();
    }else{
    	ShowMsg('试讲反馈增加失败','try_feed_back.php',0,5000);
    	exit();
    }
   
}
include(DEDEMEMBER."/templets/try_feed_back.htm");