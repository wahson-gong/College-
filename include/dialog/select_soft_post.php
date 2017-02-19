<?php
/**
 * �������
 *
 * @version        $Id: select_soft_post.php 1 9:43 2010��7��8��Z tianya $
 * @package        DedeCMS.Dialog
 * @copyright      Copyright (c) 2007 - 2010, DesDev, Inc.
 * @license        http://help.dedecms.com/usersguide/license.html
 * @link           http://www.dedecms.com
 */
if(!isset($cfg_basedir))
{
    include_once(dirname(__FILE__).'/config.php');
}
if(empty($uploadfile)) $uploadfile = '';
if(empty($uploadmbtype)) $uploadmbtype = '�������';
if(empty($bkurl)) $bkurl = 'select_soft.php';
$CKEditorFuncNum = (isset($CKEditorFuncNum))? $CKEditorFuncNum : 1;
$newname = ( empty($newname) ? '' : preg_replace("#[\\ \"\*\?\t\r\n<>':\/|]#", "", $newname) );

if(!is_uploaded_file($uploadfile))
{
    ShowMsg("��û��ѡ���ϴ����ļ���ѡ����ļ���С��������!", "-1");
    exit();
}

//�����������֧�ֵĸ���
$cfg_softtype = $cfg_softtype;
$cfg_softtype = str_replace('||', '|', $cfg_softtype);
$uploadfile_name = trim(preg_replace("#[ \r\n\t\*\%\\\/\?><\|\":]{1,}#", '', $uploadfile_name));
if(!preg_match("#\.(".$cfg_softtype.")#i", $uploadfile_name))
{
    ShowMsg("�����ϴ���{$uploadmbtype}��������б?����ϵͳ����չ���޶������ã�","");
    exit();
}

$nowtme = time();
if($activepath==$cfg_soft_dir)
{
    $newdir = MyDate($cfg_addon_savetype, $nowtme);
    $activepath = $activepath.'/'.$newdir;
    if(!is_dir($cfg_basedir.$activepath))
    {
        MkdirAll($cfg_basedir.$activepath,$cfg_dir_purview);
        CloseFtp();
    }
}

//�ļ���ǰΪ�ֹ�ָ���� �����Զ����?
if(!empty($newname))
{
    $filename = $newname;
    if(!preg_match("#\.#", $filename)) $fs = explode('.', $uploadfile_name);
    else $fs = explode('.', $filename);
    if(preg_match("#".$cfg_not_allowall."#", $fs[count($fs)-1]))
    {
        ShowMsg("��ָ�����ļ���ϵͳ��ֹ��",'javascript:;');
        exit();
    }
    if(!preg_match("#\.#", $filename)) $filename = $filename.'.'.$fs[count($fs)-1];
}else{
    $filename = $cuserLogin->getUserID().'-'.dd2char(MyDate('ymdHis',$nowtme));
    $fs = explode('.', $uploadfile_name);
    if(preg_match("#".$cfg_not_allowall."#", $fs[count($fs)-1]))
    {
        ShowMsg("���ϴ���ĳЩ���ܴ��ڲ���ȫ���ص��ļ���ϵͳ�ܾ������",'javascript:;');
        exit();
    }
    $filename = $filename.'.'.$fs[count($fs)-1];
}

if (preg_match('#.(php|pl|cgi|asp|aspx|jsp|php5|php4|php3|shtm|shtml)[^a-zA-Z0-9]+$#i', trim($filename))) { ShowMsg("你指定的文件名被系统禁止！",'javascript:;'); exit(); } $fullfilename = $cfg_basedir.$activepath.'/'.$filename;;
$fullfileurl = $activepath.'/'.$filename;
echo $activepath;
exit;
move_uploaded_file($uploadfile,$fullfilename) or die("�ϴ��ļ��� $fullfilename ʧ�ܣ�");
@unlink($uploadfile);
if($cfg_remote_site=='Y' && $remoteuploads == 1)
{
    //����Զ���ļ�·��
    $remotefile = str_replace(DEDEROOT, '', $fullfilename);
    $localfile = '../..'.$remotefile;
    //����Զ���ļ���
    $remotedir = preg_replace('/[^\/]*\.('.$cfg_softtype.')/', '', $remotefile);
    $ftp->rmkdir($remotedir);
    $ftp->upload($localfile, $remotefile);
}

if($uploadfile_type == 'application/x-shockwave-flash')
{
    $mediatype=2;
}
else if(preg_match('#image#i', $uploadfile_type))
{
    $mediatype=1;
}
else if(preg_match('#audio|media|video#i', $uploadfile_type))
{
    $mediatype=3;
}
else
{
    $mediatype=4;
}

$inquery = "INSERT INTO `#@__uploads`(arcid,title,url,mediatype,width,height,playtime,filesize,uptime,mid)
   VALUES ('0','$filename','$fullfileurl','$mediatype','0','0','0','{$uploadfile_size}','{$nowtme}','".$cuserLogin->getUserID()."'); ";

$dsql->ExecuteNoneQuery($inquery);
$fid = $dsql->GetLastID();
AddMyAddon($fid, $fullfileurl);

ShowMsg("�ɹ��ϴ��ļ���",$bkurl."?comeback=".urlencode($filename)."&f=$f&CKEditorFuncNum=$CKEditorFuncNum&activepath=".urlencode($activepath)."&d=".time());
exit();