<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
 include $this->CompilerInclude("header.htm");
 ?>
<!-- ͷ��nav -->
<?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?> 
<div class="container" style="margin-top:50px;width:1120px;margin:50px auto">
	<div class="row single-post">
		<div class="col-md-12 col">
			<div class="panel panel-default panel-single-post">
				<div class="panel-heading">
					<h1 class="title mt-0 mb-20"><?php echo $fields['title']; ?></h1>
					<div class="post-info">
						<ul class="list-inline mb-0">
							<li><?php echo $fields['description']; ?></li>
						</ul>
					</div>
					<div class="bg"></div>
					<div class="bgimg blur" style="background-image:url(http://mao10.qiniudn.com/201603061805324166.jpg);">
                        <img src="http://mao10.qiniudn.com/201603061805324166.jpg">
                    </div>
				</div>
				<div class="panel-body">
                    					<div class="entry">
						<p>V6.1.1�汾��mysql�汾���ȶ��Է����кܴ���������Ϊ��Ҳ��ʧһ���������ٶȡ��������İ汾���������ɻ�Գ�������ܺ��ȶ��Խ��г����Ż���ͬʱ�ڴ������������Ǹ���ʹ���ϵ����⡣</p>
						<p>V6.1.2���¹滮���£�</p>
						<p>1������ @���� ���ڲ���������޷���ȷ@��ָ���û������⣬��ȡ��@���ܸ�Ϊվ���š�</p>
						<p>2����Ʒģ��֧�ֶ������ࣨ����֧�ָ��༶��</p>
						<p>3������ҳ�桢��Ʒ��Ƶ�����ݣ�ɾ��ʱǰ̨�л�����������⡣</p>
						<p>4���Ż���̨�˵��������������飬�Լ�ΪһЩ���������������˰�����Ϣ��</p>
						<p>5��������֧�����ӿ�֧�֡�<del>�Լ��ֻ�����ʱ����ѡ��΢��֧��ѡ��</del>��</p>
						<p>6����������Ĺ��ﳵ���ҵĶ������Լ��û��˵�����Ϣ�ȣ����ϵ�һ���µ�ģ���С�</p>
						<p>7���Ż�ģ��ͷ�������ٶ�����LOGOռλ�ռ䡣</p>
						<p>8���󲿷�ҳ���ģ�壬ʵ��<font color="#ff0000">ǰ��˷���</font>��ҳ��ģ���в��ٺ��д����߼����롣</p>
						<p>9���������ӹ����Լ�����ҳ��֧�ֺ�̨���ӹ����롣</p>
						<p>10��������һ���ı仰�����󣬻ᵼ�»�������ڶ�������е����⡣</p>
						<p>11���޸����Զ���ȡ��������ͼƬ��Ϊ�����޷����е����⡣</p>
						<p>12����������ʱ������ͼƬ��֧��ʹ������ͼƬurl�ķ�ʽ���롣</p>
						<p>13�����԰���ڳ�ģ�飬��ʽ���뵽�����С�</p>
						<p>���֮ǰ�汾��V6.1.2���ȶ��Դ��������6.1.1�汾�ĵ���������Ҳ�õ��˸��ơ�<span style="line-height: 25.7143px;">������6.1.2�汾��ȫ�����£������ڹ���������</span></p>					
						</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
}
} include $this->CompilerInclude("footer.html");
 ?>
</body>
</html>