<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
 include $this->CompilerInclude("header.htm");
 ?>
<div class="container">
	<div class="row post-list">
		<div class="col-sm-12 col" style="min-height:500px;">
				<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?> 
				<div class="post-667 post mb-20">
					<a class="pull-left img-div" href="javascript:void" style="width:100px;height:100px;border-radius:100px">
					<?php if($fields['sex']=='男'){  echo userPic($fields['litpic'],'男'); 
}
else{
 echo userPic($fields['litpic'],'女');  } ?>
					
						<!-- <img src="http://mao10.qiniudn.com/201605181602324467.jpg" style="margin-top: 0px;"> -->
					</a>
					<div class="post-right">
						<h2 class="title">
							<a class="wto" href="">
								<?php echo getFirst($fields['uname']); ?>教员	
							</a>
						</h2>
						<!--  
						<div class="author mb-10">
							<a><?php echo $fields['sex']; ?>-<?php echo $fields['school']; ?>-<?php echo $fields['zhuanye']; ?>-<?php echo $fields['nianji']; ?></a>
							<div class="clearfix"></div>
						</div>
						-->
	
						<ul class="list-inline mb-0">
							<li><i class="glyphicon glyphicon-list-alt"></i> &nbsp;&nbsp;<a><?php echo $fields['sex']; ?>-<?php echo $fields['school']; ?>-<?php echo $fields['zhuanye']; ?>-<?php echo $fields['nianji']; ?></a></li><br/><br/>
								
							<li style="float:left"><i class="glyphicon glyphicon-tag"></i> &nbsp;&nbsp;</li>
							<?php echo biaoqian($fields['biaoqian']); ?>
							
							<br/>
						</ul>

						
						<!-- 自我介绍 -->
						<div class="entry mb-10">
						<?php echo emptyConvert($fields['introduction']); ?>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<?php
}
}?>
		</div>
	</div>
	<p style="text-align:center"><?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
</p>
</div>

<?php include $this->CompilerInclude("footer.html");
 ?>
</body>
<script type="text/javascript">
	window.onload=function(){
		$('.pagelistbox>span').html('');
	}
</script>
</html>