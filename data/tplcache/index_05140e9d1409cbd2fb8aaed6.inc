<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>��Ա���� -<?php echo $cfg_webname; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>" />
<link href="templets/style/index.css" rel="stylesheet" type="text/css" />
<link href="templets/style/boxy.css" rel="stylesheet" type="text/css" />

<link href="templets/style/div.css" rel="stylesheet" type="text/css" />
<link href="templets/style/IN365hls2.9.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="templets/style/header2_9.css">

<link href="css/base.css" rel="stylesheet" type="text/css">
<!-- �� Bootstrap ���� CSS �ļ� -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- ��ѡ��Bootstrap�����ļ���һ�㲻�����룩 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- jQuery�ļ��������bootstrap.min.js ֮ǰ���� -->
<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

<!-- ���µ� Bootstrap ���� JavaScript �ļ� -->
<script src="http://cdn.bootcss.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript" src="templets/js/j.js"></script>
<script type="text/javascript" src="templets/js/jquery.boxy.js"></script>
<script type="text/javascript" src="templets/js/load_index.js"></script>
<script type="text/javascript" src="templets/js/leftmenu.js"></script>
<script type="text/javascript" src="templets/js/face.js"></script>
<script type="text/javascript" src="templets/js/Dialog.js"></script>
<script type="text/javascript" src="templets/js/jquery.js"></script>
<script type="text/javascript" src="templets/js/feed.js"></script>
<script language='javascript'>
	function msgSubmit(form) {
		//var id=form.id.value;
		var content = form.share_textarea.value;
		if( content == '��,˵��ɶ��...' ) content = '';
		if ( content == '' ) {
			alert('����������'); return false;
		}
		$.ajax({
			type:'POST',
			url:'index_do.php?fmdo=moodmsg&dopost=sendmsg',
			cache:false,
			data:'&content='+encodeURIComponent(content),
			dataType:'json',
			success:function(message){
				if ( message.type == 'success' ) {
					$('#share_textarea').val('');
					$('#moodcontent').html(message.data);
				} else {
					alert(message.data);
				}
			}
		});
	}
</script>

</head>



<body style="position:relative">
<?php include $this->CompilerInclude("header_nav.htm");
 ?>
<div id="main container" style="min-height:900px">
<div class="row">
	<div class="col-lg-8 col-lg-offset-2" style="margin-top:70px">
		<ul class="nav nav-pills">
  			<li role="presentation" class="active"><a href="../member/index.php">��������</a></li>
 			<li role="presentation"><a href="../member/edit_baseinfo.php">�ʺż�����</a></li>
  			<li role="presentation"><a href="../member/ac_record.php">�ӵ���¼</a></li>
  			<li role="presentation"><a href="../member/try_feed_back.php">�Խ���¼</a></li>
 			<li role="presentation"><a href="../member/fee_back.php">�˿�����</a></li>
  			<!--<li role="presentation"><a href="../member/archives_edit.php?channelid=6&aid=<?php echo $sid ?>">�޸Ľ�ʦ����</a></li>-->
  			<li role="presentation"><a href="../member/index_do.php?fmdo=login&dopost=exit#">�˳���¼</a></li>
		</ul>
	</div>
	<div class="col-lg-8 col-lg-offset-2 col" style="margin-top:50px">
		       <dl class="sns-avatar">
        <dt>
          <div class="s120"> <a href="<?php echo $cfg_cmsurl;?>/member/index.php?uid=<?php echo $cfg_ml->M_LoginID; ?>"><img src="<?php echo $cfg_ml->fields['face']; ?>" width="100" height="100" alt="��������"/></a> </div>
        </dt>
        <dd class="av-index">
          <ul>
            <li class="name"><?php echo $cfg_ml->fields['uname']; ?><span><?php echo $cfg_ml->M_MbType; ?>�û�</span></li>
           
           <li class="name">��Ա��ţ�<?php echo $cfg_ml->M_ID; ?></li>
          </ul>
          <div class="msg">
          
                        
      		
        
          
          <?php 
          
           $zt=$cfg_ml->fields['spacesta'];

           if($zt==-10)
           {
           	 echo $cfg_ml->M_LoginID."���Ļ���������������У������Ժ�鿴";
           }
           if($zt==0||$zt==1)
           {
           	
             echo "�����ͨ������";
             
              $uname=$cfg_ml->fields['uname'];

            $sql="Select * From `dede_archives` where title='".$uname."' "; 

           
            $row = $GLOBALS[dsql]->GetOne($sql); 
            
            $description=$row[title]; 
           

            if($description==$uname)
            {
           	 ?>
                  <a href='/member/archives_edit.php?channelid=6&aid=<?php echo $row["id"];?>'><font color="#FF0000">�޸ĸ�������</font></a>
             <?php
            }else{
            		
                    ?>
                     <a href='/member/archives_add.php?channelid=6'><font color="#FF0000">���Ƹ�������</font></a>
                    <?php
            }
            
             
           }
           
           ?>
           
           
          <div style=" height:40px;">
         <!-- <p>����Ϣ: <em> <a href="pm.php?TB_iframe=true&height=600&width=700" title="�ҵĶ���Ϣ" target="_blank"> <?php echo $pms['nums'];?></a> </em> ����: <em> <a href="caicai.php" title="����������"><?php echo $minfos['feedback']; ?></a> </em> �ղ�: <em> <a href="mystow.php" title="�ղؼ�"><?php echo $minfos['stow']; ?></a> </em> ����: <em><a href="javascript:;"><?php echo $minfos['archives']; ?></a> </em> ����:<em> <a href="content_list.php?channelid=1" title="�ѷ���������"><?php echo $minfos['article']; ?></a> </em>ͼ��: <em> <a href="content_list.php?channelid=2" title="����ͼ��"><?php echo $minfos['album']; ?></a> </em> ����: <em> <a href="content_list.php?channelid=3" title="�ѷ���������"><?php echo $minfos['soft']; ?></a> </em> ��Ʒ:</a> <em> <a href="shops_products.php" title="�������Ʒ"><?php echo $minfos['shop']; ?></a> </em> </p>-->
            </div>
          </div>
        </dd>
      </dl>
	</div>
	<div class="col-lg-8 col-lg-offset-2">
	<div class="alert alert-success" role="alert"> 
	<?php 
	$sql="Select city_fee_pic From `dede_city` as c,`dede_member` as m where c.city_name= m.city and m.mid={$cfg_ml->M_ID}"; 
	//echo $sql;
    $row = $GLOBALS[dsql]->GetOne($sql); 
	echo empty($row['city_fee_pic'])?"���޹���":$row['city_fee_pic'];
	?>
	</div>
	</div>
	
</div>

</div>
<?php include $this->CompilerInclude("../templets/default/footer.htm");
 ?>
</body>
</html>