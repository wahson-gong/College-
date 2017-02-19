<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>城市管理</title>
<link href="css/base.css" rel="stylesheet" type="text/css">
<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script language="javascript" src="js/member.js"></script>
<style type="text/css">
.rb{ border-right:1px solid #666666 }
.tb{ border-top:1px solid #666666 }
</style>
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<form name="form2">
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="1" bgcolor="#cfcfcf">
  <tr bgcolor="#FEFCEF" height="30" align="center"> 
    <!-- <td width="2%">选择</td> -->
    <!--<td width="3%">mid</td>-->
    <td width="10%">编号</td>
    <td width="20%">城市名称</td>
	<td width="30%">城市代码</td>
    <td width="10%">城市前缀数字</td>
    <td width="10%">查看接单页面</td>
    <td width="20%">操作</td>
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
  
  <td><?php echo $fields['mid']; ?></td>
  <td><?php echo $fields['city_name']; ?></td>
  <td><?php echo $fields['city_code']; ?></td>
  <td><?php echo $fields['city_pre']; ?></td>
  <td><a href="../info_index.php?city_code=<?php echo $fields['city_code']; ?>" target="_blank"><?php echo $fields['city_name']; ?></a></td>
  <td align="center">
    <a href="city_view.php?id=<?php echo $fields['mid']; ?>">编辑</a>|<br/> 
    <a href="city_do.php?id=<?php echo $fields['mid']; ?>&dopost=delinfo">删除</a>|<br/> 
  </td>
</tr>

<?php
}
}?>
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
</html>