<?php
require(dirname(__FILE__)."/config.php");
//CheckPurview('member_Edit');
$ENV_GOBACK_URL = isset($_COOKIE['ENV_GOBACK_URL']) ? "city_list.php" : '';

include DedeInclude('templets/city_add.htm');