<?php
/**
 * �ĵ����?��
 * 
 * @version        $Id: inc_archives_functions.php 1 13:52 2010��7��9��Z tianya $
 * @package        DedeCMS.Member
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
if(!defined('DEDEMEMBER')) exit('dedecms');
require_once(DEDEINC.'/image.func.php');
require_once(DEDEINC.'/archives.func.php');
require_once(DEDEINC."/userlogin.class.php");

//����û��Ƿ񱻽���
CheckNotAllow();

/**
 *  ���HTML����ⲿ��Դ�����ͼ��
 *
 * @param     string  $body  ����
 * @param     string  $rfurl  ��ַ
 * @param     string  $firstdd  ��һ������ͼ
 * @return    string 
 */
function GetCurContentAlbum($body,$rfurl,&$firstdd)
{
    global $cfg_multi_site,$cfg_basehost,$ddmaxwidth,$cfg_basedir,$pagestyle,$cfg_mb_rmdown,$title,$cfg_ml,$cfg_user_dir;
    include_once(DEDEINC."/dedecollection.func.php");
    if(empty($ddmaxwidth)) $ddmaxwidth = 240;
    $rsimg = '';
    $basehost = "http://".$_SERVER["HTTP_HOST"];
    $img_array = array();
    preg_match_all("/(src|SRC)=[\"|'| ]{0,}(http:\/\/([^>]*)\.(gif|jpg|png))/isU", $body, $img_array);
    $img_array = array_unique($img_array[2]);
    $imgUrl = $cfg_user_dir."/".$cfg_ml->M_ID;
    $imgPath = $cfg_basedir.$imgUrl;
    if(!is_dir($imgPath."/"))
    {
        MkdirAll($imgPath,$GLOBALS['cfg_dir_purview']);
        CloseFtp();
    }
    $milliSecond = MyDate("ymdHis",time());
    foreach($img_array as $key => $value)
    {
        if(preg_match("#".$basehost."#i", $value))
        {
            continue;
        }
        if($cfg_basehost!=$basehost && preg_match("#".$cfg_basehost."#i", $value))
        {
            continue;
        }
        if(!preg_match("#^http:\/\/#i", $value))
        {
            continue;
        }
        if($cfg_mb_rmdown=='Y')
        {
            $value = trim($value);
            $itype =  substr($value,-4,4);
            if(!preg_match("#\.(gif|jpg|png)#i", $itype)) $itype = ".jpg";
            $rndFileName = $imgPath."/".$milliSecond.$key.$itype;
            $iurl = $imgUrl."/".$milliSecond.$key.$itype;

            //���ز������ļ�
            //$rs = $htd->SaveToBin($rndFileName);
            $rs = DownImageKeep($value, $rfurl, $rndFileName, '', 0, 30);
            if($rs)
            {
                if($pagestyle > 2)
                {
                    $litpicname = GetImageMapDD($iurl,$ddmaxwidth);
                    if($litpicname!='') SaveUploadInfo($title,$litpicname,1,$addinfos);
                }
                else
                {
                    $litpicname = '';
                }
                if(empty($firstdd))
                {
                    $firstdd = $litpicname;
                    if(!file_exists($cfg_basedir.$firstdd)) $firstdd = $iurl;
                }
                @WaterImg($rndFileName,'down');
                $info = '';
                $imginfos = GetImageSize($rndFileName,$info);
                SaveUploadInfo($title,$iurl,1,$imginfos);
                $rsimg .= "{dede:img ddimg='$litpicname' text='' width='".$imginfos[0]."' height='".$imginfos[1]."'} $iurl {/dede:img}\r\n";
            }
        }
        else
        {
            $rsimg .= "{dede:img ddimg='$value' text='' width='0' height='0'} $value {/dede:img}\r\n";
        }
    }
    return $rsimg;
}

/**
 *  ͼ�����ͼ��Сͼ
 *
 * @param     string  $filename  �ļ���
 * @param     string  $ddm  ����ͼ
 * @param     string   $oldname  �ɵ����
 * @return    string
 */
function GetImageMapDD($filename, $ddm, $oldname='')
{
    if($oldname!='' && !preg_match("#^http:\/\/#i", $oldname))
    {
        $ddpicok = $oldname;
    }
    else
    {
        $ddn = substr($filename,-3);
        $ddpicok = preg_replace("#\.".$ddn."$#", "-lp.".$ddn, $filename);
    }
    $toFile = $GLOBALS['cfg_basedir'].$ddpicok;
    ImageResize($GLOBALS['cfg_basedir'].$filename, $ddm, 300, $toFile);
    return $ddpicok;
}

/**
 *  ���ϴ�����Ϣ���浽��ݿ�
 *
 * @param     string  $title  ����
 * @param     string  $filename  �ļ����
 * @param     string  $medaitype  ��������
 * @param     string  $addinfos  ������Ϣ
 * @return    string
 */
function SaveUploadInfo($title,$filename,$medaitype=1,$addinfos='')
{
    global $dsql,$cfg_ml,$cfg_basedir;
    if($filename=='')
    {
        return FALSE;
    }
    if(!is_array($addinfos))
    {
        $addinfos[0] = $addinfos[1] = $addinfos[2] = 0;
    }
    if($medaitype==1)
    {
        $info = '';
        $addinfos = GetImageSize($cfg_basedir.$filename,$info);
    }
    $addinfos[2] = @filesize($cfg_basedir.$filename);
    $row = $dsql->GetOne("SELECT aid,title,url FROM `#@__uploads` WHERE url LIKE '$filename' AND mid='".$cfg_ml->M_ID."'; ");
    $uptime = time();
    if(is_array($row))
    {
        $query = "UPDATE `#@__uploads` SET title='$title',mediatype='$medaitype',
                     width='{$addinfos[0]}',height='{$addinfos[1]}',filesize='{$addinfos[2]}',uptime='$uptime'
                     WHERE aid='{$row['aid']}'; ";
        $dsql->ExecuteNoneQuery($query);
    }
    else
    {
        $inquery = "INSERT INTO `#@__uploads`(title,url,mediatype,width,height,playtime,filesize,uptime,mid)
           VALUES ('$title','$filename','$medaitype','".$addinfos[0]."','".$addinfos[1]."','0','".$addinfos[2]."','$uptime','".$cfg_ml->M_ID."'); ";
        $dsql->ExecuteNoneQuery($inquery);
    }
    $fid = $dsql->GetLastID();
    AddMyAddon($fid, $filename);
    return TRUE;
}

/**
 *  ���һ�����ӱ?
 *
 * @param     object  $ctag
 * @return    string
 */
function GetFormItemA($ctag)
{
    return GetFormItem($ctag,'member');
}

/**
 *  ���?ͬ���͵����
 *
 * @param     string  $dvalue
 * @param     string  $dtype
 * @param     int  $aid
 * @param     string  $job
 * @param     string  $addvar
 * @return    string
 */
function GetFieldValueA($dvalue,$dtype,$aid=0,$job='add',$addvar='')
{
    return GetFieldValue($dvalue,$dtype,$aid,$job,$addvar,'member');
}

/**
 *  ��ô�ֵ�ı?(�༭ʱ��)
 *
 * @param     object  $ctag
 * @param     string  $fvalue  Ĭ��ֵ
 * @return    string
 */
function GetFormItemValueA($ctag,$fvalue)
{
    return GetFormItemValue($ctag,$fvalue,'member');
}

/**
 *  �����Զ���?(���ڷ���)
 *
 * @access    public
 * @param     string  $fieldset
 * @param     string  $loadtype
 * @param     bool    $isprint   �Ƿ��ӡ
 * @return    string
 */
function PrintAutoFieldsAdd(&$fieldset, $loadtype='all', $isprint=TRUE)
{
    global $cfg_cookie_encode;
    $dtp = new DedeTagParse();
    $dtp->SetNameSpace('field','<','>');
    $dtp->LoadSource($fieldset);
    $dede_addonfields = '';
    $addonfieldsname = '';
    if(is_array($dtp->CTags))
    {
        foreach($dtp->CTags as $tid=>$ctag)
        {
            if($loadtype!='autofield' ||  $ctag->GetAtt('autofield')==1 )
            {
                $dede_addonfields .= ( $dede_addonfields=="" ? $ctag->GetName().",".$ctag->GetAtt('type') : ";".$ctag->GetName().",".$ctag->GetAtt('type') );
                $addonfieldsname .= ",".$ctag->GetName();
                if ($isprint) echo  GetFormItemA($ctag);
            }
        }
    }
    if ($isprint) echo "<input type='hidden' name='dede_addonfields' value=\"".$dede_addonfields."\">\r\n";
    echo "<input type=\"hidden\" name=\"dede_fieldshash\" value=\"". md5($dede_addonfields . 'anythingelse' . $cfg_cookie_encode) ."\" />";
    // ����һ������
    return $addonfieldsname;
}

/**
 *  �����Զ���?(���ڱ༭)
 *
 * @param     string  $fieldset
 * @param     string  $fieldValues
 * @param     string  $loadtype
 * @return    string
 */
function PrintAutoFieldsEdit(&$fieldset, &$fieldValues, $loadtype='all')
{
    $dtp = new DedeTagParse();
    $dtp->SetNameSpace("field","<",">");
    $dtp->LoadSource($fieldset);
    $dede_addonfields = "";
    if(is_array($dtp->CTags))
    {
        foreach($dtp->CTags as $tid=>$ctag)
        {
            if($loadtype!='autofield'
            || ($loadtype=='autofield' && $ctag->GetAtt('autofield')==1) )
            {
                $dede_addonfields .= ( $dede_addonfields=='' ? $ctag->GetName().",".$ctag->GetAtt('type') : ";".$ctag->GetName().",".$ctag->GetAtt('type') );
                echo GetFormItemValueA($ctag,$fieldValues[$ctag->GetName()]);
            }
        }
    }
    echo "<input type='hidden' name='dede_addonfields' value=\"".$dede_addonfields."\">\r\n";
}

/**
 *  ����ָ��ID���ĵ�
 *
 * @param     int  $aid
 * @param     bool  $ismakesign
 * @return    string
 */
function MakeArt($aid, $ismakesign=FALSE)
{
    global $cfg_makeindex,$cfg_basedir,$cfg_templets_dir,$cfg_df_style;
    include_once(DEDEINC.'/arc.archives.class.php');
    if($ismakesign)
    {
        $envs['makesign'] = 'yes';
    }
    $arc = new Archives($aid);
    $reurl = $arc->MakeHtml();
    if(isset($typeid))
    {
        $preRow =  $arc->dsql->GetOne("SELECT id FROM `#@__arctiny` WHERE id<$aid AND arcrank>-1 AND typeid='$typeid' order by id desc");
        $nextRow = $arc->dsql->GetOne("SELECT id FROM `#@__arctiny` WHERE id>$aid AND arcrank>-1 AND typeid='$typeid' order by id asc");
        if(is_array($preRow))
        {
            $arc = new Archives($preRow['id']);
            $arc->MakeHtml();
        }
        if(is_array($nextRow))
        {
            $arc = new Archives($nextRow['id']);
            $arc->MakeHtml();
        }
    }
    return $reurl;
}

/**
 *  ����HTML�ı����Զ�ժҪ���Զ���ȡ����ͼ��
 *
 * @access    public
 * @param     string  $body  �ĵ�����
 * @param     string  $description  ����
 * @param     string  $dtype  ����
 * @return    string
 */
function AnalyseHtmlBody($body, &$description, $dtype='')
{
    global $cfg_mb_rmdown,$cfg_basehost,$cfg_auot_description,$arcID;
    $autolitpic = (empty($autolitpic) ? '' : $autolitpic);
    $body = stripslashes($body);

    //Զ��ͼƬ���ػ�
    if($cfg_mb_rmdown=='Y')
    {
        $body = GetCurContent($body);
    }

    //�Զ�ժҪ
    if($description=='' && $cfg_auot_description>0)
    {
        $description = cn_substr(html2text($body),$cfg_auot_description);
        $description = trim(preg_replace('/#p#|#e#/','',$description));
        $description = addslashes($description);
    }
    $body = addslashes($body);
    return $body;
}

/**
 *  �������body����ⲿ��Դ
 *
 * @access    public
 * @param     string  $body  ����
 * @return    string
 */
function GetCurContent(&$body)
{
    global $cfg_multi_site,$cfg_basehost,$cfg_basedir,$cfg_user_dir,$title,$cfg_ml;
    include_once(DEDEINC."/dedecollection.func.php");
    $htd = new DedeHttpDown();
    $basehost = "http://".$_SERVER["HTTP_HOST"];
    $img_array = array();
    preg_match_all("/(src|SRC)=[\"|'| ]{0,}(http:\/\/([^>]*)\.(gif|jpg|png))/isU",$body,$img_array);
    $img_array = array_unique($img_array[2]);
    $imgUrl = $cfg_user_dir."/".$cfg_ml->M_ID;
    $imgPath = $cfg_basedir.$imgUrl;
    if(!is_dir($imgPath."/"))
    {
        MkdirAll($imgPath,$GLOBALS['cfg_dir_purview']);
        CloseFtp();
    }
    $milliSecond = MyDate("ymdHis",time());
    foreach($img_array as $key=>$value)
    {
        if(preg_match("#".$basehost."#i", $value))
        {
            continue;
        }
        if($cfg_basehost!=$basehost && preg_match("#".$cfg_basehost."#i", $value))
        {
            continue;
        }
        if(!preg_match("#^http:\/\/#i", $value))
        {
            continue;
        }
        $htd->OpenUrl($value);
        $itype = $htd->GetHead("content-type");
        $itype = substr($value,-4,4);
        if(!preg_match("#\.(jpg|gif|png)#i", $itype))
        {
            if($itype=='image/gif')
            {
                $itype = ".gif";
            }
            else if($itype=='image/png')
            {
                $itype = ".png";
            }
            else
            {
                $itype = '.jpg';
            }
        }
        $milliSecondN = dd2char($milliSecond.'-'.mt_rand(1000,8000));
        $value = trim($value);
        $rndFileName = $imgPath."/".$milliSecondN.'-'.$key.$itype;
        $fileurl = $imgUrl."/".$milliSecondN.'-'.$key.$itype;
        $rs = $htd->SaveToBin($rndFileName);
        if($rs)
        {
            $body = str_replace($value,$fileurl,$body);
            @WaterImg($rndFileName,'down');
        }
        $info = '';
        $imginfos = GetImageSize($rndFileName,$info);
        SaveUploadInfo($title,$fileurl,1,$imginfos);
    }
    $htd->Close();
    return $body;
}

/**
 * �ϴ�һ��δ�������ͼƬ
 *
 * ����һ upname �ϴ������
 * ����� handurl �ֹ���д����ַ
 * ������ ddisremote �Ƿ�����Զ��ͼƬ 0 ����, 1 ����
 * ������ ntitle ע������ ���?�� title �ֶοɲ���
 *
 * @access    public
 * @param     string  $upname  �ϴ����
 * @param     string  $handurl  ������ַ
 * @param     int  $isremote  �Ƿ�Զ��
 * @param     string  $ntitle  ע������
 * @return    string
 */
function UploadOneImage($upname,$handurl='',$isremote=1,$ntitle='')
{
    global $cfg_ml,$cfg_basedir,$cfg_image_dir,$dsql,$title, $dsql;
    if($ntitle!='')
    {
        $title = $ntitle;
    }
    $ntime = time();
    $filename = '';
    $isrm_up = false;
    $handurl = trim($handurl);
    //����û������ϴ���ͼƬ
    if(!empty($_FILES[$upname]['tmp_name']) && is_uploaded_file($_FILES[$upname]['tmp_name']))
    {
        $istype = 0;
        $sparr = Array("image/pjpeg","image/jpeg","image/gif","image/png");
        $_FILES[$upname]['type'] = strtolower(trim($_FILES[$upname]['type']));
        if(!in_array($_FILES[$upname]['type'],$sparr))
        {
            ShowMsg("�ϴ���ͼƬ��ʽ������ʹ��JPEG��GIF��PNG��ʽ������һ�֣�","-1");
            exit();
        }
        if(!empty($handurl) && !preg_match("#^http:\/\/#", $handurl) && file_exists($cfg_basedir.$handurl) )
        {
            $dsql->ExecuteNoneQuery("Delete From #@__uploads where url like '$handurl' ");
            $fullUrl = preg_replace("#\.([a-z]*)$#i", "", $handurl);
        }
        else
        {
            $savepath = $cfg_image_dir."/".strftime("%Y-%m",$ntime);
            CreateDir($savepath);
            $fullUrl = $savepath."/".strftime("%d",$ntime).dd2char(strftime("%H%M%S",$ntime).'0'.$cfg_ml->M_ID.'0'.mt_rand(1000,9999));
        }
        if(strtolower($_FILES[$upname]['type'])=="image/gif")
        {
            $fullUrl = $fullUrl.".gif";
        }
        else if(strtolower($_FILES[$upname]['type'])=="image/png")
        {
            $fullUrl = $fullUrl.".png";
        }
        else
        {
            $fullUrl = $fullUrl.".jpg";
        }

        //����
        @move_uploaded_file($_FILES[$upname]['tmp_name'],$cfg_basedir.$fullUrl);
        $filename = $fullUrl;

        //ˮӡ
        @WaterImg($imgfile,'up');
        $isrm_up = TRUE;
    }

    //Զ�̻�ѡ�񱾵�ͼƬ
    else{
        if($handurl=='')
        {
            return '';
        }

        //Զ��ͼƬ��Ҫ�󱾵ػ�
        if($isremote==1 && preg_match("#^http:\/\/#", $handurl))
        {
            $ddinfos = GetRemoteImage($handurl,$cuserLogin->getUserID());
            if(!is_array($ddinfos))
            {
                $litpic = "";
            }
            else
            {
                $filename = $ddinfos[0];
            }
            $isrm_up = TRUE;

            //����ͼƬ��Զ�̲�Ҫ�󱾵ػ�
        }
        else
        {
            $filename = $handurl;
        }
    }
    $imgfile = $cfg_basedir.$filename;
    if(is_file($imgfile) && $isrm_up && $filename!='')
    {
        $info = "";
        $imginfos = GetImageSize($imgfile,$info);

        //�����ϴ���ͼƬ��Ϣ���浽ý���ĵ����?����
        $inquery = "
        INSERT INTO #@__uploads(title,url,mediatype,width,height,playtime,filesize,uptime,mid)
        VALUES ('$title','$filename','1','".$imginfos[0]."','".$imginfos[1]."','0','".filesize($imgfile)."','".time()."','".$cfg_ml->M_ID."');
    ";
        $dsql->ExecuteNoneQuery($inquery);
    }
    $fid = $dsql->GetLastID();
    AddMyAddon($fid, $filename);
    return $filename;
}