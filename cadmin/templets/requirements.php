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
//CheckPurview('info_List');
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

//�ж����ݵ���ȷ��
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
    	echo '��������Ϊ��';
    	exit();
    }
    if(empty($phone)){
    	echo '�绰����Ϊ��';
    	exit();
    }
    
    //��ӵ����ݿ�
    $query = "INSERT INTO `#@__requirements`(`name`,`tel`,`address`,`requirement`,`apply_time`,`city`) VALUES('$name','$phone','$address','$message',NOW(),'$city')";
    
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){
    	
    	echo '���ͳɹ�';
    	exit();
    }else{
    	echo $dsql->getError();
    	exit();
    }
   
