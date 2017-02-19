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

//��ȡ�Խ���¼
$dsql->SetQuery("Select * From `#@__try_feed_back` where user_id =" . $cfg_ml->M_ID);
$dsql->Execute();

$trylist = array();
while($row = $dsql->GetArray())
{
	$trylist[] = $row;
}

//������ύ�Խ�����
if($dopost=='add')
{
    //�ж����ݵ���ȷ��
    if(isset($bianhao)) 
    	$bianhao = htmlspecialchars_decode($bianhao);
    if(isset($ac_feedback))
    	$try_feedback = htmlspecialchars_decode($try_feedback);
    
    if(empty($bianhao)){
    	ShowMsg('��Ϣ��Ų���Ϊ��','-1');
    	exit();
    }
    if(empty($try_feedback)){
    	ShowMsg('����˵������Ϊ��','-1');
    	exit();
    }
    if(empty($try_status)){
    	ShowMsg('�Խ���������Ϊ��','-1');
    	exit();
    }
    //�ñ�ŵ����ڰ����е���Ϣ�Ƿ����
    $info = $dsql->GetOne("SELECT * FROM `#@__member_xueyuan` WHERE bianhao = '" . $bianhao . "' AND status = '�Խ���'");
    if(empty($info)){
    	ShowMsg('�����ڱ��Ϊ'.$bianhao.'��ѧԱ��Ϣ','try_feed_back.php',0,2000);
    	exit;
    }
    
    $try_time = mktime();
    $info_id = $info['mid'];
    $info_bianhao = $info['bianhao'];
    $user_id = $cfg_ml->M_ID;
    //�鿴�Ƿ��Ѿ��ύ������
    $try_record = $dsql->GetOne("SELECT * FROM `#@__try_feed_back` WHERE info_bianhao= '" . $bianhao . "' AND user_id = " . $user_id);
    if(empty($try_record))
    	//��ӵ����ݿ�
    	$query = "INSERT INTO `#@__try_feed_back`(`user_id`,`info_id`,`info_bianhao`,`try_feed_back`,`try_status`) VALUES('$user_id','$info_id','$info_bianhao','$try_feedback','$try_status')";
    else
    	$query = "UPDATE `#@__try_feed_back` SET try_feed_back = '" . $try_feedback . "', try_status = '" . $try_status . "' WHERE info_bianhao= '" . $bianhao . "' AND user_id = " . $user_id;
    
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){
    	 // �����Ա����
    	//$cfg_ml->DelCache($cfg_ml->M_ID);
    	
    	$dsql->ExecuteNoneQuery("UPDATE `#@__member_xueyuan` SET try_feedback = '" . $try_feedback . "'," .
    			"try_status='$try_status' WHERE bianhao = '" . $info_bianhao . "'");

    	ShowMsg('�Խ��������ӳɹ�','try_feed_back.php',0,5000);
    	exit();
    }else{
    	ShowMsg('�Խ���������ʧ��','try_feed_back.php',0,5000);
    	exit();
    }
   
}
include(DEDEMEMBER."/templets/try_feed_back.htm");