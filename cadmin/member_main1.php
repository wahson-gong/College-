<?php
/**
 * ��Ա����
 *
 * @version        $Id: member_main.php 1 10:49 2010��7��20��Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
//CheckPurview('member_List');
require_once(DEDEINC."/datalistcp.class.php");
setcookie("ENV_GOBACK_URL",$dedeNowurl,time()+3600,"/");

if(empty($dopost)) $dopost = '';

if($dopost == 'set_status'){
    $id = intval($_GET['mid']);
    $status = trim($_GET['status']);
    if($status===''){
        echo '����ʧ��';
        exit;
    }
    $record = $dsql->getOne("SELECT * FROM `#@__member` WHERE mid = " . $id);
    if(!empty($record)){
        $query = "UPDATE `#@__member` SET spacesta = " . $status . " where mid = " .$id;        
        $rs = $dsql->ExecuteNoneQuery2($query);
        echo '����״̬�ɹ�';
        exit;
    }   
}else if($dopost=='set_shunxu'){
    $id = intval($_GET['mid']);
    $shunxu = trim($_GET['shunxu']);
    if($shunxu===''){
        echo '����ʧ��';
        exit;
    }
    $record = $dsql->getOne("SELECT * FROM `#@__member` WHERE mid = " . $id);
    if(!empty($record)){
        $query = "UPDATE `#@__member` SET shunxu = " . $shunxu . " where mid = " .$id;      
        $rs = $dsql->ExecuteNoneQuery2($query);

        echo '����״̬�ɹ�';
        exit;
    }   
}

if(!isset($sex)) $sex = '';
if(!isset($mtype)) $mtype = '';//��Ա����
if(!isset($spacesta)) $spacesta = -10;//��Ա״̬
if(!isset($matt)) $matt = 10;
if(!isset($city)) $city = '';//����



if(!isset($keyword)) $keyword = '';
else $keyword = trim(FilterSearch($keyword));

$mtypeform = empty($mtype) ? "<option value=''>����</option>\r\n" : "<option value='$mtype'>$mtype</option>\r\n";
$sexform = empty($sex) ? "<option value=''>�Ա�</option>\r\n" : "<option value='$sex'>$sex</option>\r\n";
$sortkey = empty($sortkey) ? 'm.mid' : preg_replace("#[^a-z]#i",'',$sortkey);

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
//����ǳ��й���Ա��matt=0������������Ա��Ϣ��ֻ����Ա��Ϣ
if($User['usertype']==1){
    $matt = 0;
}

//$staArr = array(-2=>'�����û�(����)', -1=>'δͨ�����', 0=>'ע���Ա', 1=>'û��д��ϸ����', 2=>'����ʹ��״̬');
$staArr = array( 0=>'ע���Ա', 1=>'��˽�Ա', 2=>'�Ƽ���Ա', 3=>'���ǽ�Ա');
$staArrmatt = array(1=>'���Ƽ�', 0=>'����ͨ ' );
$MemberTypes = array();
$dsql->SetQuery("Select rank,membername From `#@__arcrank` where rank>0 ");
$dsql->Execute();
while($row = $dsql->GetObject())
{
    $MemberTypes[$row->rank] = $row->membername;
}

if($sortkey=='m.mid')
{
    $sortform = "<option value='mid'>mid/ע��ʱ��</option>\r\n";
}
else if($sortkey=='rank')
{
    $sortform = "<option value='rank'>��Ա�ȼ�</option>\r\n";
}
else if($sortkey=='money')
{
    $sortform = "<option value='money'>��Ա���</option>\r\n";
}
else if($sortkey=='scores')
{
    $sortform = "<option value='scores'>��Ա����</option>\r\n";
}
else
{
    $sortform = "<option value='logintime'>��¼ʱ��</option>\r\n";
}
if($keyword!='')
    $wheres[] = " (m.userid LIKE '%$keyword%' OR m.uname LIKE '%$keyword%' OR m.email LIKE '%$keyword%' OR m.qq LIKE '%$keyword%' OR mobile LIKE '%$keyword%' OR m.mid=$keyword) ";

if($sex   != '')
{
    if($sex == '��' || $sex=='Ů')
        $wheres[] = " sex LIKE '$sex' ";
}

if($mtype != '')
{
    $wheres[] = " mtype LIKE '$mtype' ";
}

if($spacesta != -10)
{
    $wheres[] = " spacesta = '$spacesta' ";
}

if($matt != 10)
{
    $wheres[] = " matt= '$matt' ";
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

$whereSql = join(' AND ',$wheres);

if($whereSql!='')
{
    $whereSql = ' WHERE '.$whereSql;
}
$dsql->SetQuery("SELECT name FROM `#@__member_model`");
$dsql->Execute();
while($row = $dsql->GetArray())
{
    $MemberModels[] = $row;
}

$sql  = "SELECT m.*,a.id as aid FROM `#@__member` as m left join `#@__archives` as a on m.mid = a.mid $whereSql ORDER BY m.shunxu asc";

$dlist = new DataListCP();//��ҳ��
$dlist->SetParameter('sex',$sex);
$dlist->SetParameter('spacesta',$spacesta);
$dlist->SetParameter('matt',$matt);
$dlist->SetParameter('mtype',$mtype);
$dlist->SetParameter('sortkey',$sortkey);
$dlist->SetParameter('keyword',$keyword);
$dlist->SetParameter('city',$city);

if(!empty($User)&&$User['usertype']<10)
    $dlist->SetTemplet(DEDEADMIN."/templets/member_main1.htm");
else
    $dlist->SetTemplet(DEDEADMIN."/templets/member_main.htm");
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

//��Ա״̬
function Status($status)
{
    //��Ա״̬
    $spaceSta = array(0=>'ע���Ա', 1=>'��˽�Ա', 2=>'�Ƽ���Ա',3=>'���ǽ�Ա');
    $html = "<select class='spacesta' name='spacesta' style='width:80px'>";
           
    foreach($spaceSta as $k=>$v)
    {
         if($status==$k) $html.="<option value='$k' selected>$v</option>\r\n";
         else $html.="<option value='$k'>$v</option>\r\n";
    }

    $html.='</select>';
    return $html;
}