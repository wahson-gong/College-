<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
 
	if($show_mode == 'table'){
		//echo "table";
		echo '';
	}else{
		//echo "text";
		echo '';
	}
	?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>学员信息管理</title>
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
<ul class="nav nav-pills" role="tablist">
  <li role="presentation" class="active"><a href="info_list.php">信息列表</a></li>
  <li role="presentation"><a href="info_add.php">信息增加</a></li>
  <li role="presentation"><a href="fee_back.php">退款处理</a></li>
  <li role="presentation"><a href="member_main.php">教员信息</a></li>
  <li role="presentation"><a href="exit.php">退出登录</a></li>
</ul>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6" style="margin-bottom:6px">
  <tr>
    <td height="30" align="center" bgcolor="#F9FCEF"> 
  <form action="info_list.php" name="form1" method="get" id="condForm">
	  <table border="0" cellspacing="0" cellpadding="3">
      <tr>
          <td>关键字：</td>
          <td><input name="keyword" type="text" id="keyword" size="12" style="width:120px" value="<?php echo $GLOBALS['keyword']; ?>" /></td>
          <!--<td>&nbsp;排序：</td>
		  
          <td>
		        <select name="sortkey" id="sortkey" style="width:120px" onchange="changeCond()">
              <?php echo $GLOBALS['sort_form']; ?>
			  <option value="mid">mid/创建时间</option>
              <option value="try_time">试讲时间</option>
              <option value="huifang_time">回访时间</option>
            </select>
          </td>-->
           <!-- 状态 -->
		   <!--
           <td>
		      <select name="info_sta" id="info_sta" style="width:150px" onchange="changeCond()">
              <option value=''>--需求状态--</option>
              <?php
           		/*foreach($staArr as $k=>$v)
           		{
           			if($info_sta==$v) echo "<option value='$v' selected>$v</option>\r\n";
           			else echo "<option value='$v'>$v</option>\r\n";
           		}*/
           	  ?>
            </select></td>-->
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
          <!-- 来源 -->
		  <!--
          <td>
          	<select name="info_from" id="info_from" style="width:100px" onchange="changeCond()">
               <option value=''>--信息来源--</option>
               <?php
           		/*foreach($InfoSourceModel as $k=>$v)
           		{
           			if($info_from==$v) echo "<option value='$v' selected>$v</option>\r\n";
           			else echo "<option value='$v'>$v</option>\r\n";
           		}*/
           	   ?>
             </select>
          </td>-->
          <!-- 显示方式 -->
          <td>
		  <?php echo $show_mode;?>
          	<select name="show_mode" id="show_mode" style="width:100px" onchange="changeCond()">
               <option value="table" <?php if($show_mode=='table') echo 'selected';?>>表格</option>
              <option value="text" <?php if($show_mode=='text') echo 'selected';?>>复制</option>
             </select>
          </td>
         
         <td>
           <input name="imageField" class="np" type="image" src="images/button_search.gif" width="60" height="22" border="0" />
          </td>
        </tr>
      </table>
	  </form>
    </td>
  </tr>
</table>
<form name="form2">
<table class="table table-bordered" width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#cfcfcf">
  <tr> 
  <td height="28" colspan="16" background="images/tbg.gif">
   <table width="99%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td width="29%" style="padding-left:10px;"><strong>学员信息列表</strong></td>
     </tr>
  </table>
 </td>
</tr>
  <tr bgcolor="#FEFCEF" height="30" align="center"> 
    <!-- <td width="2%">选择</td> -->
    <!--<td width="3%">mid</td>-->
    <td width="5%">编号</td>
    <td width="6%">创建日期</td>
	<td width="5%">城市</td>
    <td width="34%">信息</td>
    <td width="14%">联系方式</td>
    <td width="5%">信息费</td>
    <td width="5%">状态</td>
    
  </tr>
<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
 
	if($show_mode == 'table'){
?>
<tr height="26" align="center" bgcolor="#FFFFFF" onMouseMove="javascript:this.bgColor='#FCFDEE';"
  	 onMouseOut="javascript:this.bgColor='#FFFFFF';"> 
  <!-- <td><input name="mid" type="checkbox" id="mid" value="<?php echo $fields['mid']; ?>" class="np" /></td> -->
  <!--<td><?php echo $fields['mid']; ?></td>-->
  <td><?php echo $fields['bianhao']; ?></td>
  <td><?php echo MyDate('y-m-d H:i',$fields['createtime']); ?></td>
  <td><?php echo $fields['city']; ?></td>
  <td style="text-align:left"><span style="color:red">信息:</span><?php echo $fields['requirement']; ?>
  <br/><span style="color:red">站点:</span><?php echo $fields['bus_stop']; ?>
  <br/><span style="color:red">要求:</span><?php echo $fields['info_cond']; ?></td>
  <td><?php echo $fields['contact_name1']; ?>:<?php echo $fields['tel1']; ?><br/>
	<?php if($fields['contact_name2']!=""){  echo $fields['contact_name2']; ?>:<?php echo $fields['tel2'];  } ?>
  </td>
  <td><?php echo $fields['info_fee']; ?></td>
  <!-- 状态 -->
  <td>
	<?php echo Status($fields['status']); ?>
	<input type="hidden" id="<?php echo $fields['mid']; ?>" value="<?php echo $fields['mid']; ?>"/>
  </td>
</tr>
<?php }else{
?>
<p>
编号:<?php echo $fields['bianhao']; ?><br/>
信息:<?php echo $fields['requirement']; ?><br/>
地点:<?php echo $fields['bus_stop']; ?><br/>
要求:<?php echo $fields['info_cond']; ?><br/>
信息费:<?php echo $fields['info_fee']; ?><br/>
</p>
<?php
}

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
 <td height="36" colspan="16" align="center">
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
function changeCond(){
	document.getElementById('condForm').submit();
}
//更新一些字段
function update_field(id, field){
	var value = document.getElementById(field + "_" + id).value;
	$.ajax({
		type:'get',
		url:"info_do.php",
		data:"mid=" + id + "&value=" + value + "&field="+field,
		dataType : 'text',
		success : function(){
		}
	});
}
//直接修改状态
function change_status(id){
	 
}
$(document).ready(function(){
	$(".info_status").change(function(){
		var status = $(this).children('option:selected').val();
		var mid = $(this).next().val();
		$.ajax({
			type:'get',
			url:"info_do.php",
			data:"act=change_status&mid=" + mid + "&status=" + status,
			dataType : 'text',
			success : function(res){
				alert(res);
			}
	});
	});
});
</script>
</html>