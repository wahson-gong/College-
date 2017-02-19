<?php
/**
 * ��������
 * 
 * @version        $Id: article_add.php 1 8:38 2010��7��9��Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
require_once(dirname(__FILE__)."/config.php");
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/userlogin.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 1;
$typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 0;
$mtypesid = isset($mtypesid) && is_numeric($mtypesid) ? $mtypesid : 0;
$menutype = 'content';

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
    $cInfos = $dsql->GetOne("SELECT * FROM `#@__channeltype` WHERE id='$channelid'; ");

    //��������˻�Ա��������ͣ��������ο�Ͷ��ѡ����Ч
    if($cInfos['sendrank']>0 || $cInfos['usertype']!='') CheckRank(0,0);


    //����Ա�ȼ�����������
    if($cInfos['sendrank'] > $cfg_ml->M_Rank)
    {
        $row = $dsql->GetOne("SELECT membername FROM `#@__arcrank` WHERE rank='".$cInfos['sendrank']."' ");
        ShowMsg("�Բ�����Ҫ[".$row['membername']."]���������Ƶ�������ĵ���","-1","0",5000);
        exit();
    }
    
    if($cInfos['usertype']!='' && $cInfos['usertype'] != $cfg_ml->M_MbType)
    {
        ShowMsg("�Բ�����Ҫ[".$cInfos['usertype']."�ʺ�]���������Ƶ�������ĵ���","-1","0",5000);
        exit();
    }
    include(DEDEMEMBER."/templets/article_add.htm");
    exit();
}
/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
    include(DEDEMEMBER.'/inc/archives_check.php');

    //�������?�ӱ����
    $inadd_f = $inadd_v = '';
    if(!empty($dede_addonfields))
    {
        $addonfields = explode(';', $dede_addonfields);
        $inadd_f = '';
        $inadd_v = '';
        if(is_array($addonfields))
        {
            foreach($addonfields as $v)
            {
                if($v=='')
                {
                    continue;
                }
                $vs = explode(',', $v);
                if(!isset(${$vs[0]}))
                {
                    ${$vs[0]} = '';
                }
                ${$vs[0]} = GetFieldValueA(${$vs[0]}, $vs[1],0);
                $inadd_f .= ','.$vs[0];
                $inadd_v .= " ,'".${$vs[0]}."' ";
            }
        }
    }

     if ( empty($dede_fieldshash) || ( $dede_fieldshash != md5($dede_addonfields . $cfg_cookie_encode) && $dede_fieldshash != md5($dede_addonfields . 'anythingelse' . $cfg_cookie_encode)) ) 
    {
        showMsg('���У�鲻�ԣ����򷵻�', '-1');
        exit();
    }
    
    
    // �����ǰ̨�ύ�ĸ�����ݽ���һ��У��
    $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
    if ($fontiterm != $inadd_f)
    {
        ShowMsg("�ύ�?ͬϵͳ���ò����,�������ύ��", "-1");
        exit();
    }

    //����ͼƬ�ĵ����Զ�������
    if($litpic!='')
    {
        $flag = 'p';
    }
    $body = AnalyseHtmlBody($body, $description);
    $body = HtmlReplace($body, -1);

    //����ĵ�ID
    $arcID = GetIndexKey($arcrank, $typeid, $sortrank, $channelid, $senddate, $mid);
    if(empty($arcID))
    {
        ShowMsg("�޷������������޷����к��������","-1");
        exit();
    }

    //���浽����
    $inQuery = "INSERT INTO `#@__archives`(id,typeid,sortrank,flag,ismake,channel,arcrank,click,money,title,shorttitle,
color,writer,source,litpic,pubdate,senddate,mid,description,keywords,mtype)
VALUES ('$arcID','$typeid','$sortrank','$flag','$ismake','$channelid','$arcrank','0','$money','$title','$shorttitle',
'$color','$writer','$source','$litpic','$pubdate','$senddate','$mid','$description','$keywords','$mtypesid'); ";
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        $gerr = $dsql->GetError();
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID' ");
        ShowMsg("����ݱ��浽��ݿ����� `#@__archives` ʱ���?����ϵ����Ա��","javascript:;");
        exit();
    }

    //���浽���ӱ�
    $addtable = trim($cInfos['addtable']);
    if(empty($addtable))
    {
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__archives` WHERE id='$arcID'");
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID'");
        ShowMsg("û�ҵ���ǰģ��[{$channelid}]��������Ϣ���޷���ɲ�������","javascript:;");
        exit();
    }
    else
    {
        $inquery = "INSERT INTO `{$addtable}`(aid,typeid,userip,redirecturl,templet,body{$inadd_f}) Values('$arcID','$typeid','$userip','','','$body'{$inadd_v})";
        if(!$dsql->ExecuteNoneQuery($inquery))
        {
            $gerr = $dsql->GetError();
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__archives` WHERE id='$arcID'");
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID'");
            ShowMsg("����ݱ��浽��ݿ⸽�ӱ� `{$addtable}` ʱ���?����ϵ����Ա��","javascript:;");
            exit();
        }
    }

    //���ӻ��
    $dsql->ExecuteNoneQuery("UPDATE `#@__member` set scores=scores+{$cfg_sendarc_scores} WHERE mid='".$cfg_ml->M_ID."' ; ");
    //����ͳ��
    countArchives($channelid);

    //���HTML
    InsertTags($tags, $arcID);
    $artUrl = MakeArt($arcID, TRUE);
    if($artUrl=='') $artUrl = $cfg_phpurl."/view.php?aid=$arcID";

    
    #api{{
    if(defined('UC_API') && @include_once DEDEROOT.'/api/uc.func.php')
    {
        //�����¼�
        $feed['icon'] = 'thread';
        $feed['title_template'] = '<b>{username} ����վ������һƪ����</b>';
        $feed['title_data'] = array('username' => $cfg_ml->M_UserName);
        $feed['body_template'] = '<b>{subject}</b><br>{message}';
        $url = !strstr($artUrl,'http://') ? ($cfg_basehost.$artUrl) : $artUrl;
        $feed['body_data'] = array('subject' => "<a href=\"".$url."\">$title</a>", 'message' => cn_substr(strip_tags(preg_replace("/\[.+?\]/is", '', $description)), 150));        
        $feed['images'][] = array('url' => $cfg_basehost.'/images/scores.gif', 'link'=> $cfg_basehost);
        uc_feed_note($cfg_ml->M_LoginID,$feed);

        $row = $dsql->GetOne("SELECT `scores`,`userid` FROM `#@__member` WHERE `mid`='".$cfg_ml->M_ID."' AND `matt`<>10");
        uc_credit_note($row['userid'], $cfg_sendarc_scores);
    }
    #/aip}}
    
    //��Ա��̬��¼
    $cfg_ml->RecordFeeds('add', $title, $description, $arcID);
    
    ClearMyAddon($arcID, $title);
    
    //���سɹ���Ϣ
    $msg =
    "��ѡ����ĺ��������
    <a href='article_add.php?cid=$typeid'><u>��������</u></a>
    &nbsp;&nbsp;
    <a href='$artUrl' target='_blank'><u>�鿴����</u></a>
    &nbsp;&nbsp;
    <a href='article_edit.php?channelid=$channelid&aid=$arcID'><u>�������</u></a>
    &nbsp;&nbsp;
    <a href='content_list.php?channelid={$channelid}'><u>�ѷ������¹���</u></a>";
    $wintitle = "�ɹ��������£�";
    $wecome_info = "���¹���::��������";
    $win = new OxWindow();
    $win->AddTitle("�ɹ��������£�");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand","&nbsp;",false);
    $win->Display();
}