<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<title>��վ��Ա����</title>
<link href="/cadmin/css/bootstrap.min.css" rel="stylesheet">
<link href="css/base.css" rel="stylesheet" type="text/css">
<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>
<script language="javascript" src="js/member.js"></script>
<script language="javascript" src="js/list.js"></script>
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
  <li role="presentation" ><a href="info_list.php">��Ϣ�б�</a></li>
  <li role="presentation"><a href="info_add.php">��Ϣ����</a></li>
  <li role="presentation"><a href="fee_back.php">�˿��</a></li>
  <li role="presentation" class="active"><a href="member_main.php">��Ա��Ϣ</a></li>
  <li role="presentation"><a href="exit.php">�˳���¼</a></li>
</ul>
<?php
}
?>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6" style="margin-bottom:6px">
  <tr>
    <td height="30" align="center" bgcolor="#F9FCEF"> 
  <form action="member_main.php" name="form1" id="form1" method="get">
	  <table border="0" cellspacing="0" cellpadding="3">
      <tr>
	  <!--
          <td>�ؼ��֣�</td>
          <td><input name="keyword" type="text" id="keyword" size="12" style="width:120px" value="<?php echo $GLOBALS['keyword']; ?>" /></td>-->
          <td>&nbsp;����</td>
		  <!--
          <td>
		        <select name="sortkey" id="sortkey" style="width:120px" onchange="changeCond()">
              <?php echo $GLOBALS['sortform']; ?>
				      <option value="mid">mid/ע��ʱ��</option>
              <option value="logintime">��¼ʱ��</option>
              <option value="rank">��Ա�ȼ�</option>
              <option value="money">��Ա���</option>
              <option value="scores">��Ա����</option>
            </select>
          </td>-->
          <td>
		         <select name="sex" id="sex" style="width:60px" onchange="changeCond()">
               <?php echo $GLOBALS['sexform']; ?>
               <option value="��">��</option>
               <option value="Ů">Ů</option>
               <option value="����">����</option>
             </select>
          </td>
		  <!--
          <td>
          	<select name="mtype" id="mtype" style="width:60px" onchange="changeCond()">
               <?php echo $GLOBALS['mtypeform']; 
           		//foreach($MemberModels as $row)
           		//{
           		//	echo "<option value=".$row['name'].">".$row['name']."</option>\r\n";
           		//}
           	   ?>
             </select>
          </td>-->
          <td>
		      <select name="spacesta" id="spacesta" style="width:150px" onchange="changeCond()">
              <option value='-10'>--��Ա״̬--</option>
              <?php
           		foreach($staArr as $k=>$v)
           		{
           			if($spacesta==$k) echo "<option value='$k' selected>$v</option>\r\n";
           			else echo "<option value='$k'>$v</option>\r\n";
           		}
           	  ?>
            </select></td>
         <td>
		 <!-- ���� -->
             <td>
		      <select name="city" id="city" style="width:150px" onchange="changeCond()">
               <option value=''>--����--</option>
              <?php
           		foreach($cityArr as $k=>$v)
           		{
           			if($city==$v) echo "<option value='$v' selected>$v</option>\r\n";
           			else echo "<option value='$v'>$v</option>\r\n";
           		}
           	  ?>
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
  <td height="28" colspan="14" background="images/tbg.gif">
   <table width="99%" border="0" cellspacing="0" cellpadding="0">
     <tr>
       <td width="29%" style="padding-left:10px;"><strong>ע���Ա�б�</strong></td>
       <td width="71%" align="right">
          <a href="member_main.php">���л�Ա</a> |
          <a href="member_main.php?spacesta=-2">�������û�</a> |
          <a href="member_main.php?matt=1">���Ƽ�</a> |
          <a href="member_main.php?matt=0">��ͨ</a> &nbsp;
       </td>
     </tr>
  </table>
 </td>
</tr>
  <tr bgcolor="#FEFCEF" height="30" align="center"> 
    <td width="3%">ѡ��</td>
    <td width="5%">mid</td>
	<td width="5%">����</td>
   <!-- <td width="8%">��¼��</td>-->
    <td width="5%">����</td>
    <td width="5%">�Ա�</td>
	<td width="8%">ѧУ</td>
	<td width="5%">�꼶</td>
	<td width="5%">רҵ</td>
	<td width="8%">qq</td>
	<td width="20%">���</td>
	<td width="5%">չʾ˳��</td>
    <td width="10%">��Ա״̬</td>
    <!--<td width="10%">��Ա����</td>-->
    <td>����</td>
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
  <td><input name="mid" type="checkbox" id="mid" value="<?php echo $fields['mid']; ?>" class="np" /></td>
  <td><?php echo $fields['mid']; ?></td>
  <td><?php echo $fields['city']; ?></td>
  <!--
  <td>
    <?php
	  echo '<u>'.$fields['userid'].'</u>';
	if($fields['spacesta']==-2) echo "<font color='red'>(����)</font>";
	if($fields['spacesta']==-1) echo "<font color='red'>(δ���)</font>";
	  if(!empty($fields['face'])) {
       echo "<br /><img src='{$fields['face']}' width='60' alt='�����Ա�ռ�' />";
	  }
	?>
  </td>-->
	<td>
	  <!--<?php echo $fields['email']; ?>-->
	  
	  <?php echo $fields['uname']; ?>
	</td>
    <td>
  	<?php echo $fields['sex']; ?>
  </td>
  	<td><?php echo $fields['school']; ?></td>
	<td><?php echo $fields['nianji']; ?></td>
	<td><?php echo $fields['zhuanye']; ?></td>
	<td><?php echo $fields['qq']; ?></td>
	<td><?php echo $fields['introduction']; ?></td>
	<td>
  	 <input value="<?php echo $fields['shunxu']; ?>" size="5" id="shunxu<?php echo $fields['mid']; ?>"/><br/>
  	 <button type="button" value="" onclick="updateShunxu(<?php echo $fields['mid']; ?>)">����˳��</button>
  </td>
  <!--  
  <td>
  <?php echo Status($fields['spacesta']); ?>
  <input type="hidden" id="<?php echo $fields['mid']; ?>" value="<?php echo $fields['mid']; ?>"/>
    
  </td>
  -->
  <!--
  <td>
  	<?php echo $fields['mtype']; ?>�û� <?php echo GetMAtt($fields['matt']); ?>
  	<br />
  	��ң�<?php echo $fields['money']; ?> ���֣�<?php echo $fields['scores']; ?>
  </td>-->
  <td align="center">
    <a href="member_view.php?id=<?php echo $fields['mid']; ?>">�鿴��������</a> |
	<?php if($fields['aid']!=""){ ?>
	<a href="javascript:void" onclick="editArc(<?php echo $fields['aid']; ?>)">�鿴��ϸ����</a> |
	<?php } ?>	
	<a href="member_view_table.php?id=<?php echo $fields['mid']; ?>" target="_blank">�鿴����</a>
    <!--<a href="content_list.php?mid=<?php echo $fields['mid']; ?>" target="_blank">�����ϸ����</a> |-->
    <!--<a href="member_toadmin.php?id=<?php echo $fields['mid']; ?>" target="_self">����</a>-->
  </td>
</tr>
<?php
}
}?> 
<!-- 
<tr bgcolor="#ffffff"> 
 <td height="36" colspan="14">
	&nbsp;
	<a href="javascript:selAll()" class="coolbg">ȫѡ</a>
	<a href="javascript:noSelAll()" class="coolbg">ȡ��</a>
	<a href="javascript:delArc(0)" class="coolbg">&nbsp;ɾ��&nbsp;</a>
 ������Ѿ���������̳���û��벻Ҫʹ������ɾ�����ܣ�</td>
</tr>
 -->
<tr bgcolor="#F9FCEF"> 
 <td height="36" colspan="14" align="center">
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
	document.getElementById('form1').submit();
}

$(document).ready(function(){
	$(".spacesta").change(function(){
		var status = $(this).children('option:selected').val();
		var mid = $(this).next().val();
		$.ajax({
			type:'get',
			url:"member_main.php",
			data:"dopost=set_status&mid=" + mid + "&status=" + status,
			dataType : 'text',
			success : function(res){
				alert(res);
			}
	});
	});
});

function updateShunxu(mid){
	var shunxu = document.getElementById('shunxu'+mid).value;
	if(shunxu==''){
		alert('˳��Ϊ�գ�');
		return false;
	}
	$.ajax({
		type:'get',
		url:"member_main.php",
		data:"dopost=set_shunxu&mid=" + mid + "&shunxu=" + shunxu,
		dataType : 'text',
		success : function(res){
			alert(res);
		}
});
}
</script>
</html>