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
				<h5>��ǰԤԼ���Ƽ�����������ӵļҽ�</h5>
				<span>����������Ϣ,��ǰԤԼ��ʦһ��һ���Ÿ���...</span>
				<form name="sentMessage" id="contactForm" novalidate>
				<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>����</label>
							<input type="text" class="form-control" placeholder="����" id="city" required data-validation-required-message="���������." value="<?php echo $city;?>">
							<p class="help-block text-danger"></p>
						</div>
					</div>
					
					<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>�꼶</label>
							<select class="form-control" id="nianji" name="nianji" required data-validation-required-message="�������꼶.">
								<option value="">��ѡ���꼶</option>
								<option value="һ�꼶">һ�꼶</option>
  								<option value="���꼶">���꼶</option>
  								<option value="���꼶">���꼶</option>
  								<option value="���꼶">���꼶</option>
  								<option value="���꼶">���꼶</option>
  								<option value="���꼶">���꼶</option>
  								<option value="��һ">��һ</option>
  								<option value="����">����</option>
  								<option value="����">����</option>
  								<option value="��һ">��һ</option>
  								<option value="�߶�">�߶�</option>
  								<option value="����">����</option>
  								<option value="����">����</option>
							</select>
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>ѧ��</label>
							<select class="form-control" id="subject" name="subject" required data-validation-required-message="��ѡ��ѧ��.">
								<option value="">��ѡ��ѧ��</option>
								<option value="����">����</option>
  								<option value="��ѧ">��ѧ</option>
  								<option value="Ӣ��">Ӣ��</option>
  								<option value="����">����</option>
  								<option value="��ʷ">��ʷ</option>
  								<option value="����">����</option>
  								<option value="����">����</option>
  								<option value="��ѧ">��ѧ</option>
  								<option value="����">����</option>
  								<option value="����">����</option>
  								<option value="���">���</option>
  								<option value="����">����</option>
  								<option value="����">����</option>
  								<option value="����">����</option>
							</select>
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<div class="row control-group">
						<div class="col-xs-12 floating-label-form-group controls">
							<label>��ϵ��ʽ</label>
							<input type="tel" class="form-control" placeholder="��ϵ��ʽ" id="phone" required data-validation-required-message="��������ϵ��ʽ.">
							<p class="help-block text-danger"></p>
						</div>
					</div>
					<br>
					<div id="success"></div>
					<div class="row" style="text-align:center">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-success btn-lg" style="width:100%;font-size:14px">����������ϵ��ʽ������������ϵ��</button>
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