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
session_start();
require_once (dirname(__FILE__) . "/include/common.inc.php");
//CheckPurview('info_List');
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

//判断数据的正确性
    if(isset($name)) 
    	$name = htmlspecialchars_decode($name);
    if(isset($phone))
    	$phone = htmlspecialchars_decode($phone);
	if(isset($address)) 
    	$address = htmlspecialchars_decode($address);
    if(isset($message))
    	$message = htmlspecialchars_decode($message);
    if(isset($city))
    	$city = htmlspecialchars_decode($city);
    else 
    	$city = $_SESSION['city'];
	
    
    if(empty($name)){
    	echo '姓名不能为空';
    	exit();
    }
    if(empty($phone)){
    	echo '电话不能为空';
    	exit();
    }
    
    //添加到数据库
    $query = "INSERT INTO `#@__requirements`(`name`,`tel`,`address`,`requirement`,`apply_time`,`city`) VALUES('$name','$phone','$address','$message',NOW(),'$city')";
    
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){
    	
    	echo '发送成功';
    	exit();
    }else{
    	echo $dsql->getError();
    	exit();
    }
   
