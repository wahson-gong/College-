<?php
require_once(dirname(__FILE__)."/config.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
 
if(empty($dopost)) $dopost = '';

if($dopost == 'add_result'){
	$id = intval($_GET['id']);
	$deal_result = trim($_GET['result']);
	if(empty($deal_result)){
		ShowMsg('�����������Ϊ��','fee_back.php',0,1000);
		exit;
	}
	$record = $dsql->getOne("SELECT * FROM `#@__back_fee_record` WHERE mid = " . $id);
	if(!empty($record)){
		$query = "UPDATE `#@__back_fee_record` SET deal_result = '" . $deal_result . "', deal_time = '" . mktime() . "' where mid = " . $id;		
		$rs = $dsql->ExecuteNoneQuery2($query);
		ShowMsg('����������³ɹ�','fee_back.php',0,1000);
		exit;
	}	
}else if($dopost == 'set_status'){
	$id = intval($_GET['mid']);
	$status = trim($_GET['status']);
	$deal_result = trim($_GET['result']);
	if(empty($status)){
		echo '����ʧ��';
		exit;
	}
	$record = $dsql->getOne("SELECT * FROM `#@__back_fee_record` WHERE mid = " . $id);
	if(!empty($record)){
		$query = "UPDATE `#@__back_fee_record` SET deal_status = '" . $status . "', deal_result='$deal_result' where mid = " .$id;		
		$rs = $dsql->ExecuteNoneQuery2($query);
		echo '����״̬�ɹ�';
		exit;
	}	
}



if(!isset($info_sta)) $info_sta = '';//����״̬����Ϊ������Ϣ
if(!isset($city)) $city = '';//���У���Ϊ���г���

//��Ϣ״̬
$staArr = array(0=>'δ����', 1=>'���˿�', 2=>'���˿�',3=>'��ȷ��');
//����Ա����ĳ���
$cityArr = array();
$user_id = $GLOBALS['cuserLogin']->getUserID();
$User =  $dsql->GetOne("Select * from `#@__admin` where id = " . $user_id);
if(empty($User)||empty($User['admin_city'])){
$dsql->SetQuery("Select mid,city_name From `#@__city` where mid>0");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	$cityArr[$row->mid] = $row->city_name;
}
}else{
	$cityArr = explode(',',$User['admin_city']);
}

if($info_sta   != '')
{
	$wheres[] = " deal_status LIKE '$info_sta' ";
}

if($keyword != ''){
	$wheres[] = " (br.info_bianhao LIKE '%$keyword%' or br.user_id like '%$keyword%' or br.alipay_num like '%$keyword%' or br.weixin like '%$keyword%') ";
}



if($city != '')
{
	$wheres[] = " mx.city LIKE '$city' and br.info_id = mx.mid ";
}else{
	$cities = array();
	foreach($cityArr as $ocity)
		$cities[] = ("'" . $ocity . "'");
	$wheres[] =  " mx.city in (" . implode(",",$cities) . ")";
	$wheres[] = " br.info_id = mx.mid ";
}

$whereSql = join(' AND ',$wheres);



$sql  = "SELECT br.*,mx.city,mx.mid as mx_mid,m.school,m.zhuanye,m.nianji FROM `#@__back_fee_record` as br,`#@__member_xueyuan` as mx,`#@__member` as m where" . $whereSql . " and m.mid = br.user_id ORDER BY apply_time DESC ";



$dlist = new DataListCP();//��ҳ��

$dlist->SetTemplet(DEDEADMIN."/templets/fee_back.htm");
$dlist->SetSource($sql);
$dlist->display();
//�˿�״̬
function Status($status)
{
	//�˿�״̬
	$dealSta = array(1=>'���˿�', 2=>'���˿�', 3=>'δ����',4 =>'��ȷ��');
	$html = "<select class='deal_status' name='deal_status' style='width:80px'>";
           
    foreach($dealSta as $k=>$v)
    {
         if($status==$v) $html.="<option value='$v' selected>$v</option>\r\n";
         else $html.="<option value='$v'>$v</option>\r\n";
    }

    $html.='</select>';
	return $html;
}

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
