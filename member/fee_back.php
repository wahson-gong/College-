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

//����ύ����
if($dopost=='add')
{
    //�ж����ݵ���ȷ��
    if(isset($user_name)) 
    	$user_name = trim(htmlspecialchars_decode($user_name));
    if(isset($tel))
    	$tel = trim(htmlspecialchars_decode($tel));
    if(isset($info_bianhao))
    	$info_bianhao = trim(htmlspecialchars_decode($info_bianhao));
    if(isset($back_fee))
    	$back_fee = trim(htmlspecialchars_decode($back_fee));
    if(isset($alipay_num))
    	$alipay_num = trim(htmlspecialchars_decode($alipay_num));
    if(isset($reason))
    	$reason = trim(htmlspecialchars_decode($reason));
    
    if(empty($user_name)){
    	ShowMsg('�û�������Ϊ��','-1');
    	exit();
    }
    if(empty($tel)){
    	ShowMsg('��ϵ��ʽ����Ϊ��','-1');
    	exit();
    }

    if(empty($info_bianhao)){
    	ShowMsg('��Ϣ��Ų���Ϊ��','-1');
    	exit();
    }
    if(empty($back_fee)){
    	ShowMsg('�˿��Ȳ���Ϊ��','-1');
    	exit();
    }
    if(empty($alipay_num)){
    	ShowMsg('֧�����˺Ų���Ϊ��','-1');
    	exit();
    }
    if(empty($reason)){
    	ShowMsg('�˿�ԭ����Ϊ��','-1');
    	exit();
    }

    
    //�ñ�ŵ���Ϣ�Ƿ����,�ӵ�iD����Ϊ���û���iD
    $info = $dsql->GetOne("SELECT * FROM `#@__member_xueyuan` WHERE bianhao = '" . $info_bianhao . "' AND ac_mid = " . $cfg_ml->M_ID);
    if(empty($info)){
    	ShowMsg('�����ڱ��Ϊ'.$info_bianhao.'��ѧԱ��Ϣ,��ȷ���Ѿ��ӹ��ĵ������ȷ�ϱ���Ƿ���ȷ','fee_back.php',0,2000);
    	exit;
    }
    $apply_time = mktime();
    $info_id = $info['mid'];
    $info_bianhao = $info['bianhao'];
    $user_id = $cfg_ml->M_ID;
    
    //�鿴�Ƿ��Ѿ��ύ������
    //$bac_record = $dsql->GetOne("SELECT * FROM `#@__back_fee_record` WHERE info_bianhao= '" . $info_bianhao . "' AND user_id = " . $user_id);
    //if(empty($bac_record))
    	//��ӵ����ݿ�
    	 $query = "INSERT INTO `#@__back_fee_record`(`user_id`,`user_name`,`tel`,`info_id`,`info_bianhao`,`back_fee`,`alipay_num`,`weixin`,`reason`,`apply_time`)".
    			" VALUES('$cfg_ml->M_ID','$user_name','$tel','$info_id','$info_bianhao','$back_fee','$alipay_num','$weixin','$reason','$apply_time')";
   // else
   // 	$query = "UPDATE `#@__back_fee_record` SET user_id = '" . $cfg_ml->M_ID . "', user_name = '" . $user_name .
   // 	 "', tel = '" . $tel . "', info_id = '" . $info_id . "', info_bianhao = '" . $info_bianhao ."', back_fee = '" . $back_fee .
   // 	 "', alipay_num = '" . $alipay_num . "', weixin = '" . $weixin . "', reason = '" . $reason ."', apply_time = '" . $apply_time .
   // "', deal_result='' WHERE info_bianhao= '" . $info_bianhao . "' AND user_id = " . $user_id;
    
 
    
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $rs."rs";
    if($rs==1){
    	 // �����Ա����
    	//$cfg_ml->DelCache($cfg_ml->M_ID);
    	ShowMsg('�˿��������ӳɹ�','fee_back.php',0,5000);
    	exit();
    }else{
    	ShowMsg('�˿���������ʧ��','fee_back.php',0,5000);
    	exit();
    }
   
}
//��ȡ�Խ���¼
$dsql->SetQuery("Select * From `#@__back_fee_record` where user_id =" . $cfg_ml->M_ID);
$dsql->Execute();

$fee_back = array();
while($row = $dsql->GetArray())
{
	$fee_back[] = $row;
}
include(DEDEMEMBER."/templets/fee_back.htm");