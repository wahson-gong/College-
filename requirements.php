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
   // if(isset($name)) 
   // 	$name = htmlspecialchars_decode($name);
   	//ajax���ö��ǽ�תΪutf-8�����������Ǳ�ϵͳ����ҳ�涼��gbk�������ڷ������Ҫ��utf-8ת��gbk
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
    	echo '�꼶����Ϊ��';
    	exit();
    }
    if(empty($subject)){
    	echo 'ѧ�Ʋ���Ϊ��';
    	exit();
    }
    if(empty($phone)){
    	echo '�绰����Ϊ��';
    	exit();
    }

    //��ӵ����ݿ�
    $query = "INSERT INTO `#@__requirements`(`tel`,`nianji`,`subject`,`apply_time`,`city`) VALUES('$phone','$nianji','$subject',NOW(),'$city')";

    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){	
    	echo '���ͳɹ�';
    	exit();
    }else{
    	echo $dsql->getError();
    	exit();
    }
   
