<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
 include $this->CompilerInclude("header.htm");
 ?>
<!-- 头部nav -->
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
						<p>V6.1.1版本在mysql版本的稳定性方面有很大提升，但为此也损失一部分运行速度。接下来的版本中我们依旧会对程序的性能和稳定性进行持续优化。同时期待您反馈给我们更多使用上的问题。</p>
						<p>V6.1.2更新规划如下：</p>
						<p>1、由于 @功能 存在部分情况下无法正确@到指定用户的问题，将取消@功能改为站内信。</p>
						<p>2、商品模块支持二级分类（还不支持更多级）</p>
						<p>3、修正页面、商品等频道内容，删除时前台有缓存残留的问题。</p>
						<p>4、优化后台菜单，提升发布体验，以及为一些参数的设置添加了帮助信息。</p>
						<p>5、独立的支付宝接口支持、<del>以及手机访问时可以选择微信支付选项</del>。</p>
						<p>6、将侧边栏的购物车、我的订单，以及用户菜单、信息等，整合到一个新的模块中。</p>
						<p>7、优化模板头部，减少独立的LOGO占位空间。</p>
						<p>8、大部分页面的模板，实现<font color="#ff0000">前后端分离</font>，页面模板中不再含有大量逻辑代码。</p>
						<p>9、友情链接管理以及部分页面支持后台添加广告代码。</p>
						<p>10、修正了一个改变话题分类后，会导致话题出现在多个分类中的问题。</p>
						<p>11、修复了自动获取文章内容图片作为封面无法运行的问题。</p>
						<p>12、发布文章时，封面图片可支持使用外链图片url的方式插入。</p>
						<p>13、测试版的众筹模块，正式加入到程序中。</p>
						<p>相比之前版本，V6.1.2的稳定性大幅提升，6.1.1版本的低性能问题也得到了改善。<span style="line-height: 25.7143px;">以上是6.1.2版本的全部更新，近日在官网发布！</span></p>					
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