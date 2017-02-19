<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
 include $this->CompilerInclude("header.htm");
  if($isMobile==0){?>
<div class="width:100%;height:310px;">
<a href="javascript:void" style="background:url('/templets/home/img/home_banner.jpg') center top no-repeat;background-size:100%;height:210px;display:block"></a>
</div>
<?php }?>
<section id="contact" style="padding:30px">
	<div class="container">
		<div class="row">
		<?php if($isMobile==1){?>
			<div class="col-lg-6 col-lg-offset-1" style="border-left:0px solid #eee">
				<div class="row">
					<div class="col-lg-12" style="text-align:center">
						<img src="/templets/default/images/tuiguang.png" style="width:80%;margin-top:1	0%"/>
					</div>
				</div>
			</div>
			<?php }?>
			<div class="col-lg-4 col-sm-offset-1">
				<!-- To configure the contact form email address, go to mail/contact_me.php and update the email address in the PHP file on line 19. -->
				<!-- The form should work on most web servers, but if the form is not working you may need to configure your web server differently. -->
				<h5>提前预约，推荐最合适您孩子的家教</h5>
				<span>留下您的信息,提前预约名师一对一上门辅导...</span>
				<form name="sentMessage" id="contactForm" novalidate>
				<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>城市</label>
							<input type="text" class="form-control" placeholder="城市" id="city" required data-validation-required-message="请输入城市." value="<?php echo $city;?>">
							<p class="help-block text-danger"></p>
						</div>
					</div>
					
					<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>年级</label>
							<select class="form-control" id="nianji" name="nianji" required data-validation-required-message="请输入年级.">
								<option value="">请选择年级</option>
								<option value="一年级">一年级</option>
  								<option value="二年级">二年级</option>
  								<option value="三年级">三年级</option>
  								<option value="四年级">四年级</option>
  								<option value="五年级">五年级</option>
  								<option value="六年级">六年级</option>
  								<option value="初一">初一</option>
  								<option value="初二">初二</option>
  								<option value="初三">初三</option>
  								<option value="高一">高一</option>
  								<option value="高二">高二</option>
  								<option value="高三">高三</option>
  								<option value="其他">其他</option>
							</select>
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>学科</label>
							<select class="form-control" id="subject" name="subject" required data-validation-required-message="请选择学科.">
								<option value="">请选择学科</option>
								<option value="语文">语文</option>
  								<option value="数学">数学</option>
  								<option value="英语">英语</option>
  								<option value="政治">政治</option>
  								<option value="历史">历史</option>
  								<option value="地理">地理</option>
  								<option value="生物">生物</option>
  								<option value="化学">化学</option>
  								<option value="物理">物理</option>
  								<option value="乐器">乐器</option>
  								<option value="编程">编程</option>
  								<option value="美术">美术</option>
  								<option value="体育">体育</option>
  								<option value="其他">其他</option>
							</select>
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>联系方式</label>
							<input type="tel" class="form-control" placeholder="联系方式" id="phone" required data-validation-required-message="请输入联系方式.">
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<br>
					<div id="success"></div>
					<div class="row" style="text-align:center">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-success btn-lg" style="width:100%;font-size:14px">留下您的联系方式，方便我们联系您</button>
						</div>
					</div>
				</form>
			</div>
			<?php if($isMobile==0){?>
			<div class="col-lg-6 col-lg-offset-1" style="height:500px;border-left:0px solid #eee">
				<div class="row">
					<div class="col-lg-12" style="text-align:center">
						<img src="/templets/default/images/tuiguang.png" style="width:80%;margin-top:1	0%"/>
					</div>
				</div>
			</div>
			<?php }?>
		</div>
	</div>
</section>

<?php include $this->CompilerInclude("footer.html");
 ?>
</body>
</html>