<?php
require_once(dirname(__FILE__)."/config.php");
//CheckPurview('info_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");
 
if(empty($dopost)) $dopost = '';

if($dopost == 'set_status'){
	$id = intval($_GET['mid']);
	$status = trim($_GET['status']);
	$deal_result = trim($_GET['result']);
	if(empty($status)){
		echo '更新失败';
		exit;
	}
	$query = "UPDATE `#@__requirements` SET deal_status = '" . $status . "', deal_content='$deal_result', deal_time=NOW() where mid = " .$id;		
	$rs = $dsql->ExecuteNoneQuery2($query);
	if($rs==1){
		echo '更新状态成功';
		exit;	
	}else{
		echo '更新状态失败';
		exit;
	}
		
}
if(!isset($deal_status)) $deal_status = '';//处理状态，空为所有信息
if(!isset($city)) $city = '';//城市，空为所有城市


//处理状态
$staArr = array(1=>'未处理', 2=>'已处理');
$wheres[] = "1=1";
if($deal_status   != '')
{
	$wheres[] = " deal_status LIKE '$deal_status' ";
}

if($city != '')
{
	$wheres[] = " city LIKE '$city' ";
}

$whereSql = join(' AND ',$wheres);

$sql  = "SELECT * FROM `#@__requirements` where ". $whereSql ." order by mid desc";
//echo $sql;
$dlist = new DataListCP();//分页用

//城市
$dsql->SetQuery("Select mid,city_name From `#@__city` where mid>0");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	$cityArr[$row->mid] = $row->city_name;
}

$dlist->SetTemplet(DEDEADMIN."/templets/yuyue.htm");
$dlist->SetSource($sql);
$dlist->display();
//处理状态
function Status($status)
{
	//退款状态
	$dealSta = array(1=>'未处理', 2=>'已处理');
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
		if($mt=='ut') return " <font color='red'>待升级：".$MemberTypes[$rank]."</font>";
		else return $MemberTypes[$rank];
	} else {
		if($mt=='ut') return '';
		else return $mt;
	}
}

function GetMAtt($m)
{
	if($m<1) return '';
	else if($m==10) return "&nbsp;<font color='red'>[管理员]</font>";
	else return "&nbsp;<img src='images/adminuserico.gif' wmidth='16' height='15'><font color='red'>[荐]</font>";
}
