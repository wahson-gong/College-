<?php
/**
 * 城市信息管理操作
 *
 * @version        $Id: member_do.php 1 13:47 2010年7月19日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/oxwindow.class.php");
if(empty($dopost)) $dopost = '';
if(empty($fmdo)) $fmdo = '';
$ENV_GOBACK_URL = isset($_COOKIE['ENV_GOBACK_URL']) ? 'city_list.php' : '';

$field = empty($_GET['field'])?'':$_GET['field'];
$value = empty($_GET['value'])?'':trim($_GET['value']);
//列表中修改状态
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
    	//ShowMsg('成功更改会员资料！', 'info_list.php');
    	exit();
    }else{
    	//ShowMsg('更新失败！', 'info_list.php');
    	exit();
    }
}

/*----------------
function __DelMember()
删除会员
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
        	ShowMsg("请填写正确的安全验证串！","city_do.php?id={$id}&dopost=delinfo");
        	exit();
        }
        if(!empty($id))
        {
        	$rs = $dsql->ExecuteNoneQuery2("DELETE FROM `#@__city` WHERE mid IN (".str_replace("`",",",$id).") ");
        	if($rs<=0){
        		ShowMsg("删除失败！",$ENV_GOBACK_URL);
        		exit;
        	}
        		
        }
        ShowMsg("成功删除一个城市！",$ENV_GOBACK_URL);
        exit();
    }
    $randcode = mt_rand(10000,99999);
    $safecode = substr(md5($cfg_cookie_encode.$randcode),0,24);
    $wintitle = "城市信息管理-删除城市信息";
    $wecome_info = "<a href='".$ENV_GOBACK_URL."'>城市信息管理</a>::删除城市信息";
    $win = new OxWindow();
    $win->Init("city_do.php","js/blank.js","POST");
    $win->AddHidden("fmdo","yes");
    $win->AddHidden("dopost",$dopost);
    $win->AddHidden("id",$id);
    $win->AddHidden("randcode",$randcode);
    $win->AddHidden("safecode",$safecode);
    $win->AddTitle("你确实要删除(ID:".$id.")这个城市信息?");
    $win->AddMsgItem("安全验证串：<input name='safecode' type='text' id='safecode' size='16' style='width:200px' />&nbsp;(复制本代码： <font color='red'>$safecode</font> )","30");
    $winform = $win->GetWindow("ok");
    $win->Display();
}else if($dopost=="delmembers"){
    CheckPurview('member_Del');
    if($fmdo=='yes')
    {
        $safecodeok = substr(md5($cfg_cookie_encode.$randcode),0,24);
        if($safecodeok!=$safecode)
        {
            ShowMsg("请填写正确的安全验证串！","member_do.php?id={$id}&dopost=delmembers");
            exit();
        }
        if(!empty($id))
        {
            //删除用户信息
            
            $rs = $dsql->ExecuteNoneQuery2("DELETE FROM `#@__member` WHERE mid IN (".str_replace("`",",",$id).") And matt<>10 ");    
            if($rs > 0)
            {
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_tj` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_space` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_company` WHERE mid IN (".str_replace("`",",",$id).") ");
                $dsql->ExecuteNoneQuery("DELETE FROM `#@__member_person` WHERE mid IN (".str_replace("`",",",$id).") ");

                //删除用户相关数据
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
                ShowMsg("无法删除此会员，如果这个会员是管理员关连的ID，<br />必须先删除这个管理员才能删除此帐号！",$ENV_GOBACK_URL,0,3000);
                exit();
            }
        }
        ShowMsg("成功删除这些会员！",$ENV_GOBACK_URL);
        exit();
    }
    $randcode = mt_rand(10000, 99999);
    $safecode = substr(md5($cfg_cookie_encode.$randcode), 0, 24);
    $wintitle = "会员管理-删除会员";
    $wecome_info = "<a href='".$ENV_GOBACK_URL."'>会员管理</a>::删除会员";
    $win = new OxWindow();
    $win->Init("member_do.php", "js/blank.js", "POST");
    $win->AddHidden("fmdo", "yes");
    $win->AddHidden("dopost", $dopost);
    $win->AddHidden("id",$id);
    $win->AddHidden("randcode", $randcode);
    $win->AddHidden("safecode", $safecode);
    $win->AddTitle("你确实要删除(ID:".$id.")这个会员?");
    $win->AddMsgItem(" 安全验证串：<input name='safecode' type='text' id='safecode' size='16' style='width:200px' /> (复制本代码： <font color='red'>$safecode</font>)","30");
    $winform = $win->GetWindow("ok");
    $win->Display();
}
/*----------------
function __Recommend()
推荐会员
----------------*/
else if ($dopost=="recommend")
{
    CheckPurview('member_Edit');
    $id = preg_replace("#[^0-9]#", "", $id);
    if($matt==0)
    {
        $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET matt=1 WHERE mid='$id' AND matt<>10 LIMIT 1");
        ShowMsg("成功设置一个会员推荐！",$ENV_GOBACK_URL);
        exit();
    }
    else
    {
        $dsql->ExecuteNoneQuery("UPDATE `#@__member` SET matt=0 WHERE mid='$id' AND matt<>10 LIMIT 1");
        ShowMsg("成功取消一个会员推荐！",$ENV_GOBACK_URL);
        exit();
    }
}
/*----------------
 function __EditUser()
增添需求信息
 ----------------*/
else if ($dopost=='addInfo')
{
	//CheckPurview('member_Edit');
	//if(!isset($_POST['id'])) exit('Request Error!');
	$msg = "";
	$ok = true;
	
	$city_name = trim($city_name);
	$city_code = trim($city_code);
	$city_pre = trim($city_pre);
	$city_intro_pic = trim($city_intro_pic);
	$city_fee_pic = trim($city_fee_pic);
	
	if(empty($city_name)){
		$msg .= "城市名称不能为空\r\n";
		$ok=false;
	}
	if(empty($city_code)){
		$msg .= "城市代码为空\r\n";
		$ok=false;
	}
	if(empty($city_pre)){
		$msg .= "城市前缀不能为空\r\n";
		$ok=false;
	}

	if(!ok){
		ShowMsg($msg, 'city_add.php?id='.$id);
		exit();
	}
	 
	
	$query = "INSERT INTO `#@__city`(`type`,`parent_id`,`city_code`,`city_name`,`city_pre`,`city_intro_pic`,`city_fee_pic`) VALUES(2,0,'$city_code','$city_name',".
	"'$city_pre','$city_intro_pic','$city_fee_pic')";
	
	$rs = $dsql->ExecuteNoneQuery2($query);
	//echo $rs."rs";
	 //公告应用于所有城市
    if($noticeall){
    	$query = "UPDATE `#@__city` SET          
			city_fee_pic = '$city_fee_pic'
             WHERE mid>0";
    	$rs = $dsql->ExecuteNoneQuery2($query);
    }
	if($rs==1){
		ShowMsg('成功新增城市信息', "city_list.php?act=addDone&city=".$city,0,1000);
		exit();
	}else{
		ShowMsg('新增失败', "city_list.php",0,1000);
		exit();
	}
	
}
/*----------------
function __EditUser()
更改需求消息
----------------*/
else if ($dopost=='editInfo')
{
    //CheckPurview('member_Edit');
    if(!isset($_POST['id'])) exit('Request Error!');
    $msg = "";
    $ok = true;
    
	$city_name = trim($city_name);
	$city_code = trim($city_code);
	$city_pre = trim($city_pre);
	$city_intro_pic = trim($city_intro_pic);
	$city_fee_pic = trim($city_fee_pic);
	$noticeall = trim($noticeall);

	if(empty($city_name)){
		$msg .= "城市名称不能为空\r\n";
		$ok=false;
	}
	if(empty($city_code)){
		$msg .= "城市代码不能为空\r\n";
		$ok=false;
	}
	if(empty($city_pre)){
		$msg .= "城市前缀不能为空\r\n";
		$ok=false;
	}
	
    if(!ok){
    	ShowMsg($msg, 'city_view.php?id='.$id);
    	exit();
    }
    
    $query = "UPDATE `#@__city` SET
            city_code = '$city_code',
            city_pre = '$city_pre',
            city_name = '$city_name',
			city_intro_pic = '$city_intro_pic', 
			city_fee_pic = '$city_fee_pic'
             WHERE mid=$id";
    $rs = $dsql->ExecuteNoneQuery2($query);
    //公告应用于所有城市
    if($noticeall){
    	$query2 = "UPDATE `#@__city` SET          
			city_fee_pic = '$city_fee_pic'
             WHERE mid>0";
    	$rs2 = $dsql->ExecuteNoneQuery($query2);
    }

    //echo $query;
    if($rs==1){
    	ShowMsg('成功更改会员资料！', 'city_list.php',0,1000);
    	exit();
    }else{
    	ShowMsg('更新失败！', 'city_list.php',0,1000);
    	exit();
    }
}
/*--------------
function __LoginCP()
登录会员的控制面板
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
        ShowMsg("删除成功！","member_operations.php");
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
            ShowMsg("设置成功！","member_operations.php");
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
            ShowMsg("设置成功！","member_operations.php");
            exit();
        }
    }
}