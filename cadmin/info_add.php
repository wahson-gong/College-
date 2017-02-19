<?php
require(dirname(__FILE__)."/config.php");
//CheckPurview('member_Edit');
$ENV_GOBACK_URL = isset($_COOKIE['ENV_GOBACK_URL']) ? "info_list.php" : '';

include DedeInclude('templets/info_add.htm');
