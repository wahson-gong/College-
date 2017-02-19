<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
 include $this->CompilerInclude("header.htm");
 
$aid=intval($_GET['aid']);
$sql = "SELECT * from `#@__sgpage` where aid=" . $aid;
$row = $dsql->GetOne($sql);
?>
<div class="container" style="margin-top:50px;margin:50px auto">
	<div class="row single-post">
		<div class="col-md-12 col">
			<div class="panel panel-default panel-single-post">
			 

				<div class="panel-body">
					<p style="text-align:center;font-weight:500;"><?php echo $row['title']?></p>
                    	<div class="entry">
                    	<?php echo $row['body'];?>				
						</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include $this->CompilerInclude("footer.html");
 ?>
</body>
</html>