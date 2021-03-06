<?php
require_once(dirname(__FILE__)."/config.php");
//CheckPurview('info_List');

require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

if(!isset($info_sta)) $info_sta = '安排中';//信息状态，0为所有状态
if(!isset($city)) $city = '';//城市，0为所有城市
if(!isset($info_from)) $info_from = '';//0所有来源
if(!isset($show_mode)) $show_mode = 'table';

//添加完后直接跳转到复制信息
if(isset($_GET['act'])){
	$city = $_GET['city'];
	$show_mode = 'text';
	$info_sta = '安排中';
}

//修改完后跳转到该城市下的信息
if(isset($_GET['act'])&&$_GET['act']='modify_direct'){
	$city = $_GET['city'];
	$show_mode = 'table';
	$info_sta = '安排中';
}
//复制完后跳转到该城市下的列表中
if(isset($_GET['act'])&&$_GET['act']='copyok'){
	$city = $_GET['city'];
	$show_mode = 'table';
	$info_sta = '安排中';
}

if(!isset($keyword)) $keyword = '';
else $keyword = trim(FilterSearch($keyword));

$info_state_form = empty($info_sta) ? "<option value=''>信息状态</option>\r\n" : "<option value='$info_sta'>$info_sta</option>\r\n";
$city_form = empty($city) ? "<option value=''>所属城市</option>\r\n" : "<option value='$city'>$city</option>\r\n";
$source_form = empty($info_from) ? "<option value=''>信息来源</option>\r\n" : "<option value='$info_from'>$info_from</option>\r\n";

//管理员管理的城市
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

//信息状态
$staArr = array(1=>'安排中', 2=>'试讲中', 3=>'试讲成功', 4=>'已回访', 5=>'坏单', 6=>"待处理");

//$staArrmatt = array(1=>'被推荐', 0=>'非普通 ' );
$InfoSourceModel = array();

$dsql->SetQuery("Select mid,source_name From `#@__from_source` where mid>0 ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	$InfoSourceModel[$row->mid] = $row->source_name;
}

if($sortkey=='mid')
{
	$sortform = "<option value='mid'>mid/创建时间</option>\r\n";
}
else if($sortkey=='try_time')
{
	$sortform = "<option value='try_time'>试讲时间</option>\r\n";
}
else if($sortkey=='huifang_time')
{
	$sortform = "<option value='huifang_time'>回访时间</option>\r\n";
}
else if($sortkey=='updatetime')
{
	$sortform = "<option value='updatetime'>更新时间</option>\r\n";
}
else
	$sortkey = "mid";
//关键字

//复制模式下，排序按更新时间
if($mode=="text")
	$sortkey = 'updatetime';

$wheres[] = " (bianhao LIKE '%$keyword%' or city LIKE '%$keyword%' or bus_stop LIKE '%$keyword%' or requirement LIKE '%$keyword%' or tel1 LIKE '%$keyword%' or tel2 LIKE '%$keyword%' ) ";

if($info_sta!= '')
{
	$info_sta = ($show_mode=="text")?'安排中':$info_sta;
	$wheres[] = " status LIKE '$info_sta' ";
}

if($city != '')
{
	$wheres[] = " city LIKE '$city' ";
}else{
	$cities = array();
	foreach($cityArr as $ocity)
		$cities[] = ("'" . $ocity . "'");
	$wheres[] =  "city in (" . implode(",",$cities) . ")";
}

if($info_from != '')
{
	$wheres[] = " from_source LIKE '$info_from' ";
}

$whereSql = join(' AND ',$wheres);
if($whereSql!='')
{
	$whereSql = ' WHERE '.$whereSql;
}

$dsql->SetQuery("Select status,sum(info_fee) as money_sum From `#@__member_xueyuan` where mid>0 group by status");
$dsql->Execute();
while($row = $dsql->GetObject())
{
	$feeStatistic[$row->status] = $row->money_sum;
}


$sql  = "SELECT * FROM `#@__member_xueyuan` $whereSql ORDER BY $sortkey DESC ";

$dlist = new DataListCP();//分页用
//echo $sql;

$dlist->SetParameter('info_sta',$info_sta);

$dlist->SetParameter('city',$city);
$dlist->SetParameter('info_from',$info_form);
$dlist->SetParameter('sort_form',$sort_form);
$dlist->SetParameter('sortkey',$sortkey);
$dlist->SetParameter('keyword',$keyword);
if(!empty($User)&&$User['usertype']<10)
	$dlist->SetTemplet(DEDEADMIN."/templets/info_list1.htm");
else
	$dlist->SetTemplet(DEDEADMIN."/templets/info_list.htm");
$dlist->SetSource($sql);
$dlist->display();

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

function Status($status,$id)
{
	//信息状态
	$staArr = array(1=>'安排中', 2=>'试讲中', 3=>'试讲成功', 4=>'已回访', 5=>'坏单', 6=>"待处理");
	$html = "<select class='info_status' name='info_sta' style='width:80px'>";
           
    foreach($staArr as $k=>$v)
    {
         if($status==$v) $html.="<option value='$v' selected>$v</option>\r\n";
         else $html.="<option value='$v'>$v</option>\r\n";
    }

    $html.='</select>';
	return $html;
}
