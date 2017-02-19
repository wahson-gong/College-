<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $GLOBALS['cfg_soft_lang']; ?>" />
<title>用户评论：<?php echo $GLOBALS['title']; ?></title>
<link href="<?php echo $GLOBALS['cfg_templets_skin']; ?>/style/dedecms.css" rel="stylesheet" media="screen" type="text/css" />
<script language="javascript" type="text/javascript" src="<?php echo $GLOBALS['cfg_cmsurl']; ?>/include/dedeajax2.js"></script>
<script language="javascript">
function postBadGood(ftype,fid)
{
	var taget_obj = document.getElementById(ftype+fid);
	var saveid = GetCookie('badgoodid');
	if(saveid != null)
	{
		 var saveids = saveid.split(',');
		 var hasid = false;
		 saveid = '';
		 j = 1;
		 for(i=saveids.length-1;i>=0;i--)
		 {
		 	  if(saveids[i]==fid && hasid) continue;
		 	  else {
		 	  	if(saveids[i]==fid && !hasid) hasid = true;
		 	  	saveid += (saveid=='' ? saveids[i] : ','+saveids[i]);
		 	  	j++;
		 	  	if(j==10 && hasid) break;
		 	  	if(j==9 && !hasid) break;
		 	  }
		 }
     if(hasid) { alert('您刚才已表决过了喔！'); return false; }
     else saveid += ','+fid;
		 SetCookie('badgoodid',saveid,1);
	}
	else
	{
		SetCookie('badgoodid',fid,1);
	}
	//document.write("feedback.php?action="+ftype+"&fid="+fid);
	//return;
  myajax = new DedeAjax(taget_obj,false,false,'','','');
  myajax.SendGet2("feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&action="+ftype+"&fid="+fid);
  DedeXHTTP = null;
}

function ajaxFeedback(aid, fid, type)
{
	
	var taget_obj = $DE('ajaxfeedback_'+fid);
	if(taget_obj.innerHTML == '')
	{
		var myajax = new DedeAjax(taget_obj, true, true, '', 'x');
		myajax.SendGet2("<?php echo $GLOBALS['cfg_phpurl']; ?>/feedback.php?aid="+aid+"&fid="+fid+"&action=quote&type=ajax");
		eval('var result = typeof CKEDITOR.instances.msg_'+fid);
		if(result != 'undefined')
		{
			// 删除实例
			eval('var edit = CKEDITOR.instances.msg_'+fid);
			CKEDITOR.remove(edit);
		}
		CKEDITOR.replace(document.getElementById('msg_'+fid) , CKEDITOR.instances.msg.config);
		scroll(0, taget_obj.offsetTop - 120);
		var formname = 'f = document.ajaxfeedback_'+fid;
		eval(formname);
		if(f.validate)
		{
			if($DE('vdimg_'+fid)) $DE('vdimg_'+fid).src = "<?php echo $GLOBALS['cfg_cmsurl']; ?>/include/vdimgck.php?"+f.validate.value;
			f.validate.value = '';
		}
		
		DedeXHTTP = null;
	}
}

function ajaxQuotePost(fid)
{
	var formname = 'f = document.ajaxfeedback_'+fid;
	eval(formname);
	//var f = document.formname;
	//var f = f[0];
	var nvalidate = '';
	var nnotuser = '';
	var nusername = '';
	var npwd = '';
	var taget_obj = $DE('commetcontentNew');
	var waithtml = "<div style='line-height:30px'><img src='<?php echo $GLOBALS['cfg_cmsurl']; ?>/images/loadinglit.gif' />正在发送中...</div>";
	eval('var msg = CKEDITOR.instances.msg_'+fid+'.getData()');

	if(f.validate)
	{
		if(f.validate.value=='') {
			alert("请填写验证码！");
			return;
		}
		else {
			nvalidate = f.validate.value;
		}
	}
	var myajax = new DedeAjax(taget_obj, false, true, '', '', waithtml);
	
	if(f.notuser.checked) nnotuser = '1';
	if(f.username) nusername = f.username.value;
	if(f.pwd) npwd = f.pwd.value;
	
	myajax.sendlang = '<?php echo $GLOBALS['cfg_soft_lang']; ?>';
	myajax.AddKeyN('dopost', 'send');
	myajax.AddKeyN('aid', '<?php echo $GLOBALS['aid']; ?>');
	myajax.AddKeyN('fid', f.fid.value);
	myajax.AddKeyN('type', 'ajax');
	myajax.AddKeyN('comtype', f.comtype.value);
	myajax.AddKeyN('isconfirm','yes');
	
	myajax.AddKeyN('typeid', f.typeid.value);
	myajax.AddKeyN('quotemsg', f.quotemsg.value);
	myajax.AddKeyN('validate', nvalidate);
	myajax.AddKeyN('notuser', nnotuser);
	myajax.AddKeyN('username', nusername);
	myajax.AddKeyN('pwd', npwd);
	myajax.AddKeyN('msg', msg);
	myajax.SendPost2('<?php echo $GLOBALS['cfg_phpurl']; ?>/feedback_ajax.php');
	//alert(f.quotemsg.value);
	if($DE('ajaxfeedback_'+fid).innerHTML != null)
	{
		$DE('ajaxfeedback_'+fid).innerHTML = '';
	}
	scroll(0, taget_obj.offsetTop);
	taget_obj.removeAttribute('id');

}
</script>
<body class="commentpage">

<!-- /nav -->
</div>
<!-- /header -->
<div class=" clear center mt1 cmt-box" style=" width:880px;">
  <!-- <div class="sp-title">
   <h2>评论:<a href='<?php echo $GLOBALS['arcurl']; ?>'><?php echo $GLOBALS['title']; ?></a></h2>
  </div>-->
  <div>
    <dl class="tbox">
      <dt>  <span class="label"> <a href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&ftype=good' <?php if($ftype=='good') echo "class='thisclass'"; ?>>只看好评</a> <a href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&ftype=bad' <?php if($ftype=='bad') echo "class='thisclass'"; ?>>只看差评</a> <a href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>&ftype=feedback' <?php if($ftype=='feedback') echo "class='thisclass'"; ?>>只看中立</a> <a href='feedback.php?aid=<?php echo $GLOBALS['aid']; ?>' <?php if($ftype=='') echo "class='thisclass'"; ?>>全部评论</a> </span> </dt>
      <dd>
        <div class="dede_comment">
          <div class='decmt-box1'>
            <ul>
           
            
              <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{

  if($fields['userid']!='') $spaceurl = $cfg_basehost.'/member/index.php?uid='.$fields['userid'];
  else $spaceurl = "#";
  if($fields['username']=='匿名') $spaceurl = "#";
  $fields['bgimg'] = 'cmt-neu.gif';
  $fields['ftypetitle'] = '该用户表示中立';
  if($fields['ftype']=='bad') {
  	$fields['bgimg'] = 'cmt-bad.gif';
  	$fields['ftypetitle'] = '该用户表示差评';
  }
  else if($fields['ftype']=='good') {
  	$fields['bgimg'] = 'cmt-good.gif';
  	$fields['ftypetitle'] = '该用户表示好评';
  }
  if(empty($fields['mface']))
  {
    if($fields['sex']=="女") $fields['mface']="/member/templets/images/dfgirl.png";
    else $fields['mface']="/member/templets/images/dfboy.png";
  }
?>
              <li> <a href='<?php echo $spaceurl; ?>' class='plpic'><img src='<?php echo $fields['mface'];?>'  height='80' width='80'/></a> <span class="title"> <?php echo $fields['username']; ?><img src="<?php echo $GLOBALS['cfg_templets_skin']; ?>/images/<?php echo $fields['bgimg']; ?>" /></span>
			  
            
                <p>
                <?php
                echo RemoveXSS(Quote_replace(parseSmileys($fields['msg'],$cfg_cmspath.'/images/smiley')));
                ?></p>
				<h5><?php echo MyDate('Y-m-d H:i',$fields['dtime']); ?>发表</h5>
              </li>
               <div id="ajaxfeedback_<?php echo $fields['id']; ?>"></div>
              <?php
}
}
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listitem'] = 'info,index,end,pre,next,pageno';
$atts['listsize'] = '5';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>

            </ul>
          </div>
        </div>
        <!-- /dede_comment -->
      </dd>
    </dl>
  </div>
  
</div>

<!-- /footer -->
</body>
</html>