<?php
/**
 * ѧԱ��Ϣ��������
 *
 * @version        $Id: member_do.php 1 13:47 2010��7��19��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/oxwindow.class.php");
if(empty($dopost)) $dopost = '';
if(empty($fmdo)) $fmdo = '';
$ENV_GOBACK_URL = isset($_COOKIE['ENV_GOBACK_URL']) ? 'info_list.php' : '';

$field = empty($_GET['field'])?'':$_GET['field'];
$value = empty($_GET['value'])?'':trim($_GET['value']);
//�б����޸�״̬
$act = empty($_GET['act'])?'':trim($_GET['act']);

if(!empty($field)&&!empty($value)){
	$update_time = mktime();
	$setSql = "";
	$mid = intval($_GET['mid']);

	if($field == 'remark'){
		$setSql .= "remark = '{$value}',";
	}else if($field == 'ac_feedback'){
		$setSql .= "ac_feedback = '{$value}',";
	}else if($field == 'try_feedback'){
		$setSql .= "try_feedback = '{$value}',";
	}else if($field == "huifang_record"){
		$setSql .= "huifang_record = '{$value}',";
	}

	$setSql .= "updatetime = " . $update_time;
	$query = "UPDATE `#@__member_xueyuan` SET " . $setSql . " where mid = " . $mid;
            
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $query;
    if($rs==1){
    	//ShowMsg('�ɹ����Ļ�Ա���ϣ�', 'info_list.php');
    	exit();
    }else{
    	//ShowMsg('����ʧ�ܣ�', 'info_list.php');
    	exit();
    }
}

if(!empty($act) && $act=="change_status"){
	$status = empty($_GET['status'])?'':trim($_GET['status']);
	$mid = empty($_GET['mid'])?'':intval($_GET['mid']);
	
	$uptime = mktime();
	
	$updateSql .= "status='$status',";
	
	if($status == "�Խ���"){
		$updateSql .= "ac_time='$uptime',";
	}elseif($status == "������"){
		$updateSql .= "ac_time='',";
	}
	
	//�޸�״̬��ͬʱ����Ҫ�޸ĸ���ʱ��ʱ�䣬���״̬Ϊ�Խ�������Ҫ�ı�ӵ�ʱ��
	$query = "UPDATE `#@__member_xueyuan` SET ".
            $updateSql
            ."updatetime='$uptime' WHERE mid=$mid";

    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $query;
    if($rs==1){
    	echo "���³ɹ�";
    	exit();
    }else{
    	echo "����ʧ��";
    	exit();
    }
}

/*----------------
function __DelMember()
ɾ����Ա
----------------*/
if($dopost=="delinfo")
{
    //CheckPurview('member_Del');
    if($fmdo=='yes')
    {
        $id = preg_replace("#[^0-9]#", '', $id);
        $safecodeok = substr(md5($cfg_cookie_encode.$randcode),0,24);
        if($safecodeok!=$safecode)
        {
        	ShowMsg("����д��ȷ�İ�ȫ��֤����","info_do.php?id={$id}&dopost=delinfo");
        	exit();
        }
        if(!empty($id))
        {
        	$rs = $dsql->ExecuteNoneQuery2("DELETE FROM `#@__member_xueyuan` WHERE mid IN (".str_replace("`",",",$id).") ");
        	if($rs<=0){
        		ShowMsg("ɾ��ʧ�ܣ�",$ENV_GOBACK_URL);
        		exit;
        	}
        		
        }
        ShowMsg("�ɹ�ɾ��һ����Ա��",$ENV_GOBACK_URL);
        exit();
    }
    $randcode = mt_rand(10000,99999);
    $safecode = substr(md5($cfg_cookie_encode.$randcode),0,24);
    $wintitle = "ѧԱ��Ϣ����-ɾ��ѧԱ��Ϣ";
    $wecome_info = "<a href='".$ENV_GOBACK_URL."'>ѧԱ��Ϣ����</a>::ɾ��ѧԱ��Ϣ";
    $win = new OxWindow();
    $win->Init("info_do.php","js/blank.js","POST");
    $win->AddHidden("fmdo","yes");
    $win->AddHidden("dopost",$dopost);
    $win->AddHidden("id",$id);
    $win->AddHidden("randcode",$randcode);
    $win->AddHidden("safecode",$safecode);
    $win->AddTitle("��ȷʵҪɾ��(ID:".$id.")���ѧԱ��Ϣ?");
    $win->AddMsgItem("��ȫ��֤����<input name='safecode' type='text' id='safecode' size='16' style='width:200px' />&nbsp;(���Ʊ����룺 <font color='red'>$safecode</font> )","30");
    $winform = $win->GetWindow("ok");
    $win->Display();
}else if($dopost=="delmembers"){
    CheckPurview('member_Del');
    if($fmdo=='yes')
    {
        $safecodeok = substr(md5($cfg_cookie_encode.$randcode),0,24);
        if($safecodeok!=$safecode)
        {
            ShowMsg("����д��ȷ�İ�ȫ��֤����","member_do.php?id={$id}&dopost=delmembers");
            exit();
        }
        if(!empty($id))
        {
            //ɾ���û���Ϣ
            
            $rs = $dsql->ExecuteNoneQuery2("DELETE FROM `#@__member` WHERE mid IN (".str_replace("`",",",$id).") And matt<>10 ");    
            if($rs > 0)
            {
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_tj` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_space` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_company` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_person` WHERE mid IN (".str_replace("`",",",$id).") ");

                //ɾ���û��������
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_stow` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_flink` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_guestbook` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_operation` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_pms` WHERE toid IN (".str_replace("`",",",$id).") Or fromid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_friends` WHERE mid IN (".str_replace("`",",",$id).") Or fid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_vhistory` WHERE mid IN (".str_replace("`",",",$id).") Or vid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__feedback` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("UPDATE `#@__archives` SET mid='0' WHERE mid IN (".str_replace("`",",",$id).")");
            }
            else
            {
                ShowMsg("�޷�ɾ���˻�Ա����������Ա�ǹ���Ա������ID��<br />������ɾ���������Ա����ɾ�����ʺţ�",$ENV_GOBACK_URL,0,3000);
                exit();
            }
        }
        ShowMsg("�ɹ�ɾ����Щ��Ա��",$ENV_GOBACK_URL);
        exit();
    }
    $randcode = mt_rand(10000, 99999);
    $safecode = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
    $wintitle = "��Ա����-ɾ����Ա";
    $wecome_info = "<a href='".$ENV_GOBACK_URL."'>��Ա����</a>::ɾ����Ա";
    $win = new OxWindow();
    $win->Init("member_do.php", "js/blank.js", "POST");
    $win->AddHidden("fmdo", "yes");
    $win->AddHidden("dopost", $dopost);
    $win->AddHidden("id",$id);
    $win->AddHidden("randcode", $randcode);
    $win->AddHidden("safecode", $safecode);
    $win->AddTitle("��ȷʵҪɾ��(ID:".$id.")�����Ա?");
    $win->AddMsgItem(" ��ȫ��֤����<input name='safecode' type='text' id='safecode' size='16' style='width:200px' /> (���Ʊ����룺 <font color='red'>$safecode</font>)","30");
    $winform = $win->GetWindow("ok");
    $win->Display();
}
/*----------------
function __Recommend()
�Ƽ���Ա
----------------*/
else if ($dopost=="recommend")
{
    CheckPurview('member_Edit');
    $id = preg_replace("#[^0-9]#", "", $id);
    if($matt==0)
    {
        $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET matt=1 WHERE mid='$id' AND matt<>10 LIMIT 1");
        ShowMsg("�ɹ�����һ����Ա�Ƽ���",$ENV_GOBACK_URL);
        exit();
    }
    else
    {
        $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET matt=0 WHERE mid='$id' AND matt<>10 LIMIT 1");
        ShowMsg("�ɹ�ȡ��һ����Ա�Ƽ���",$ENV_GOBACK_URL);
        exit();
    }
}
/*----------------
 function __EditUser()
����������Ϣ
 ----------------*/
else if ($dopost=='addInfo')
{
	//CheckPurview('member_Edit');
	//if(!isset($_POST['id'])) exit('Request Error!');
	$msg = "";
	$ok = true;
	
	$city = trim($city);
	$bus_stop = trim($bus_stop);
	$requirement = trim($requirement);
	$info_fee = trim($info_fee);
	$contact_name1 = trim($contact_name1);
	$tel1 = trim($tel1);
	$from_source = trim($from_source);


	if(empty($bianhao)){
		$msg .= "��Ų���Ϊ��\r\n";
		$ok=false;
	}
	if(empty($city)){
		$msg .= "���в���Ϊ��\r\n";
		$ok=false;
	}
	/*if(empty($bus_stop)){
		$msg .= "վ�㲻��Ϊ��\r\n";
		$ok=false;
	}*/
	/*
	if(empty($requirement)){
		$msg .= "������Ϣ����Ϊ��";
		$ok=false;
	}
	*/
	/*
	if(empty($info_fee)){
		$msg .= "��Ϣ�Ѳ���Ϊ��";
		$ok=false;
	}
	*/
	/*
	if(empty($contact_name1)){
		$msg .= "��ϵ��1����Ϊ��\r\n";
		$ok=false;
	}
	if(empty($tel1)){
		$msg .= "��ϵ��ʽ1����Ϊ��\r\n";
		$ok=false;
	}
	*/
	/*
	if(empty($from_source)){
		$msg .= "��Դ����Ϊ��\r\n";
		$ok=false;
	}
*/
	if(!ok){
		ShowMsg($msg, 'info_add.php?id='.$id);
		exit();
	}
	 
	$uptime=mktime();
	//����Զ�����
	$cityRow = $dsql->GetOne("SELECT * FROM `#@__city` WHERE city_name='" .$city . "'");
	do{
		$randnum = sprintf("%04d",mt_rand(1,9999));
		$bianhao = $cityRow['city_pre'] . $randnum;
		$member_xueyuan = $dsql->GetOne("SELECT * FROM `#@__member_xueyuan` WHERE bianhao = '" . $bianhao . "'");
	}while(!empty($member_xueyuan));
	/*
	if(!empty($try_time))
		$try_time = strtotime($try_time);
	if(!empty($huifang_time))
		$huifang_time = strtotime($huifang_time);
*/
	$query = "INSERT INTO `#@__member_xueyuan`(`bianhao`,`city`,`bus_stop`,`requirement`,`info_fee`,`contact_name1`,`tel1`,".
	"`contact_name2`,`tel2`,`remark`,`from_source`,`info_cond`,`createtime`,`updatetime`) VALUES('$bianhao','$city','$bus_stop','$requirement',".
	"'$info_fee','$contact_name1','$tel1','$contact_name2','$tel2','$remark','$from_source','$info_cond','$uptime','$uptime')";
	
	$rs = $dsql->ExecuteNoneQuery2($query);
	//echo $rs."rs";
	if($rs==1){
		ShowMsg('�ɹ�������Ա��Ϣ', "info_list.php?act=addDone&city=".$city,0,1000);
		exit();
	}else{
		ShowMsg('����ʧ��', "info_list.php",0,1000);
		exit();
	}
	
}
/**
������Ϣ
**/
else if ($dopost=='copy')
{
	//CheckPurview('member_Edit');
	//if(!isset($_POST['id'])) exit('Request Error!');
	if(!isset($_GET['id'])) exit('Request Error!');
	$id = intval($_GET['id']);

	$oldInfo = $dsql->GetOne("Select * From `#@__member_xueyuan` WHERE mid = " . $id);

	$city = $oldInfo['city'];
	$bus_stop = $oldInfo['bus_stop'];
	$requirement = $oldInfo['requirement'];
	$info_fee = $oldInfo['info_fee'];
	$contact_name1 = $oldInfo['contact_name1'];
	$tel1 = $oldInfo['tel1'];
	$from_source = $oldInfo['from_source'];
	$contact_name2 = $oldInfo['contact_name2'];
	$tel2 = $oldInfo['tel2'];
	$remark = $oldInfo['remark'];
	$info_cond = $oldInfo['info_cond'];
	$uptime=mktime();
	//����Զ�����
	$cityRow = $dsql->GetOne("SELECT * FROM `#@__city` WHERE city_name='" .$city . "'");
	do{
		$randnum = sprintf("%04d",mt_rand(1,9999));
		$bianhao = $cityRow['city_pre'] . $randnum;
		$member_xueyuan = $dsql->GetOne("SELECT * FROM `#@__member_xueyuan` WHERE bianhao = '" . $bianhao . "'");
	}while(!empty($member_xueyuan));
	/*
	if(!empty($try_time))
		$try_time = strtotime($try_time);
	if(!empty($huifang_time))
		$huifang_time = strtotime($huifang_time);
*/
	$query = "INSERT INTO `#@__member_xueyuan`(`bianhao`,`city`,`bus_stop`,`requirement`,`info_fee`,`contact_name1`,`tel1`,".
	"`contact_name2`,`tel2`,`remark`,`from_source`,`info_cond`,`createtime`,`updatetime`) VALUES('$bianhao','$city','$bus_stop','$requirement',".
	"'$info_fee','$contact_name1','$tel1','$contact_name2','$tel2','$remark','$from_source','$info_cond','$uptime','$uptime')";
	
	$rs = $dsql->ExecuteNoneQuery2($query);
	//echo $rs."rs";
	if($rs==1){
		//header("Location:info_list.php");
		ShowMsg('������Ϣ�ɹ�', "info_list.php?act=copyok&city=".$city,0,1000);
		exit();
	}else{
		ShowMsg('����ʧ��', "info_list.php",0,1000);
		exit();
	}
	
}
/*----------------
function __EditUser()
����������Ϣ
----------------*/
else if ($dopost=='editInfo')
{
    //CheckPurview('member_Edit');
    if(!isset($_POST['id'])) exit('Request Error!');
    $msg = "";
    $ok = true;
    $bianhao = trim($bianhao);
	$city = trim($city);
	$bus_stop = trim($bus_stop);
	$requirement = trim($requirement);
	$info_fee = trim($info_fee);
	$contact_name1 = trim($contact_name1);
	$tel1 = trim($tel1);
	$from_source = trim($from_source);
	//$status = trim($status);

	$ac_feedback = trim($ac_feedback);
	$try_feedback = trim($try_feedback);
	$huifang_record = trim($huifang_record);
	$remark = trim($remark);

	if(empty($bianhao)){
		$msg .= "��Ų���Ϊ��\r\n";
		$ok=false;
	}
	if(empty($city)){
		$msg .= "���в���Ϊ��\r\n";
		$ok=false;
	}
	if(empty($bus_stop)){
		$msg .= "��վ����Ϊ��\r\n";
		$ok=false;
	}
	if(empty($requirement)){
		$msg .= "������Ϣ����Ϊ��";
		$ok=false;
	}
	if(empty($info_fee)){
		$msg .= "��Ϣ�Ѳ���Ϊ��";
		$ok=false;
	}
	if(empty($contact_name1)){
		$msg .= "��ϵ��1����Ϊ��\r\n";
		$ok=false;
	}
	if(empty($tel1)){
		$msg .= "��ϵ��ʽ1����Ϊ��\r\n";
		$ok=false;
	}
	if(empty($status)){
		$msg .= "״̬����Ϊ��\r\n";
		$ok=false;
	}
	
	if(empty($from_source)){
		$msg .= "��Դ����Ϊ��\r\n";
		$ok=false;
	}
    
    if(!ok){
    	ShowMsg($msg, 'info_view.php?id='.$id);
    	exit();
    }
    	
    $uptime=mktime();
    if(!empty($ac_time))
    	$ac_time = (strtotime($ac_time)>0)?strtotime($ac_time):'';
    if(!empty($try_time))
    	$try_time = (strtotime($try_time)>0)?(strtotime($try_time)>0):'';
    if(!empty($huifang_time))
    	$huifang_time = (strtotime($huifang_time)>0)?(strtotime($try_time)>0):'';
    
    $query = "UPDATE `#@__member_xueyuan` SET
            bianhao = '$bianhao',
            city = '$city',
            bus_stop = '$bus_stop',
            requirement = '$requirement',
            info_fee = '$info_fee',
            contact_name1 = '$contact_name1',
            tel1 = '$tel1',
            contact_name2 = '$contact_name2',
            tel2 = '$tel2',
            remark = '$remark',
            from_source='$from_source',
            ac_time = '$ac_time', 
            ac_feedback='$ac_feedback',
            try_time='$try_time' ,
            try_feedback='$try_feedback' ,
            huifang_time='$huifang_time' ,
            huifang_record='$huifang_record' ,
            updatetime='$uptime' ,
            info_cond='$info_cond'
             WHERE mid=$id";
    $rs = $dsql->ExecuteNoneQuery2($query);
    //echo $query;
    if($rs==1){
    	ShowMsg('�ɹ����Ļ�Ա���ϣ�', 'info_list.php?act=modify_direct&city='.$city,0,1000);
    	exit();
    }else{
    	ShowMsg('����ʧ�ܣ�', 'info_list.php',0,1000);
    	exit();
    }
}
/*--------------
function __LoginCP()
��¼��Ա�Ŀ������
----------*/
else if ($dopost=="memberlogin")
{
    CheckPurview('member_Edit');
    PutCookie('DedeUserID',$id,1800);
    PutCookie('DedeLoginTime',time(),1800);
    if(empty($jumpurl)) header("location:../member/index.php");
    else header("location:$jumpurl");
} else if ($dopost == "deoperations")
{
    $nid = preg_replace('#[^0-9,]#', '', preg_replace('#`#', ',', $nid));
    $nid = explode(',', $nid);
    if(is_array($nid))
    {
        foreach ($nid as $var)
        {
            $query = "DELETE FROM `#@__member_operation` WHERE aid = '$var'";
            $dsql->ExecuteNoneQuery($query);
        }
        ShowMsg("ɾ���ɹ���","member_operations.php");
        exit();
    }
} else if ($dopost == "upoperations")
{
    $nid = preg_replace('#[^0-9,]#', '', preg_replace('#`#', ',', $nid));
    $nid = explode(',', $nid);
    if(is_array($nid))
    {
        foreach ($nid as $var)
        {
            $query = "UPDATE `#@__member_operation` SET sta = '1' WHERE aid = '$var'";
            $dsql->ExecuteNoneQuery($query);
            ShowMsg("���óɹ���","member_operations.php");
            exit();
        }
    }
} else if($dopost == "okoperations")
{
    $nid = preg_replace('#[^0-9,]#', '', preg_replace('#`#', ',', $nid));
    $nid = explode(',', $nid);
    if(is_array($nid))
    {
        foreach ($nid as $var)
        {
            $query = "UPDATE `#@__member_operation` SET sta = '2' WHERE aid = '$var'";
            $dsql->ExecuteNoneQuery($query);
            ShowMsg("���óɹ���","member_operations.php");
            exit();
        }
    }
}