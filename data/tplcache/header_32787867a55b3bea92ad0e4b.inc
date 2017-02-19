<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang; ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>College家教</title>

<link href="/templets/home/css/bootstrap.min.css" rel="stylesheet">

<link href="/templets/home/css/freelancer.css" rel="stylesheet">
<link href="/templets/home/css/main.css" rel="stylesheet">
<link href="/templets/home/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<!--
<link href="http://fonts.useso.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="http://fonts.useso.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">-->

<link rel="stylesheet" type="text/css" href="/templets/home/css/cityPicker.css">
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->

</head>
<!-- jQuery -->
<script src="/templets/home/js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="/templets/home/js/bootstrap.min.js"></script>

<!-- Plugin JavaScript -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="/templets/home/js/classie.js"></script>
<script src="/templets/home/js/cbpAnimatedHeader.js"></script>

<!-- Contact Form JavaScript -->
<script src="/templets/home/js/jqBootstrapValidation.js"></script>
<script src="/templets/home/js/contact_me.js"></script>

<!-- Custom Theme JavaScript -->
<script src="/templets/home/js/freelancer.js"></script>

<!--引入城市选择器 -->


<script src="/templets/home/js/cityPicker.js"></script>
<script>
	function cityChange(){
		document.getElementById('cityForm').submit();
	}
</script>
			
<style>
body{
	font-family: "Microsoft YaHei",微软雅黑,"MicrosoftJhengHei",华文细黑,STHeiti,MingLiu;
}
.navtop{
background-color: #00beb7;margin-bottom:0px
}
.contact-info {
width: 160px;
margin-top: 35px;
}
.fr {
float: right;
}
.cf {
zoom: 1;
}
.body em {
width: 40px;
height: 44px;
background: url(/templets/home/img/guanwang-min.png) no-repeat;
background-position: -572px -390px;
float: left;
}
.body div {
color: #666666;
font-size: 16px;
margin-left: 45px;
}
.body div p {
margin: 0;
margin-top: 3px;
font-size: 16px;
line-height:20px
}
#find_teacher{
text-align: center;
text-indent: 0px;
width: 200px;
background: #00beb7;
color: #FFF;
font-size: 16px;
-webkit-box-shadow: 0px 0px 2px #000;
-moz-box-shadow: 0px 0px 2px #cfcece;
box-shadow: 0px 0px 2px #000;
}
.navbar-nav>li {
    float: left;
    width: 120px;
}
.pagelistbox{
	text-align:center
}
</style>
<body id="page-top" class="index">
<!--顶部-->
<div class="container">
	<div class="row" style="width=520px;margin:0px auto;height:120px;vertical-align:middle;line-height:120px">
		<div class="" style="width:100%;">
		<?php if($isMobile==0){?>
		<img src="/templets/default/images/logo.jpg"  height="100px"/><span>College家教</span>
		<?php }?>
		<form action="home.php" method="post" id="cityForm" name="cityForm" style="display:inline-block;margin-left:30px">
		当前城市：&nbsp;<span type="text" id="cityChoice" value=""><?php echo $city;?>&nbsp;&nbsp;<span class="glyphicon glyphicon-chevron-down glyphicon-align-right" aria-hidden="true"></span></span>
		<input type="hidden" id="province" name='province' value="">
		<input type="hidden" id="city" name='city' value="<?php echo $city;?>">
		<input type="hidden" name="dopost" value="changeCity"/>
		<?php
			$City = '';
			$CityData = array();
             $dsql->SetQuery("Select mid,city_name From `#@__city` where mid>0");
             $dsql->Execute('n');
             while($nrow = $dsql->GetObject('n')){
	              $City[$nrow->mid] = $nrow->city_name;
				  $CityData[] = array('pid'=>$nrow->mid,'pname'=>urlencode($nrow->city_name),'id'=>$nrow->mid,'name'=>urlencode($nrow->city_name));
             }
			
			 $CityData = urldecode(json_encode($CityData));
			/*
             $options = "<select name='city' onchange='cityChange()' style='line-height:50px;vertical-align:center;width:300px;border:2px solid #23cd77;display:inline-block' class='form-control'>\r\n";
             foreach($City as $k=>$v)
             {
  	            if($v!=$city) $options .= "<option value='$v'>$v</option>\r\n";
  	            else $options .= "<option value='$v' selected>$v</option>\r\n";
             }
             $options .= "</select>\r\n";
			 echo $options;
*/
			?>

			</form>
			<?php if($isMobile==0){ ?>
			<div class="contact-info fr">
				<div class="body cf">
					<div style="background:url('/templets/default/images/logo-desc2.png')  no-repeat;height:60px;margin-top:15px;width:100%"></div>
				</div>
			</div>
			<?php }?>
			<div class="contact-info fr">
                    <div class="body cf">
                        <em></em>
                        <div>
                            <p>服务咨询热线</p>
                            <p><a href="tel:400-882-1008">400-882-1008</a></p>
                        </div>
                    </div>
                </div>
		</div>
		<div class="col-sm-4 col-sm-offset-6"></div>
	</div>
</div>
<!-- Navigation -->
<nav class="navbar navbar-default navtop">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header page-scroll">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>	 
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav navbar-left">
				<li class="page-scroll" id="find_teacher">
					<a href="find.php">找家教</a>
				</li>
				<li class="page-scroll" style="margin-left:50px">
					<a href="home.php">首页</a>
				</li>

				<li class="page-scroll">
					<a href="tuijian.php">明星教员</a>
				</li>
				<li class="page-scroll">
					<a href="help.php?aid=19">帮助中心</a>
				</li>

				<li class="page-scroll">
					<a href="info_index.php">教员入口</a>
				</li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>
<script>
				var cityData = 	{hot:<?php echo $CityData;?>,province:[]};
    			var cityPicker = new IIInsomniaCityPicker({
        			data: cityData,
        			target: '#cityChoice',
        			valType: 'k-v',
        			hideCityInput: '#city',
        			hideProvinceInput: '#province',
       				callback: function(city_id){
            			cityChange();
        			}
   				 });

    			cityPicker.init();
			</script>