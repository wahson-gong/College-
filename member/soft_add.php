<?php
require_once(dirname(__FILE__)."/config.php");
//���ǰ�ȫԭ�򲻹��Ƿ����ο�Ͷ�幦�ܣ����������û�Ͷ��
CheckRank(0, 0);
if($cfg_mb_lit=='Y')
{
    ShowMsg("����ϵͳ�����˾�����Ա�ռ䣬����ʵĹ��ܲ����ã�","-1");
    exit();
}
require_once(DEDEINC."/dedetag.class.php");
require_once(DEDEINC."/userlogin.class.php");
require_once(DEDEINC."/customfields.func.php");
require_once(DEDEMEMBER."/inc/inc_catalog_options.php");
require_once(DEDEMEMBER."/inc/inc_archives_functions.php");
$channelid = isset($channelid) && is_numeric($channelid) ? $channelid : 3;
$typeid = isset($typeid) && is_numeric($typeid) ? $typeid : 0;
$menutype = 'content';

/*-------------
function _ShowForm(){  }
--------------*/
if(empty($dopost))
{
    $cInfos = $dsql->GetOne("SELECT * FROM `#@__channeltype`  WHERE id='$channelid'; ");
    if(!is_array($cInfos))
    {
        ShowMsg('ģ�Ͳ���ȷ', '-1');
        exit();
    }

    //��������˻�Ա��������ͣ��������ο�Ͷ��ѡ����Ч
    if($cInfos['sendrank']>0 || $cInfos['usertype']!='')
    {
        CheckRank(0, 0);
    }

    //����Ա�ȼ�����������
    if($cInfos['sendrank'] > $cfg_ml->M_Rank)
    {
        $row = $dsql->GetOne("Select membername From `#@__arcrank` where rank='".$cInfos['sendrank']."' ");
        ShowMsg("�Բ�����Ҫ[".$row['membername']."]���������Ƶ�������ĵ���","-1","0",5000);
        exit();
    }
    if($cInfos['usertype']!='' && $cInfos['usertype'] != $cfg_ml->M_MbType)
    {
        ShowMsg("�Բ�����Ҫ[".$cInfos['usertype']."�ʺ�]���������Ƶ�������ĵ���","-1","0",5000);
        exit();
    }
    include(DEDEMEMBER."/templets/soft_add.htm");
    exit();
}

/*------------------------------
function _SaveArticle(){  }
------------------------------*/
else if($dopost=='save')
{
    $description = '';
    include(DEDEMEMBER.'/inc/archives_check.php');

    //�����ĵ�ID
    $arcID = GetIndexKey($arcrank,$typeid,$sortrank,$channelid,$senddate,$mid);
    if(empty($arcID))
    {
        ShowMsg("�޷��������������޷����к���������","-1");
        exit();
    }
    
    //�����������ӱ�����
    $inadd_f = '';
    $inadd_v = '';
    if(!empty($dede_addonfields))
    {
        $addonfields = explode(';',$dede_addonfields);
        $inadd_f = '';
        $inadd_v = '';
        if(is_array($addonfields))
        {
            foreach($addonfields as $v)
            {
                if($v=='')
                {
                    continue;
                }else if($v == 'templet')
                {
                    ShowMsg("�㱣����ֶ�����,���飡","-1");
                    exit();    
                }
                $vs = explode(',',$v);
                if(!isset(${$vs[0]}))
                {
                    ${$vs[0]} = '';
                }
                else if($vs[1]=='htmltext'||$vs[1]=='textdata')

                //HTML�ı����⴦��
                {
                    ${$vs[0]} = AnalyseHtmlBody(${$vs[0]},$description,$litpic,$keywords,$vs[1]);
                }
                else
                {
                    if(!isset(${$vs[0]}))
                    {
                        ${$vs[0]} = '';
                    }
                    ${$vs[0]} = GetFieldValueA(${$vs[0]},$vs[1],$arcID);
                }
                $inadd_f .= ','.$vs[0];
                $inadd_v .= " ,'".${$vs[0]}."' ";
            }
        }
        
        if (empty($dede_fieldshash) || $dede_fieldshash != md5($dede_addonfields.$cfg_cookie_encode))
        {
            showMsg('����У�鲻�ԣ����򷵻�', '-1');
            exit();
        }
        
        // �����ǰ̨�ύ�ĸ������ݽ���һ��У��
        $fontiterm = PrintAutoFieldsAdd($cInfos['fieldset'],'autofield', FALSE);
        if ($fontiterm != $inadd_f)
        {
            ShowMsg("�ύ����ͬϵͳ���ò����,�������ύ��", "-1");
            exit();
        }
    }

    //����ͼƬ�ĵ����Զ�������
    if($litpic!='')
    {
        $flag = 'p';
    }
    $body = HtmlReplace($body,-1);

    //���浽����
    $inQuery = "INSERT INTO `#@__archives`(id,typeid,sortrank,flag,ismake,channel,arcrank,click,money,title,shorttitle,
color,writer,source,litpic,pubdate,senddate,mid,description,keywords)
VALUES ('$arcID','$typeid','$sortrank','$flag','$ismake','$channelid','$arcrank','0','$money','$title','$shorttitle',
'$color','$writer','$source','$litpic','$pubdate','$senddate','$mid','$description','$keywords'); ";
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        $gerr = $dsql->GetError();
        $dsql->ExecuteNoneQuery("Delete From `#@__arctiny` where id='$arcID' ");
        ShowMsg("�����ݱ��浽���ݿ����� `#@__archives` ʱ����������ϵ����Ա��","javascript:;");
        exit();
    }

    //���������б�
    $softurl1 = stripslashes($softurl1);
    $softurl1 = str_replace(array("{dede:","{/dede:","}"), "#", $softurl1);
    $urls = '';
    if($softurl1!='')
    {
        if (preg_match("#}(.*?){/dede:link}{dede:#sim", $servermsg1) != 1) { $urls .= "{dede:link islocal='1' text='{$servermsg1}'} $softurl1 {/dede:link}\r\n"; }
    }
    for($i=2; $i<=12; $i++)
    {
        if(!empty(${'softurl'.$i}))
        {
            $servermsg = str_replace("'","",stripslashes(${'servermsg'.$i}));
            $softurl = stripslashes(${'softurl'.$i});
			$softurl = str_replace(array("{dede:","{/dede:","}"), "#", $softurl);
            if($servermsg=='')
            {
                $servermsg = '���ص�ַ'.$i;
            }
            if($softurl!='' && $softurl!='http://')
            {
                $urls .= "{dede:link text='$servermsg'} $softurl {/dede:link}\r\n";
            }
        }
    }
    $urls = addslashes($urls);
    $softsize = $softsize.$unit;

    //���浽���ӱ�
    $needmoney = @intval($needmoney);
    if($needmoney > 100) $needmoney = 100;
    $cts = $dsql->GetOne("SELECT addtable FROM `#@__channeltype` WHERE id='$channelid' ");
    $addtable = trim($cts['addtable']);
    if(empty($addtable))
    {
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__archives` WHERE id='$arcID'");
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID'");
        ShowMsg("û�ҵ���ǰģ��[{$channelid}]��������Ϣ���޷���ɲ�������","javascript:;");
        exit();
    }
    $inQuery = "INSERT INTO `$addtable`(aid,typeid,filetype,language,softtype,accredit,
    os,softrank,officialUrl,officialDemo,softsize,softlinks,introduce,userip,templet,redirecturl,daccess,needmoney{$inadd_f})
    VALUES ('$arcID','$typeid','$filetype','$language','$softtype','$accredit',
    '$os','$softrank','$officialUrl','$officialDemo','$softsize','$urls','$body','$userip','','','0','$needmoney'{$inadd_v});";
    if(!$dsql->ExecuteNoneQuery($inQuery))
    {
        $gerr = $dsql->GetError();
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__archives` WHERE id='$arcID'");
        $dsql->ExecuteNoneQuery("DELETE FROM `#@__arctiny` WHERE id='$arcID'");
        echo $inQuery;
        exit();
        ShowMsg("�����ݱ��浽���ݿ⸽�ӱ� `{$addtable}` ʱ��������������Ϣ�ύ��DedeCms�ٷ���".str_replace('"','',$gerr),"javascript:;");
        exit();
    }

    //���ӻ���
    $cfg_sendarc_scores = intval($cfg_sendarc_scores);
    $dsql->ExecuteNoneQuery("UPDATE `#@__member` set scores=scores+{$cfg_sendarc_scores} WHERE mid='".$cfg_ml->M_ID."' ; ");
    //����ͳ��
    countArchives($channelid);
    
    //����HTML
    InsertTags($tags,$arcID);
    $artUrl = MakeArt($arcID, TRUE);
    if($artUrl=='')
    {
        $artUrl = $cfg_phpurl."/view.php?aid=$arcID";
    }

    #api{{
    if(defined('UC_API') && @include_once DEDEROOT.'/api/uc.func.php')
    {
        //�����¼�
        $feed['icon'] = 'thread';
        $feed['title_template'] = '<b>{username} ����վ������һ����</b>';
        $feed['title_data'] = array('username' => $cfg_ml->M_UserName);
        $feed['body_template'] = '<b>{subject}</b><br>{message}';
        $url = !strstr($artUrl,'http://') ? ($cfg_basehost.$artUrl) : $artUrl;
        $feed['body_data'] = array('subject' => "<a href=\"".$url."\">$title</a>", 'message' => cn_substr(strip_tags(preg_replace("/\[.+?\]/is", '', $description)), 150));        
        $feed['images'][] = array('url' => $cfg_basehost.'/images/scores.gif', 'link'=> $cfg_basehost);
        uc_feed_note($cfg_ml->M_LoginID,$feed);
        //ͬ������
        uc_credit_note($cfg_ml->M_LoginID, $cfg_sendarc_scores);
    }
    #/aip}}
    
    //��Ա��̬��¼
    $cfg_ml->RecordFeeds('addsoft',$title,$description,$arcID);
    
    ClearMyAddon($arcID, $title);
    
    //���سɹ���Ϣ
    $msg = "
        ��ѡ����ĺ���������
        <a href='soft_add.php?cid=$typeid'><u>������������</u></a>
        &nbsp;&nbsp;
        <a href='$artUrl' target='_blank'><u>�鿴����</u></a>
        &nbsp;&nbsp;
        <a href='soft_edit.php?channelid=$channelid&aid=$arcID'><u>��������</u></a>
        &nbsp;&nbsp;
        <a href='content_list.php?channelid={$channelid}'><u>�ѷ�����������</u></a>
        ";
    $wintitle = "�ɹ��������£�";
    $wecome_info = "��������::��������";
    $win = new OxWindow();
    $win->AddTitle("�ɹ�����������");
    $win->AddMsgItem($msg);
    $winform = $win->GetWindow("hand", "&nbsp;", FALSE);
    $win->Display();
}