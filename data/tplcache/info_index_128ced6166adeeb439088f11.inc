<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>学员信息管理</title>

<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
<link href="./templets/default/css/base.css" rel="stylesheet" type="text/css">
<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<script language="javascript" src="js/member.js"></script>
<style type="text/css">
.rb{ border-right:1px solid #666666 }
.tb{ border-top:1px solid #666666 }
</style>
</head>
<body background='images/allbg.gif' leftmargin='8' topmargin='8' style="font-family='微软雅黑'">
<!-- 头部nav -->
<?php include $this->CompilerInclude("header_nav.htm");
 ?>
<!-- 头部nav -->
<!--  去掉头部的大图
<div class="header" style="background-image: url(http://static.bootcss.com/expo/img/d/dd/2de797545de56274f03a5920eb3a1.jpg)">
  <div class="logoimg">
    <a href="" title="Bootstrap 优站精选"><img src="" alt="Bootstrap 优站精选" width="78"></a>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
      <div class="logotxt"><h1><a href="info_index.php">College家教</a></h1></div> 
      <h2 class="site-name text-center">信息精选<span>www.cjiajiao.com</span></h2>

    </div>
  </div>

</div>
</div>
-->
<div class="container" style="margin-top:70px">
	<?php $i = 0;
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
 $i++;?>
		<div class="col-xs-12 col-md-4 col-sm-6" style="float:left;<?php if($i%3==1) echo 'clear:both;';?>">
			<div class="thumbnail" >
      			<div class="caption">
        			<h3 style="text-align:center;color:#2586fa">编号：<?php echo $fields['bianhao']; ?></h3>
        			<p style="padding-bottom:20px;font-size:15px;"><?php echo $fields['requirement']; ?></p>
        			<p style="border-bottom:1px solid #eee;padding-bottom:20px;font-size:10px;text-align:left">
        			<span class="label label-default">地点</span>&nbsp;&nbsp;<?php echo $fields['bus_stop']; ?>&nbsp;&nbsp;
        			</p>
        			<p style="padding-bottom:20px;font-size:12px;"><span class="label label-default">要求</span>&nbsp;&nbsp;<?php echo $fields['info_cond']; ?></p>
        			<p style="padding-bottom:20px;font-size:12px;"><span class="label label-default">信息费</span>&nbsp;&nbsp;<?php echo $fields['info_fee']; ?></p>
        			
        			<p style="text-align:center">
        			<a class="btn btn-lg btn-default btn-getting-started" href="javascript:alert('预约请联系客服QQ:'+<?php echo $qq;?>)" role="button">预约</a></p>
      			</div>
    		</div>
		</div>
		<?php
}
}?>

</div>

<tr bgcolor="#F9FCEF"> 
 <td height="36" colspan="9" align="center">
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
<!-- 头部nav -->
<?php include $this->CompilerInclude("footer.htm");
 ?>
<!-- 头部nav -->
</body>
</html>