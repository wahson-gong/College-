<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>申请退款记录</title>
<link href="/cadmin/css/bootstrap.min.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet" type="text/css">
<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script language="javascript" src="js/member.js"></script>
<script src="/cadmin/js/bootstrap.min.js"></script>
<style type="text/css">
.rb{ border-right:1px solid #666666 }
.tb{ border-top:1px solid #666666 }
</style>
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<?php
$user_id = $GLOBALS['cuserLogin']->getUserID();

$User =  $dsql->GetOne("Select usertype from `#@__admin` where id = " . $user_id);
if($User['usertype']==1){
?>
<ul class="nav nav-pills" role="tablist">
  <li role="presentation" ><a href="info_list.php">信息列表</a></li>
  <li role="presentation"><a href="info_add.php">信息增加</a></li>
  <li role="presentation" class="active"><a href="fee_back.php">退款处理</a></li>
  <li role="presentation"><a href="member_main.php">教员信息</a></li>
  <li role="presentation"><a href="exit.php">退出登录</a></li>
</ul>
<?php
}
?>
<!--条件筛选：退款状态：未处理 已退款 不退款；按照城市筛选-->
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6" style="margin-bottom:6px">
  <tr>
    <td height="30" align="center" bgcolor="#F9FCEF"> 
  <form action="fee_back.php" name="form1" method="get" id="condForm">
	  <table border="0" cellspacing="0" cellpadding="3">
      <tr>
      	  <td>关键字：</td>
          <td><input name="keyword" type="text" id="keyword" size="12" style="width:120px" value="<?php echo $GLOBALS['keyword']; ?>" /></td>
           <!-- 状态 -->
           <td>
		      <select name="info_sta" id="info_sta" style="width:150px" onchange="changeCond()">
              <option value=''>--退款状态--</option>
              <?php
           		foreach($staArr as $k=>$v)
           		{
           			if($info_sta==$v) echo "<option value='$v' selected>$v</option>\r\n";
           			else echo "<option value='$v'>$v</option>\r\n";
           		}
           	  ?>
            </select></td>
            <!-- 城市 -->
             <td>
		      <select name="city" id="city" style="width:150px" onchange="changeCond()">
               <option value=''>--城市--</option>
              <?php
           		foreach($cityArr as $k=>$v)
           		{
           			if($city==$v) echo "<option value='$v' selected>$v</option>\r\n";
           			else echo "<option value='$v'>$v</option>\r\n";
           		}
           	  ?>
            </select></td>
            <td><input type="submit" value="搜索"/></td>
        </tr>
      </table>
	  </form>
    </td>
  </tr>
</table>
<!--筛选结果-->
<form name="form2" action="fee_back.php" method="post">
<table class="table table-bordered" width="1200px" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#cfcfcf">
  <tr bgcolor="#FEFCEF" height="30" align="center"> 
    <!-- <td width="2%">选择</td> -->
    <td width="5%">信息编号</td>
    <td width="10%">用户id</td>
    <td width="12%">姓名,学校,年级,专业</td>
    <!--<td width="5%">电话</td>-->
	<td width="4%">信息城市</td>
    <td width="4%">退款额度</td>
    <td width="5%">支付宝账号</td>
    <td width="7%">QQ号</td>
    <td width="15%">退款理由</td>
    <td width="8%">申请时间</td>
    
	<td width="5%">退款状态</td>
    <td width="10%">操作结果说明</td>
    <!--<td>操作</td>-->
  </tr>
<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?> 
<tr height="26" align="center" bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';"
  	 onMouseOut="javascript:this.bgColor='#FFFFFF';"> 
  <!-- <td><input name="mid" type="checkbox" id="mid" value="<?php echo $fields['mid']; ?>" class="np" /></td> -->
  <td><a href="info_view.php?id=<?php echo $fields['mx_mid']; ?>" target="_blank"><?php echo $fields['info_bianhao']; ?></a></td>
  <td><a href="member_view.php?id=<?php echo $fields['user_id']; ?>" target="_blank"><?php echo $fields['user_id']; ?></a></td>
  <td><?php echo $fields['user_name']; ?>,
  <?php echo $fields['school']; ?>,<br/>
  <?php echo $fields['nianji']; ?>,
  <?php echo $fields['zhuanye']; ?></td>
  <!--<td><?php echo $fields['tel']; ?></td>-->
  <td><?php echo $fields['city']; ?></td>
  <td><?php echo $fields['back_fee']; ?></td>
  <td><?php echo $fields['alipay_num']; ?></td>
  <td><?php echo $fields['weixin']; ?></td>
  <td><?php echo $fields['reason']; ?></td>
  <td><?php echo MyDate('y-m-d H:i',$fields['apply_time']); ?></td>

  <td>
  <?php echo Status($fields['deal_status']); ?>
  <input type="hidden" id="<?php echo $fields['mid']; ?>" value="<?php echo $fields['mid']; ?>"/>
  </td>
  <td><textarea id="result<?php echo $fields['mid']; ?>" name="result<?php echo $fields['mid']; ?>"><?php echo $fields['deal_result']; ?></textarea>
  </td>
  
<!-- c操作 -->
<!--
  <td align="center">
     
    
	<a href="javascript:set_status(<?php echo $fields['mid']; ?>,'已退款')">已退款</a> <br/>
	<a href="javascript:set_status(<?php echo $fields['mid']; ?>,'不退款')">不退款</a> <br/>
	<a href="javascript:set_status(<?php echo $fields['mid']; ?>,'未处理')">未处理</a> <br/>
	<a href="fee_back_do.php?id=<?php echo $fields['mid']; ?>&dopost=delinfo">删除</a>
  </td>-->
</tr>
<?php
}
}?> 
<!-- 
<tr bgcolor="#ffffff"> 
 <td height="36" colspan="9">
	&nbsp;
	<a href="javascript:selAll()" class="coolbg">全选</a>
	<a href="javascript:noSelAll()" class="coolbg">取消</a>
	<a href="javascript:delArc(0)" class="coolbg">&nbsp;删除&nbsp;</a>
</td>
</tr>
 -->
<tr bgcolor="#F9FCEF"> 
 <td height="36" colspan="15" align="center">
	<?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

 </td>
</tr>
</table>
</form>
</body>
<script type="text/javascript">
function add_result(id){
	var result = document.getElementById("result"+id).value;
	window.location.href="fee_back.php?id="+id+"&dopost=add_result&result="+result;
}

function set_status(id, status){
	var result = document.getElementById("result"+id).value;
	window.location.href="fee_back.php?id="+id+"&dopost=set_status&status="+status+"&result="+result;
}

function changeCond(){
	document.getElementById("condForm").submit();
}

$(document).ready(function(){
	$(".deal_status").change(function(){
		var status = $(this).children('option:selected').val();
		var mid = $(this).next().val();
		var result = document.getElementById("result"+mid).value;
		$.ajax({
			type:'get',
			url:"fee_back.php",
			data:"dopost=set_status&mid=" + mid + "&status=" + status + "&result="+result,
			dataType : 'text',
			success : function(res){
				alert(res);
			}
	});
	});
});
</script>
</html>