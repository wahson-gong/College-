<?php
	
header("Content-Type:text/html;charset=GB2312");
error_reporting(0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
<TITLE>ͼƬ�ϴ�</TITLE>
<META http-equiv=Content-Type content="text/html; charset=gb2312">
<META content="MSHTML 6.00.3790.4275" name=GENERATOR>
<style type="text/css">
<!--
input{border-width:1px;border:1px solid #ccc;padding:3px 0 3px 5px;border-radius:15px;}
.inputbut{padding-left:10px;padding-right:10px;border:1px solid #ccc;border-radius:15px;background-color: #5181D5;background: url(../images/inputbut_bg.gif) left center repeat-x;font-size:14px;height:30px;}
-->
</style>
</HEAD>
<BODY leftmargin=0 topmargin=0 style="font-size:12px">
<?php

$id=$_GET["id"];

//echo "id==".$id;
switch($_GET["action"])
{
case "up":
 upmovie($id);
 break;
default:
 upinput($id);
 break;
}

function upinput($id){
?>
<SCRIPT language=javascript>
function check() 
{
 var strFileName=document.form.strPhoto.value;
 if (strFileName=="")
 {
     alert("��ѡ��Ҫ�ϴ����ļ�");
  document.form.strPhoto.focus();
     return false;
   }
 return true;
}
</SCRIPT>
<form action="uppic.php?action=up&id=<?php echo $id;?>" enctype="multipart/form-data" name="form" method="post" onSubmit="if (!check()) return false;">
<input name="strPhoto" type="file" id="strPhoto" size="40">
<input type="submit" name="Submit" value="�� ��" class=inputbut />
</form>
</BODY>
<?php
}

function upmovie($id){
 global $web_picdir;
 $savePath="../uploads/lszj/".$web_picdir;

 $str = date('YmdHis');
 if($_FILES['strPhoto']['name']!='')
 {
   $tmp_file=$_FILES['strPhoto']['tmp_name'];
   $file_types=explode(".",$_FILES['strPhoto']['name']);
   $file_type=$file_types[count($file_types)-1];
   if(strtolower($file_type)!="jpg"&strtolower($file_type)!="gif"&strtolower($file_type)!="bmp"&strtolower($file_type)!="png"){
      echo "<span>��ʽ�����������ϴ�<a href=# onclick=history.go(-2);>[����]</a></span>";
      exit;
   }
   $file_name= $web_picdir.$str.".".$file_type;
  
   if(!copy($tmp_file,$savePath.$file_name)){
    echo "<span >�ϴ����������ԣ���<a href=# onclick=history.go(-2);>[����]</a></span>";
   }else{
   	
	 echo "<script> alert('ͼƬ�Ѿ��ϴ��ɹ�');</script>";
    echo "<script>parent.document.getElementById('{$id}').value='/uploads/lszj/".$file_name."'</script>";
	echo "<br/>";
	echo "<img src='../uploads/lszj/".$file_name."' width='200' height='120'/>";
	echo "<br/>";
    echo "<a href=# onclick=history.go(-2);>����Ҫ�޸�,�������ϴ�</a>";
   }
 }else{
  echo "<span >��ѡ����Ҫ�ϴ����ļ�<a href=# onclick=history.go(-2);>[����]</a></span>";
 }
}


?>
