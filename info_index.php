<?php

require_once (dirname(__FILE__) . "/include/common.inc.php");
require_once(dirname(__FILE__)."/member/config.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
if(!$cfg_ml->IsLogin())
{
	//include_once(dirname(__FILE__)."/templets/index-notlogin.htm");
	$dpl = new DedeTemplate();
	$tpl = dirname(__FILE__)."/member/templets/index-notlogin.htm";
	$dpl->LoadTemplate($tpl);
	$dpl->display();
	exit;
}else{
	//��ȡ���д���
	$minfo = $dsql->GetOne("SELECT city FROM `#@__member` WHERE mid='".$cfg_ml->M_ID."'; ");
	//$code = $_GET['city_code'];
	
	$cityrow = $dsql->GetOne("SELECT city_code,city_intro_pic FROM `#@__city` WHERE city_name = '" . $minfo['city'] . "'");
	if(!empty($cityrow)){
		$code = $cityrow['city_code'];//Ĭ��Ϊ����
	}
	$qq = $cityrow['city_intro_pic'];
}

$cityrow = $dsql->GetOne("SELECT * FROM `#@__city` WHERE city_code = '" . $code . "'");
//print_r($cityrow);
if(!empty($cityrow))
	$city = $cityrow['city_name'];
else 
	$city = '����';

if(!isset($city)) $city = '����';//���У�Ĭ��Ϊ����

$city_form = empty($city) ? "<option value=''>��������</option>\r\n" : "<option value='$city'>$city</option>\r\n";

//��Դ
$cityArr = array();
$dsql->SetQuery("Select mid,city_name From `#@__city` where mid>0");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	$cityArr[$row->mid] = $row->city_name;
}

$wheres[] = " status LIKE '������' ";

if($city != '')
{
	$wheres[] = " city LIKE '$city' ";
}

$whereSql = join(' AND ',$wheres);
if($whereSql!='')
{
	$whereSql = ' WHERE '.$whereSql;
}

$sql  = "SELECT * FROM `#@__member_xueyuan` $whereSql ORDER BY createtime DESC ";
$dlist = new DataListCP();//��ҳ��
//echo $sql;
$dlist->SetParameter('city',$city);
$dlist->SetParameter('qq',$qq);
$dlist->SetTemplet("./templets/default/info_index.htm");
$dlist->SetSource($sql);
$dlist->display();

function GetMemberName($rank,$mt)
{
	global $MemberTypes;
	if(isset($MemberTypes[$rank]))
	{
		if($mt=='ut') return " <font color='red'>��������".$MemberTypes[$rank]."</font>";
		else return $MemberTypes[$rank];
	} else {
		if($mt=='ut') return '';
		else return $mt;
	}
}

function GetMAtt($m)
{
	if($m<1) return '';
	else if($m==10) return "&nbsp;<font color='red'>[����Ա]</font>";
	else return "&nbsp;<img src='images/adminuserico.gif' wmidth='16' height='15'><font color='red'>[��]</font>";
}
