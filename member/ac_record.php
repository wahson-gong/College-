<?php
/**
 * @version        $Id: edit_baseinfo.php 1 8:38 2010��7��9��Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
CheckRank(0,0);
$menutype = 'config';
if(!isset($dopost)) $dopost = '';

//��ȡ�ӵ���¼
$dsql->SetQuery("Select * From `#@__ac_record` where user_id =" . $cfg_ml->M_ID);
$dsql->Execute();

$aclist;
while($row = $dsql->GetArray())
{
	$aclist[] = $row;
}

//������ύ�ӵ���¼
if($dopost=='add')
{
    //�ж����ݵ���ȷ��
    if(isset($bianhao)) 
    	$bianhao = htmlspecialchars_decode($bianhao);
    if(isset($ac_feedback))
    	$ac_feedback = htmlspecialchars_decode($ac_feedback);
    
    if(empty($bianhao)){
    	ShowMsg('��Ϣ��Ų���Ϊ��','-1');
    	exit();
    }
    if(empty($ac_feedback)){
    	ShowMsg('�ӵ���������Ϊ��','-1');
    	exit();
    }
	if(empty($try_time)){
    	ShowMsg('�Խ�ʱ�䲻��Ϊ��','-1');
    	exit();
    }
	if(empty($try_address)){
    	ShowMsg('�Խ���ַ����Ϊ��','-1');
    	exit();
    }
    
    //�ñ�ŵ����ڰ����е���Ϣ�Ƿ����
    $info = $dsql->GetOne("SELECT * FROM `#@__member_xueyuan` WHERE bianhao = '" . $bianhao . "'");
    if(empty($info)){
    	ShowMsg('�����ڱ��Ϊ'.$bianhao.'��ѧԱ��Ϣ���п��ܸ���Ϣ�Ѿ������˽���','ac_record.php',0,1000);
    	exit;
    }
    //$ac_time = mktime();
    $info_id = $info['mid'];
    $info_bianhao = $info['bianhao'];
    $user_id = $cfg_ml->M_ID;
	$try_time = strtotime($try_time);
    
    //�鿴�Ƿ��Ѿ��ύ������
    $ac_record = $dsql->GetOne("SELECT * FROM `#@__ac_record` WHERE info_bianhao= '" . $bianhao . "' AND user_id = " . $user_id);
    if(empty($ac_record))
    	//���ӵ����ݿ�
    $query = "INSERT INTO `#@__ac_record`(`user_id`,`info_id`,`info_bianhao`,`ac_feedback`,`try_time`,`try_address`) VALUES('$user_id','$info_id','$info_bianhao','$ac_feedback','$try_time','$try_address')";
    else
    	$query = "UPDATE `#@__ac_record` SET ac_feedback = '$ac_feedback', try_time='$try_time', try_address='$try_address' WHERE info_bianhao= '" . $bianhao . "' AND user_id = " . $user_id;        
    
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){
    	 // �����Ա����
    	//$cfg_ml->DelCache($cfg_ml->M_ID);
    	$dsql->ExecuteNoneQuery("UPDATE `#@__member_xueyuan` SET ac_feedback = '" . $ac_feedback . "'," . "ac_mid = " . $cfg_ml->M_ID .
    			", try_time = '" . $try_time . "', try_address = '". $try_address ."' WHERE bianhao = '" . $info_bianhao . "'");
    	ShowMsg('�ӵ���¼���ӳɹ�','ac_record.php',0,1000);
    	exit();
    }else{
    	ShowMsg('�ӵ���¼����ʧ��','ac_record.php',0,1000);
    	exit();
    }
   
}
include(DEDEMEMBER."/templets/ac_record.htm");