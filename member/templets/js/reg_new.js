<!--
$(document).ready(function()
{
	//�û�����
	if($('.usermtype2').attr("checked")==true) $('#uwname').text('��˾���ƣ�'); 
	$('.usermtype').click(function()
	{
		$('#uwname').text('�û�������');
	});
	$('.usermtype2').click(function()
	{
		$('#uwname').text('��˾���ƣ�');
	});
	//checkSubmit
	$('#regUser').submit(function ()
	{
		if($('#txtUsername').val()==""){
			$('#txtUsername').focus();
			alert("�û�������Ϊ�գ�");
			return false;
		}
		
		if($('#mob').val()==""){
			$('#mob').focus();
			alert("�ֻ����벻��Ϊ�գ�");
			return false;
		}
		
		if($('#mob').val().length!=11){
			$('#mob').focus();
			alert("������д��ȷ���ֻ����룡");
			return false;
		}
		
		
		
		
		 var re = /^1\d{10}$/
    if (re.test($('#mob').val())) {
        //alert("��ȷ");
    } else {
        $('#mob').focus();
			alert("������д��ȷ���ֻ����룡");
			return false;
    }
		
		
		
		if($('#txtPassword').val()=="")
		{
			$('#txtPassword').focus();
			alert("��½���벻��Ϊ�գ�");
			return false;
		}
		if($('#userpwdok').val()!=$('#txtPassword').val())
		{
			$('#userpwdok').focus();
			alert("�������벻һ�£�");
			return false;
		}
		if($('#uname').val()=="")
		{
			$('#uname').focus();
			alert("��ʵ��������Ϊ�գ�");
			return false;
		}
		if($('#school').val()=="")
		{
			$('#school').focus();
			alert("ѧУ����Ϊ�գ�");
			return false;
		}
		if($('#zhuanye').val()=="")
		{
			$('#zhuanye').focus();
			alert("רҵ����Ϊ�գ�");
			return false;
		}
		if($('#nianji').val()=="")
		{
			$('#nianji').focus();
			alert("�꼶����Ϊ�գ�");
			return false;
		}
		if($('#qq').val()=="")
		{
			$('#qq').focus();
			alert("qq����Ϊ�գ�");
			return false;
		}
		if($('#uname').val()=="")
		{
			$('#uname').focus();
			alert("�û��ǳƲ���Ϊ�գ�");
			return false;
		}
		if($('#vdcode').val()=="")
		{
			$('#vdcode').focus();
			alert("��֤�벻��Ϊ�գ�");
			return false;
		}
		alert('ע��ɹ����뾡��ǰ�������������Ƹ������ϣ��Ի��չʾ��');
	})
	
	//AJAX changChickValue
	$("#txtUsername").change( function() {
		$.ajax({type: reMethod,url: "index_do.php",
		data: "dopost=checkuser&fmdo=user&cktype=1&uid="+$("#txtUsername").val(),
		dataType: 'html',
		success: function(result){$("#_userid").html(result);}}); 
	});
	
	/*
	$("#uname").change( function() {
		$.ajax({type: reMethod,url: "index_do.php",
		data: "dopost=checkuser&fmdo=user&cktype=0&uid="+$("#uname").val(),
		dataType: 'html',
		success: function(result){$("#_uname").html(result);}}); 
	});
	*/

	//$("#email").change( function() {
	//	var sEmail = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
	//	if(!sEmail.exec($("#email").val()))
	//	{
	//		$('#_email').html("<font color='red'><b>��Email��ʽ����ȷ</b></font>");
	//		$('#email').focus();
	//	}else{
	//		$.ajax({type: reMethod,url: "index_do.php",
	//		data: "dopost=checkmail&fmdo=user&email="+$("#email").val(),
	//		dataType: 'html',
	//		success: function(result){$("#_email").html(result);}}); 
	//	}
	//});	
	//
	$('#txtPassword').change( function(){
		if($('#txtPassword').val().length < pwdmin)
		{
			$('#_userpwdok').html("<font color='red'><b>�����벻��С��"+pwdmin+"λ</b></font>");
		}
		else if($('#userpwdok').val()!=$('txtPassword').val())
		{
			$('#_userpwdok').html("<font color='red'><b>�������������벻һ��</b></font>");
		}
		else if($('#userpwdok').val().length < pwdmin)
		{
			$('#_userpwdok').html("<font color='red'><b>�����벻��С��"+pwdmin+"λ</b></font>");
		}
		else
		{
			$('#_userpwdok').html("<font color='#4E7504'><b>����д��ȷ</b></font>");
		}
	});
	
	$('#userpwdok').change( function(){
		if($('#txtPassword').val().length < pwdmin)
		{
			$('#_userpwdok').html("<font color='red'><b>�����벻��С��"+pwdmin+"λ</b></font>");
		}
		else if($('#userpwdok').val()=='')
		{
			$('#_userpwdok').html("<b>����дȷ������</b>");
		}
		else if($('#userpwdok').val()!=$('#txtPassword').val())
		{
			$('#_userpwdok').html("<font color='red'><b>�������������벻һ��</b></font>");
		}
		else
		{
			$('#_userpwdok').html("<font color='#4E7504'><b>����д��ȷ</b></font>");
		}
	});
	
	$("a[href*='#vdcode'],#vdimgck").bind("click", function(){
		$("#vdimgck").attr("src","../include/vdimgck.php?tag="+Math.random());
		return false;
	});
});
-->