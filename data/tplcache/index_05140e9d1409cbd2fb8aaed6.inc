<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>会员中心 -<?php echo $cfg_webname; ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>" />
<link href="templets/style/index.css" rel="stylesheet" type="text/css" />
<link href="templets/style/boxy.css" rel="stylesheet" type="text/css" />

<link href="templets/style/div.css" rel="stylesheet" type="text/css" />
<link href="templets/style/IN365hls2.9.css" rel="stylesheet" type="text/css" media="all">
<link rel="stylesheet" type="text/css" href="templets/style/header2_9.css">

<link href="css/base.css" rel="stylesheet" type="text/css">
<!-- 新 Bootstrap 核心 CSS 文件 -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- 可选的Bootstrap主题文件（一般不用引入） -->
<link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">

<!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
<script src="http://cdn.bootcss.com/jquery/1.11.3/jquery.min.js"></script>

<!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
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
		if( content == '来,说点啥吧...' ) content = '';
		if ( content == '' ) {
			alert('请输入内容'); return false;
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
  			<li role="presentation" class="active"><a href="../member/index.php">个人中心</a></li>
 			<li role="presentation"><a href="../member/edit_baseinfo.php">帐号及密码</a></li>
  			<li role="presentation"><a href="../member/ac_record.php">接单记录</a></li>
  			<li role="presentation"><a href="../member/try_feed_back.php">试讲记录</a></li>
 			<li role="presentation"><a href="../member/fee_back.php">退款申请</a></li>
  			<!--<li role="presentation"><a href="../member/archives_edit.php?channelid=6&aid=<?php echo $sid ?>">修改教师资料</a></li>-->
  			<li role="presentation"><a href="../member/index_do.php?fmdo=login&dopost=exit#">退出登录</a></li>
		</ul>
	</div>
	<div class="col-lg-8 col-lg-offset-2 col" style="margin-top:50px">
		       <dl class="sns-avatar">
        <dt>
          <div class="s120"> <a href="<?php echo $cfg_cmsurl;?>/member/index.php?uid=<?php echo $cfg_ml->M_LoginID; ?>"><img src="<?php echo $cfg_ml->fields['face']; ?>" width="100" height="100" alt="您的形象"/></a> </div>
        </dt>
        <dd class="av-index">
          <ul>
            <li class="name"><?php echo $cfg_ml->fields['uname']; ?><span><?php echo $cfg_ml->M_MbType; ?>用户</span></li>
           
           <li class="name">会员编号：<?php echo $cfg_ml->M_ID; ?></li>
          </ul>
          <div class="msg">
          
                        
      		
        
          
          <?php 
          
           $zt=$cfg_ml->fields['spacesta'];

           if($zt==-10)
           {
           	 echo $cfg_ml->M_LoginID."您的基本资料正在审核中，请您稍后查看";
           }
           if($zt==0||$zt==1)
           {
           	
             echo "审核已通过请您";
             
              $uname=$cfg_ml->fields['uname'];

            $sql="Select * From `dede_archives` where title='".$uname."' "; 

           
            $row = $GLOBALS[dsql]->GetOne($sql); 
            
            $description=$row[title]; 
           

            if($description==$uname)
            {
           	 ?>
                  <a href='/member/archives_edit.php?channelid=6&aid=<?php echo $row["id"];?>'><font color="#FF0000">修改个人资料</font></a>
             <?php
            }else{
            		
                    ?>
                     <a href='/member/archives_add.php?channelid=6'><font color="#FF0000">完善个人资料</font></a>
                    <?php
            }
            
             
           }
           
           ?>
           
           
          <div style=" height:40px;">
         <!-- <p>短消息: <em> <a href="pm.php?TB_iframe=true&height=600&width=700" title="我的短信息" target="_blank"> <?php echo $pms['nums'];?></a> </em> 评论: <em> <a href="caicai.php" title="发出的评论"><?php echo $minfos['feedback']; ?></a> </em> 收藏: <em> <a href="mystow.php" title="收藏夹"><?php echo $minfos['stow']; ?></a> </em> 其它: <em><a href="javascript:;"><?php echo $minfos['archives']; ?></a> </em> 文章:<em> <a href="content_list.php?channelid=1" title="已发布的文章"><?php echo $minfos['article']; ?></a> </em>图集: <em> <a href="content_list.php?channelid=2" title="管理图集"><?php echo $minfos['album']; ?></a> </em> 软件: <em> <a href="content_list.php?channelid=3" title="已发布的软件"><?php echo $minfos['soft']; ?></a> </em> 商品:</a> <em> <a href="shops_products.php" title="购买的商品"><?php echo $minfos['shop']; ?></a> </em> </p>-->
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
	echo empty($row['city_fee_pic'])?"暂无公告":$row['city_fee_pic'];
	?>
	</div>
	</div>
	
</div>

</div>
<?php include $this->CompilerInclude("../templets/default/footer.htm");
 ?>
</body>
</html>