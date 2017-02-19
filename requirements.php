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
   // if(isset($name)) 
   // 	$name = htmlspecialchars_decode($name);
   	//ajax调用都是将转为utf-8传过来，但是本系统所有页面都是gbk，所以在服务端需要将utf-8转成gbk
    if(isset($phone))
    	$phone = htmlspecialchars_decode($phone);
    if(isset($nianji))
    	$nianji = iconv('utf-8','gb2312',$nianji);
    if(isset($subject))
    	$subject = iconv('utf-8','gb2312',$subject);
	//if(isset($address)) 
    //	$address = htmlspecialchars_decode($address);
   // if(isset($message))
   // 	$message = htmlspecialchars_decode($message);
    if(isset($city))
    	$city = iconv('utf-8','gb2312',$city);
    else 
    	$city = $_SESSION['city'];
	
    
    if(empty($nianji)){
    	echo '年级不能为空';
    	exit();
    }
    if(empty($subject)){
    	echo '学科不能为空';
    	exit();
    }
    if(empty($phone)){
    	echo '电话不能为空';
    	exit();
    }

    //添加到数据库
    $query = "INSERT INTO `#@__requirements`(`tel`,`nianji`,`subject`,`apply_time`,`city`) VALUES('$phone','$nianji','$subject',NOW(),'$city')";

    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){	
    	echo '发送成功';
    	exit();
    }else{
    	echo $dsql->getError();
    	exit();
    }
   
