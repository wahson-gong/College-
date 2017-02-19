<?php
/**
 * 记录申请查看
 *
 * @version        $Id: member_view.php 1 14:15 2010年7月20日Z tianya $
 * @package        DedeCMS.Administrator
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require(dirname(__FILE__)."/config.php");
//CheckPurview('member_Edit');
$ENV_GOBACK_URL = isset($_COOKIE['ENV_GOBACK_URL']) ? "fee_back.php" : '';
$id = preg_replace("#[^0-9]#", "", $id);
$row = $dsql->GetOne("select  * from #@__back_fee_record where mid='$id'");

include DedeInclude('templets/fee_back_view.htm');